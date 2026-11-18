<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Order;
use App\Models\Printer;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'stats' => [
                'Users' => User::count(),
                'Templates' => Template::count(),
                'Designs' => Design::count(),
                'Printers' => Printer::count(),
                'Orders' => Order::count(),
                'Revenue' => number_format(Order::where('status', '!=', 'cancelled')->sum('total'), 2),
            ],
            'orders' => Order::with('user', 'printer', 'design')->latest()->take(30)->get(),
            'statuses' => Order::STATUSES,
        ]);
    }

    public function updateOrder(Request $request, Order $order)
    {
        $data = $request->validate(['status' => ['required', 'in:' . implode(',', Order::STATUSES)]]);
        $order->update($data);

        return back()->with('status', __('ui.msg_order_updated', ['id' => $order->id]));
    }
}
