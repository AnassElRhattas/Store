<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderPDFController extends Controller
{
    public function generate(Order $order)
    {
        $pdf = PDF::loadView('pdf.order', [
            'order' => $order->load(['items.product', 'user'])
        ]);

        $filename = 'order_' . $order->id . '_' . time() . '.pdf';
        $path = 'orders/' . $filename;

        Storage::disk('private')->put($path, $pdf->output());

        $order->update([
            'pdf_path' => $path
        ]);

        return response()->json([
            'message' => 'تم إنشاء ملف PDF بنجاح',
            'path' => $path
        ]);
    }
}