<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Order;
use App\Models\Printer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('orders.index', [
            'orders' => $request->user()->orders()->with('design', 'printer')->latest()->get(),
        ]);
    }

    public function create(Request $request, Design $design)
    {
        abort_unless($design->user_id === $request->user()->id, 403);

        return view('orders.create', [
            'design' => $design,
            'printers' => Printer::where('is_active', true)->orderBy('price_per_unit')->get(),
        ]);
    }

    public function store(Request $request, Design $design)
    {
        abort_unless($design->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'printer_id' => ['required', 'exists:printers,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100000'],
            'contact_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'address' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $printer = Printer::findOrFail($data['printer_id']);

        if ($data['quantity'] < $printer->min_qty) {
            return back()->withInput()->withErrors(['quantity' => __('ui.msg_min_qty', ['name' => $printer->name, 'min' => $printer->min_qty])]);
        }

        $volumeFactor = $design->width * $design->height * $design->depth / 3000;
        $unit = round($printer->price_per_unit * max(0.6, $volumeFactor), 2);

        $order = Order::create($data + [
            'user_id' => $request->user()->id,
            'design_id' => $design->id,
            'unit_price' => $unit,
            'total' => round($unit * $data['quantity'], 2),
        ]);

        return redirect()->route('orders.index')->with('status', __('ui.msg_order_placed', ['id' => $order->id]));
    }
}
