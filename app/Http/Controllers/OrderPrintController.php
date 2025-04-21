<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderPrintController extends Controller
{
    //
    public function show(Order $order)
    {
        return view('orders.print', compact('order'));
    }
}
