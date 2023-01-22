<?php

namespace App\Http\Controllers\API;

use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback()
    {
        //Set Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //Buat instance midtrans notification
        $notifcation = new Notification();

        //Assign ke variable untuk memudahkan ngoding
        $status = $notifcation->transaction_status;
        $type = $notifcation->payment_type;
        $fraud = $notifcation->fraud_status;
        $order_id = $notifcation->order_id;

        //Get Transaksi
        $order = explode('-', $order_id); //['LX',4]

        //Cari transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($order[1]);

        //Handle notifiation status midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaksi->status == 'PENDING';
                } else {
                    $transaksi->status == 'SUCCESS';
                }
            }
        } elseif ($status == 'settlement') 
        {
            $transaksi->status == 'SUCCESS';
        } elseif ($status == 'pending') 
        {
            $transaksi->status == 'PENDING';
        } elseif ($status == 'deny') 
        {
            $transaksi->status == 'PENDING';
        } elseif ($status == 'expire') 
        {
            $transaksi->status == 'CANCELED';
        } elseif ($status == 'cancel') 
        {
            $transaksi->status == 'CANCELED';
        }

        //simpan transaksi
        $transaksi->save();

        //Return Response untuk midtrnas
        return response()->json([
            'meta' => [
                'code' => 200,
                'message'   => 'Midtrans Notification Success'
            ]
        ]);
    }
}
