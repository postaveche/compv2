<?php

namespace Tests\Feature;

use App\Models\CashEntry;
use App\Models\ServiceClient;
use App\Models\ServiceOrder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Tests\TestCase;

class CashRegisterTest extends TestCase
{
    private $user;
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'cash.password' => 'cash-test-password']);
        DB::purge('sqlite');
        foreach ([
            '2014_10_12_000000_create_users_table.php' => 'CreateUsersTable',
            '2025_04_01_000001_create_service_clients_table.php' => 'CreateServiceClientsTable',
            '2025_04_01_000002_create_service_orders_table.php' => 'CreateServiceOrdersTable',
            '2025_04_01_000003_create_device_types_table.php' => 'CreateDeviceTypesTable',
            '2025_04_01_000004_create_service_photos_table.php' => 'CreateServicePhotosTable',
            '2025_04_01_000005_add_parent_order_to_service_orders.php' => 'AddParentOrderToServiceOrders',
            '2025_04_01_000006_add_advance_to_service_orders.php' => 'AddAdvanceToServiceOrders',
            '2025_04_01_000007_add_warranty_repair_fields_to_service_orders.php' => 'AddWarrantyRepairFieldsToServiceOrders',
            '2025_04_01_000010_create_telegram_settings_table.php' => 'CreateTelegramSettingsTable',
            '2026_09_28_000001_create_cash_entries_table.php' => 'CreateCashEntriesTable',
        ] as $file => $class) {
            require_once database_path('migrations/'.$file);
            (new $class)->up();
        }
        $this->user = User::create(['name' => 'Operator test', 'email' => 'cash-test@example.test', 'password' => bcrypt('test')]);
        $this->client = ServiceClient::create(['name' => 'Client test', 'phone' => '060000000']);
        $this->actingAs($this->user);
        \App\Models\TelegramSettings::create(['active' => false, 'notify_new_order' => false, 'notify_status_change' => false]);
    }

    private function unlockCash(): void
    {
        $this->post(route('cash.authenticate'), ['password' => 'cash-test-password'])->assertRedirect(route('cash.index'));
    }

    private function order(array $extra = []): ServiceOrder
    {
        return ServiceOrder::create(array_merge([
            'order_number' => 'SC-TEST-1', 'client_id' => $this->client->id,
            'device_type' => 'Laptop', 'problem_description' => 'Test', 'status' => 'received',
        ], $extra));
    }

    private function payment(array $extra = []): array
    {
        return array_merge([
            'client_id' => $this->client->id, 'description' => 'Serviciu test', 'amount' => '125.50',
            'payment_method' => 'cash', 'paid_at' => '2026-09-28T14:30', 'submission_token' => (string) Str::uuid(),
        ], $extra);
    }

    public function test_locked_routes_reject_reads_and_writes()
    {
        $this->get(route('cash.index'))->assertRedirect(route('cash.unlock'));
        $this->post(route('cash.store'), $this->payment())->assertRedirect(route('cash.unlock'));
        $this->assertSame(0, CashEntry::count());
        $this->get(route('cash.unlock'))->assertOk()->assertSee('Acces protejat');
    }

    public function test_wrong_password_returns_exactly_an_empty_page_and_revokes_access()
    {
        $this->unlockCash();
        $response = $this->post(route('cash.authenticate'), ['password' => 'wrong']);
        $response->assertOk();
        $this->assertSame('', $response->getContent());
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertFalse(session()->has('cash'));
        $this->get(route('cash.index'))->assertRedirect(route('cash.unlock'));
    }

    public function test_correct_password_unlocks_and_password_changes_invalidate_access()
    {
        $this->unlockCash();
        $this->get(route('cash.index'))->assertOk()->assertSee('Încasare nouă');
        config(['cash.password' => 'changed-password']);
        $this->get(route('cash.index'))->assertRedirect(route('cash.unlock'));
        config(['cash.password' => '']);
        $this->assertSame('', $this->post(route('cash.authenticate'), ['password' => ''])->getContent());
    }

    public function test_expiry_and_manual_lock_protect_the_page()
    {
        $this->unlockCash();
        $this->withSession(['cash.expires_at' => time() - 1])->get(route('cash.index'))->assertRedirect(route('cash.unlock'));
        $this->unlockCash();
        $this->post(route('cash.lock'))->assertRedirect(route('cash.unlock'));
        $this->get(route('cash.index'))->assertRedirect(route('cash.unlock'));
    }

    public function test_repeated_wrong_passwords_are_rate_limited_to_blank_pages()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->assertSame('', $this->post(route('cash.authenticate'), ['password' => 'wrong'])->getContent());
        }
        $this->assertSame('', $this->post(route('cash.authenticate'), ['password' => 'cash-test-password'])->getContent());
        $this->assertFalse(session()->has('cash'));
        RateLimiter::clear('cash-unlock:'.$this->user->id.':127.0.0.1');
    }

    public function test_manual_receipts_are_idempotent_and_filterable()
    {
        $this->unlockCash();
        foreach (['cash', 'receipt', 'transfer'] as $method) {
            $data = $this->payment(['payment_method' => $method]);
            $this->post(route('cash.store'), $data)->assertRedirect(route('cash.index'));
            $this->post(route('cash.store'), $data)->assertRedirect(route('cash.index'));
        }
        $this->assertSame(3, CashEntry::count());
        $this->assertEquals(376.50, CashEntry::sum('amount'));
        $this->assertSame('2026-09-28 14:30', CashEntry::first()->paid_at->format('Y-m-d H:i'));
        $this->get(route('cash.index', ['payment_method' => 'transfer', 'to' => '2026-09-28']))
            ->assertOk()->assertViewHas('entries', function ($entries) { return $entries->total() === 1; })
            ->assertViewHas('totals', function ($totals) { return (float) $totals->sum() === 125.50; });
    }

    public function test_invalid_manual_payment_does_not_create_a_receipt()
    {
        $this->unlockCash();
        $this->postJson(route('cash.store'), $this->payment(['amount' => '-1', 'client_id' => 999, 'payment_method' => 'invalid']))
            ->assertStatus(422)->assertJsonValidationErrors(['amount', 'client_id', 'payment_method']);
        $this->assertSame(0, CashEntry::count());
    }

    public function test_advance_and_paid_checkbox_record_only_the_remaining_balance_once()
    {
        $order = $this->order();
        $base = ['status' => 'received', 'final_price' => '1000.00', 'advance_payment' => '200.00', 'payment_method' => 'cash'];
        $this->put(route('service.update', $order->id), $base)->assertSessionHasNoErrors();
        $this->assertEquals(200, CashEntry::whereNull('voided_at')->sum('amount'));
        $paid = array_merge($base, ['is_paid' => 1, 'payment_method' => 'transfer']);
        $this->put(route('service.update', $order->id), $paid)->assertSessionHasNoErrors();
        $this->put(route('service.update', $order->id), $paid)->assertSessionHasNoErrors();
        $this->assertSame(2, CashEntry::count());
        $this->assertEquals(1000, CashEntry::whereNull('voided_at')->sum('amount'));
        $this->assertEquals(800, CashEntry::where('source_type', 'repair')->first()->amount);
        $this->assertSame('transfer', CashEntry::where('source_type', 'repair')->first()->payment_method);
        $this->assertTrue($order->fresh()->is_paid);
    }

    public function test_unchecking_and_rechecking_keeps_history_without_double_counting()
    {
        $order = $this->order();
        $base = ['status' => 'received', 'final_price' => '100', 'payment_method' => 'cash'];
        $this->put(route('service.update', $order->id), $base + ['is_paid' => 1])->assertSessionHasNoErrors();
        $this->put(route('service.update', $order->id), $base)->assertSessionHasNoErrors();
        $this->assertSame(1, CashEntry::whereNotNull('voided_at')->count());
        $this->assertEquals(0, CashEntry::whereNull('voided_at')->sum('amount'));
        $this->put(route('service.update', $order->id), $base + ['is_paid' => 1])->assertSessionHasNoErrors();
        $this->assertSame(2, CashEntry::count());
        $this->assertEquals(100, CashEntry::whereNull('voided_at')->sum('amount'));
    }

    public function test_missing_method_rolls_back_the_order_and_paid_flag()
    {
        $order = $this->order();
        $this->putJson(route('service.update', $order->id), ['status' => 'received', 'final_price' => '100', 'is_paid' => 1])
            ->assertStatus(422)->assertJsonValidationErrors('payment_method');
        $this->assertFalse($order->fresh()->is_paid);
        $this->assertNull($order->fresh()->final_price);
        $this->assertSame(0, CashEntry::count());
    }

    public function test_existing_paid_orders_are_not_imported_on_unrelated_edits()
    {
        $order = $this->order(['final_price' => 100, 'advance_payment' => 20, 'is_paid' => true]);
        $this->put(route('service.update', $order->id), ['status' => 'received', 'final_price' => 100, 'advance_payment' => 20, 'is_paid' => 1, 'notes' => 'Changed'])
            ->assertSessionHasNoErrors();
        $this->assertSame(0, CashEntry::count());
    }

    public function test_paid_requires_a_final_price_and_diagnosis_is_recorded_separately()
    {
        $order = $this->order();
        $this->putJson(route('service.update', $order->id), ['is_paid' => 1])->assertStatus(422)->assertJsonValidationErrors('final_price');
        $this->put(route('service.update', $order->id), ['status' => 'received', 'diagnosis_fee' => 150, 'diagnosis_fee_paid' => 1, 'payment_method' => 'receipt'])
            ->assertSessionHasNoErrors();
        $this->assertSame('diagnosis', CashEntry::first()->source_type);
        $this->assertEquals(150, CashEntry::first()->amount);
    }

    public function test_new_order_advance_is_saved_atomically_without_unlocking_cash()
    {
        $data = ['client_id' => $this->client->id, 'device_type' => 'Laptop', 'problem_description' => 'Test', 'advance_payment' => '75.25'];
        $this->postJson(route('service.store'), $data)->assertStatus(422)->assertJsonValidationErrors('payment_method');
        $this->assertSame(0, ServiceOrder::count());
        $this->post(route('service.store'), $data + ['payment_method' => 'receipt', 'payment_received_at' => '2026-09-28T10:15'])->assertSessionHasNoErrors();
        $this->assertSame(1, ServiceOrder::count());
        $this->assertSame(1, CashEntry::count());
        $this->assertEquals(75.25, CashEntry::first()->amount);
        $this->assertSame('2026-09-28 10:15', CashEntry::first()->paid_at->format('Y-m-d H:i'));
    }

    public function test_amount_correction_preserves_the_old_receipt_and_filters_exclude_it()
    {
        $order = $this->order();
        $base = ['status' => 'received', 'is_paid' => 1, 'payment_method' => 'cash'];
        $this->put(route('service.update', $order->id), $base + ['final_price' => 100])->assertSessionHasNoErrors();
        $this->put(route('service.update', $order->id), $base + ['final_price' => 120])->assertSessionHasNoErrors();
        $this->assertSame(2, CashEntry::count());
        $this->assertEquals(100, CashEntry::whereNotNull('voided_at')->first()->amount);
        $this->unlockCash();
        $this->get(route('cash.index'))->assertOk()
            ->assertViewHas('entries', function ($entries) { return $entries->total() === 1; })
            ->assertViewHas('totals', function ($totals) { return (float) $totals->sum() === 120.0; });
        $this->get(route('cash.index', ['show_voided' => 1]))->assertOk()
            ->assertViewHas('entries', function ($entries) { return $entries->total() === 2; });
    }

    public function test_cash_access_is_bound_to_the_authenticated_user()
    {
        $this->unlockCash();
        $other = User::create(['name' => 'Other', 'email' => 'other@example.test', 'password' => bcrypt('test')]);
        $this->actingAs($other)->get(route('cash.index'))->assertRedirect(route('cash.unlock'));
    }

    public function test_deleting_a_service_order_does_not_delete_received_money()
    {
        $order = $this->order();
        $this->put(route('service.update', $order->id), ['status' => 'received', 'is_paid' => 1, 'final_price' => 100, 'payment_method' => 'cash'])->assertSessionHasNoErrors();
        $order->delete();
        $this->assertSame(1, CashEntry::count());
        $this->assertNull(CashEntry::first()->service_order_id);
        $this->assertEquals(100, CashEntry::whereNull('voided_at')->sum('amount'));
    }

    public function test_rendered_edit_form_can_save_a_cash_payment()
    {
        $order = $this->order(['final_price' => '250.00']);
        $page = $this->get(route('service.edit', $order->id))->assertOk();
        $dom = new \DOMDocument();
        @$dom->loadHTML($page->getContent());
        $xpath = new \DOMXPath($dom);
        $form = $xpath->query('//form[.//input[@name="_method" and @value="PUT"]]')->item(0);
        $this->assertNotNull($form);
        $data = [];
        foreach ($xpath->query('.//input[@name] | .//select[@name] | .//textarea[@name]', $form) as $field) {
            $name = $field->getAttribute('name');
            if ($field->tagName === 'select') {
                $selected = $xpath->query('.//option[@selected]', $field)->item(0) ?? $field->getElementsByTagName('option')->item(0);
                $data[$name] = $selected->hasAttribute('value') ? $selected->getAttribute('value') : $selected->textContent;
            } elseif ($field->tagName === 'textarea') {
                $data[$name] = $field->textContent;
            } elseif ($field->getAttribute('type') !== 'checkbox' || $field->hasAttribute('checked')) {
                $data[$name] = $field->getAttribute('value');
            }
        }
        $data['is_paid'] = '1';
        $data['payment_method'] = 'cash';
        $this->put(route('service.update', $order->id), $data)
            ->assertRedirect(route('service.show', $order->id))->assertSessionHasNoErrors();
        $this->assertTrue($order->fresh()->is_paid);
        $this->assertEquals(250, CashEntry::whereNull('voided_at')->sum('amount'));
    }
}
