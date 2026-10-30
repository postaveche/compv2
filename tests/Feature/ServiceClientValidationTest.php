<?php

namespace Tests\Feature;

use App\Models\ServiceClient;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ServiceClientValidationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        require_once database_path('migrations/2025_04_01_000001_create_service_clients_table.php');
        (new \CreateServiceClientsTable)->up();
        $this->withoutMiddleware();
    }

    public function test_phone_formats_cannot_create_duplicate_clients(): void
    {
        foreach (['069123456', '37369123456', '+373 69 123 456'] as $stored) {
            ServiceClient::query()->delete();
            ServiceClient::create(['name' => 'Existing', 'phone' => $stored]);
            foreach (['069123456', '37369123456', '+373 (69) 123-456'] as $phone) {
                $this->postJson(route('service.clients.store'), ['name' => 'Duplicate', 'phone' => $phone])
                    ->assertStatus(422)->assertJsonValidationErrors('phone');
                $this->assertSame(1, ServiceClient::count());
            }
        }
    }

    public function test_email_duplicates_are_case_insensitive(): void
    {
        ServiceClient::create(['name' => 'Existing', 'phone' => '069123456', 'email' => 'Client@Example.com']);
        $this->postJson(route('service.clients.store'), [
            'name' => 'Duplicate', 'phone' => '068123456', 'email' => 'client@example.com',
        ])->assertStatus(422)->assertJsonValidationErrors('email');
        $this->assertSame(1, ServiceClient::count());
    }

    public function test_edit_allows_own_details_but_rejects_another_clients_phone(): void
    {
        $client = ServiceClient::create(['name' => 'Existing', 'phone' => '069123456', 'email' => 'client@example.com']);
        $this->putJson(route('service.clients.update', $client->id), [
            'name' => 'Updated', 'phone' => '+37369123456', 'email' => 'CLIENT@example.com',
        ])->assertRedirect(route('service.clients'));
        ServiceClient::create(['name' => 'Other', 'phone' => '068123456']);
        $this->putJson(route('service.clients.update', $client->id), [
            'name' => 'Updated', 'phone' => '37368123456',
        ])->assertStatus(422)->assertJsonValidationErrors('phone');
    }

    public function test_clients_can_be_created_with_distinct_phones_and_no_email(): void
    {
        foreach (['069123456', '068123456'] as $phone) {
            $this->post(route('service.clients.store'), ['name' => 'New', 'phone' => $phone])
                ->assertRedirect(route('service.clients'));
        }
        $this->assertSame(2, ServiceClient::count());
    }
}
