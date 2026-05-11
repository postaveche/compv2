<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\HostingInvoice;
use App\Models\HostingPackage;
use App\Models\HostingService;
use App\Models\ServiceClient;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class HostingController extends Controller
{
    public function index(Request $request)
    {
        $this->syncActiveStatusByExpiration();

        $this->generateInvoicesForExpiringServices();

        $query = HostingService::with('client', 'package', 'latestInvoice')
            ->orderBy('payment_due_at')
            ->orderBy('expires_at');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('paid')) {
            $query->where('is_paid', $request->paid);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('domain', 'LIKE', "%{$search}%")
                    ->orWhereHas('client', function ($cq) use ($search) {
                        $cq->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('phone', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                    });
            });
        }

        $services = $query->paginate(25);
        $types = HostingService::typeList();

        return view('admin.hosting.index', compact('services', 'types'));
    }

    public function create()
    {
        return view('admin.hosting.form', [
            'service' => null,
            'clients' => ServiceClient::orderBy('name')->get(),
            'packages' => HostingPackage::where('active', true)->orderBy('name')->get(),
            'types' => HostingService::typeList(),
        ]);
    }

    public function store(Request $request)
    {
        HostingService::create($this->validatedServiceData($request));

        return redirect()->route('hosting.index')->with('success', 'Serviciu adaugat!');
    }

    public function edit($id)
    {
        return view('admin.hosting.form', [
            'service' => HostingService::findOrFail($id),
            'clients' => ServiceClient::orderBy('name')->get(),
            'packages' => HostingPackage::where('active', true)->orderBy('name')->get(),
            'types' => HostingService::typeList(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $service = HostingService::findOrFail($id);
        $data = $this->validatedServiceData($request);
        $data['is_paid'] = $request->has('is_paid');
        $data['active'] = $request->has('active');
        $service->update($data);

        return redirect()->route('hosting.index')->with('success', 'Serviciu actualizat!');
    }

    public function destroy($id)
    {
        HostingService::findOrFail($id)->delete();

        return redirect()->route('hosting.index')->with('success', 'Serviciu sters!');
    }

    public function markPaid($id)
    {
        $service = HostingService::findOrFail($id);
        $service->ensurePaymentInvoice()->update([
            'status' => 'paid',
            'paid_at' => now()->toDateString(),
        ]);

        $service->update([
            'expires_at' => $service->expires_at->copy()->addYear(),
            'payment_due_at' => $service->payment_due_at->copy()->addYear(),
            'active' => true,
            'is_paid' => false,
            'last_notified_at' => null,
        ]);

        return redirect()->route('hosting.index')->with('success', 'Achitarea a fost inregistrata si serviciul a fost prelungit cu un an!');
    }

    public function sendReminder($id)
    {
        $service = HostingService::with('client', 'package')->findOrFail($id);
        $invoice = $service->expires_at->lte(now()->addDays(30)->startOfDay())
            ? $service->ensurePaymentInvoice()
            : null;
        TelegramService::notifyHostingPayment($service, $invoice);
        $service->update(['last_notified_at' => now()->toDateString()]);

        return redirect()->route('hosting.index')->with('success', 'Notificare trimisa in Telegram!');
    }

    public function generateInvoice($id)
    {
        $service = HostingService::findOrFail($id);

        if ($service->expires_at->gt(now()->addDays(30)->startOfDay())) {
            return redirect()->route('hosting.index')->with('danger', 'Contul de plata se poate genera doar cu 30 zile inainte de expirare.');
        }

        $invoice = $service->ensurePaymentInvoice();

        return redirect()->route('hosting.invoices.show', $invoice->id);
    }

    public function invoice($id)
    {
        $invoice = HostingInvoice::with('service.package', 'client')->findOrFail($id);

        return view('admin.hosting.invoice', compact('invoice'));
    }

    public function packages()
    {
        $packages = HostingPackage::orderBy('name')->get();

        return view('admin.hosting.packages', compact('packages'));
    }

    public function storePackage(Request $request)
    {
        HostingPackage::create($this->validatedPackageData($request));

        return redirect()->route('hosting.packages')->with('success', 'Pachet adaugat!');
    }

    public function updatePackage(Request $request, $id)
    {
        $package = HostingPackage::findOrFail($id);
        $data = $this->validatedPackageData($request);
        $data['active'] = $request->has('active');
        $package->update($data);

        return redirect()->route('hosting.packages')->with('success', 'Pachet actualizat!');
    }

    public function deletePackage($id)
    {
        HostingPackage::findOrFail($id)->delete();

        return redirect()->route('hosting.packages')->with('success', 'Pachet sters!');
    }

    private function validatedServiceData(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:service_clients,id',
            'hosting_package_id' => 'nullable|exists:hosting_packages,id',
            'type' => 'required|in:hosting,domain',
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
            'registrar' => 'nullable|string|max:255',
            'server' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:EUR,USD,MDL',
            'started_at' => 'nullable|date',
            'expires_at' => 'required|date',
            'payment_due_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $data['is_paid'] = $request->has('is_paid');
        $data['active'] = !now()->startOfDay()->gt(\Carbon\Carbon::parse($data['expires_at'])->startOfDay());

        return $data;
    }

    private function validatedPackageData(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:EUR,USD,MDL',
            'period' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);
        $data['active'] = $request->has('active') || !$request->isMethod('put');

        return $data;
    }

    private function syncActiveStatusByExpiration()
    {
        $today = now()->toDateString();

        HostingService::whereDate('expires_at', '<', $today)
            ->where('active', true)
            ->update(['active' => false]);

        HostingService::whereDate('expires_at', '>=', $today)
            ->where('active', false)
            ->update(['active' => true]);
    }

    private function generateInvoicesForExpiringServices()
    {
        HostingService::where('active', true)
            ->where('is_paid', false)
            ->whereDate('expires_at', '<=', now()->addDays(30)->toDateString())
            ->get()
            ->each(function (HostingService $service) {
                $service->ensurePaymentInvoice();
            });
    }
}
