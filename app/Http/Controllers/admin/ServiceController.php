<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceType;
use App\Models\ServiceClient;
use App\Models\ServiceOrder;
use App\Models\ServicePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\TelegramService;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceOrder::with('client')->orderBy('id', 'DESC');

        $showAll = $request->has('show_all')
            ? $request->boolean('show_all')
            : (bool) $request->cookie('service_show_all', false);

        if (!$showAll) {
            $query->whereIn('status', ServiceOrder::activeStatuses());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('order_number', 'LIKE', "%{$s}%")
                  ->orWhere('device_brand', 'LIKE', "%{$s}%")
                  ->orWhere('device_model', 'LIKE', "%{$s}%")
                  ->orWhere('serial_number', 'LIKE', "%{$s}%")
                  ->orWhereHas('client', function($cq) use ($s) {
                      $cq->where('name', 'LIKE', "%{$s}%")->orWhere('phone', 'LIKE', "%{$s}%");
                  });
            });
        }
        $orders = $query->paginate(25);
        $statuses = ServiceOrder::statusList();

        if ($request->has('show_all')) {
            Cookie::queue('service_show_all', $showAll ? '1' : '0', 60 * 24 * 365);
        }

        return view('admin.service.index', compact('orders', 'statuses', 'showAll'));
    }

    public function create()
    {
        $clients = ServiceClient::orderBy('name')->get();
        $statuses = ServiceOrder::statusList();
        $deviceTypes = DeviceType::orderBy('name')->get();
        return view('admin.service.create', compact('clients', 'statuses', 'deviceTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:service_clients,id',
            'device_type' => 'required|string',
            'problem_description' => 'required|string',
            'photos.*' => 'image|max:5120',
        ]);
        $data = $request->all();
        $data['order_number'] = ServiceOrder::generateOrderNumber();
        $data['status'] = 'received';
        $data['received_by'] = Auth::id();
        $order = ServiceOrder::create($data);
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $name = $order->order_number . '_' . time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/service', $name);
                ServicePhoto::create(['order_id' => $order->id, 'image' => $name, 'stage' => 'received']);
            }
        }
        $this->sendNewOrderNotification($order->id);
        return redirect()->route('service.show', $order->id)->with('success', 'Comanda creata: ' . $order->order_number);
    }

    // Telegram: notificare comanda noua
    private function sendNewOrderNotification($orderId)
    {
        $order = ServiceOrder::with('client')->find($orderId);
        if ($order) TelegramService::notifyNewOrder($order);
    }

    public function show($id)
    {
        $order = ServiceOrder::with('client', 'receivedBy', 'photos', 'parentOrder', 'returnOrders')->findOrFail($id);
        $statuses = ServiceOrder::statusList();
        return view('admin.service.show', compact('order', 'statuses'));
    }

    public function edit($id)
    {
        $order = ServiceOrder::with('client', 'photos')->findOrFail($id);
        $clients = ServiceClient::orderBy('name')->get();
        $statuses = ServiceOrder::statusList();
        $deviceTypes = DeviceType::orderBy('name')->get();
        return view('admin.service.edit', compact('order', 'clients', 'statuses', 'deviceTypes'));
    }

    public function update(Request $request, $id)
    {
        $order = ServiceOrder::findOrFail($id);
        $oldStatus = $order->status;
        $data = $request->all();
        if ($request->status == 'repaired' && $order->status != 'repaired') { $data['completed_at'] = now(); }
        if ($request->status == 'delivered' && $order->status != 'delivered') { $data['delivered_at'] = now(); }
        $data['is_paid'] = $request->has('is_paid') ? 1 : 0;
        $data['warranty'] = $request->has('warranty') ? 1 : 0;
        $data['is_warranty_repair'] = $request->has('is_warranty_repair') ? 1 : 0;
        $data['diagnosis_fee_paid'] = $request->has('diagnosis_fee_paid') ? 1 : 0;
        $order->update($data);

        if ($oldStatus != $order->status) {
            $order->load('client');
            TelegramService::notifyStatusChange($order, $oldStatus);
        }

        return redirect()->route('service.show', $id)->with('success', 'Actualizat!');
    }

    public function destroy($id)
    {
        ServiceOrder::findOrFail($id)->delete();
        return redirect()->route('service.index')->with('success', 'Sters!');
    }

    public function printReceipt($id)
    {
        $order = ServiceOrder::with('client', 'receivedBy', 'parentOrder')->findOrFail($id);
        return view('admin.service.receipt', compact('order'));
    }

    public function downloadPdf($id)
    {
        $order = ServiceOrder::with('client', 'receivedBy', 'parentOrder')->findOrFail($id);
        $pdf = Pdf::loadView('admin.service.receipt_pdf', compact('order'));
        return $pdf->download('Act_primire_' . $order->order_number . '.pdf');
    }

    public function printDelivery($id)
    {
        $order = ServiceOrder::with('client', 'receivedBy', 'parentOrder')->findOrFail($id);
        return view('admin.service.delivery', compact('order'));
    }

    public function downloadDeliveryPdf($id)
    {
        $order = ServiceOrder::with('client', 'receivedBy', 'parentOrder')->findOrFail($id);
        $pdf = Pdf::loadView('admin.service.delivery_pdf', compact('order'));
        return $pdf->download('Act_predare_' . $order->order_number . '.pdf');
    }

    public function printWorkReport($id)
    {
        $order = ServiceOrder::with('client', 'receivedBy', 'parentOrder')->findOrFail($id);
        return view('admin.service.work_report', compact('order'));
    }

    public function downloadWorkReportPdf($id)
    {
        $order = ServiceOrder::with('client', 'receivedBy', 'parentOrder')->findOrFail($id);
        $pdf = Pdf::loadView('admin.service.work_report_pdf', compact('order'));
        return $pdf->download('Lucrari_' . $order->order_number . '.pdf');
    }

    public function clients(Request $request)
    {
        $query = ServiceClient::withCount('orders')->orderBy('name');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'LIKE', "%{$s}%")->orWhere('phone', 'LIKE', "%{$s}%")->orWhere('email', 'LIKE', "%{$s}%");
            });
        }
        $clients = $query->paginate(25);
        return view('admin.service.clients', compact('clients'));
    }

    public function createClient() { return view('admin.service.client_form', ['client' => null]); }

    public function storeClient(Request $request)
    {
        $request->validate(['name' => 'required', 'phone' => 'required']);
        ServiceClient::create($request->all());
        return redirect()->route('service.clients')->with('success', 'Client adaugat!');
    }

    public function editClient($id)
    {
        $client = ServiceClient::findOrFail($id);
        return view('admin.service.client_form', compact('client'));
    }

    public function updateClient(Request $request, $id)
    {
        $request->validate(['name' => 'required', 'phone' => 'required']);
        ServiceClient::findOrFail($id)->update($request->all());
        return redirect()->route('service.clients')->with('success', 'Client actualizat!');
    }

    public function showClient($id)
    {
        $client = ServiceClient::with(['orders' => function($q) { $q->orderBy('id', 'DESC'); }])->findOrFail($id);
        return view('admin.service.client_show', compact('client'));
    }

    public function searchClient(Request $request)
    {
        $q = $request->input('q');
        $clients = ServiceClient::where('name', 'LIKE', "%{$q}%")
            ->orWhere('phone', 'LIKE', "%{$q}%")
            ->limit(10)->get(['id', 'name', 'phone', 'email']);
        return response()->json($clients);
    }

    public function clientOrders($clientId)
    {
        $orders = ServiceOrder::where('client_id', $clientId)->orderBy('id', 'DESC')
            ->get(['id', 'order_number', 'device_type', 'device_brand', 'device_model', 'serial_number', 'status', 'created_at']);
        return response()->json($orders);
    }

    public function addPhotos(Request $request, $orderId)
    {
        $request->validate(['photos.*' => 'image|max:5120']);
        $order = ServiceOrder::findOrFail($orderId);
        $stage = $request->input('stage', $order->status);
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $name = $order->order_number . '_' . time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/service', $name);
                ServicePhoto::create(['order_id' => $order->id, 'image' => $name, 'description' => $request->input('photo_description'), 'stage' => $stage]);
            }
        }
        return redirect()->route('service.show', $orderId)->with('success', 'Poze adaugate!');
    }

    public function deletePhoto($photoId)
    {
        $photo = ServicePhoto::findOrFail($photoId);
        $orderId = $photo->order_id;
        $path = storage_path('app/public/service/' . $photo->image);
        if (file_exists($path)) { unlink($path); }
        $photo->delete();
        return redirect()->route('service.show', $orderId)->with('success', 'Poza stearsa!');
    }

    public function deviceTypes()
    {
        $types = DeviceType::orderBy('name')->get();
        return view('admin.service.device_types', compact('types'));
    }

    public function storeDeviceType(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        DeviceType::create(['name' => $request->name, 'sort_order' => $request->sort_order ?? 0]);
        return redirect()->route('service.device-types')->with('success', 'Tip adaugat!');
    }

    public function deleteDeviceType($id)
    {
        DeviceType::findOrFail($id)->delete();
        return redirect()->route('service.device-types')->with('success', 'Tip sters!');
    }
}
