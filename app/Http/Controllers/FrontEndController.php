<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\TransaksiItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;

class FrontEndController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::with(['galleries'])->latest()->get();
        return view('pages.frontend.index', compact('produk'));
    }

    public function details(Request $request, $slug)
    {
        $produk = Produk::with(['galleries'])->where('slug', $slug)->firstOrFail();
        $rekomendasi = Produk::with(['galleries'])->inRandomOrder()->limit(4)->get();

        return view('pages.frontend.details', compact('produk', 'rekomendasi'));
    }

    public function cart(Request $request)
    {
        $carts = Cart::with(['produk.galleries'])->where('users_id', Auth::user()->id)->get();

        return view('pages.frontend.cart', compact('carts'));
    }

    public function cartAdd(Request $request, $id)
    {
        Cart::create([
            'users_id'    => Auth::user()->id,
            'produks_id' => $id
        ]);

        return redirect('cart');
    }

    public function cartDelete(Request $request, $id)
    {
        $item = Cart::findOrFail($id);

        $item->delete();

        return redirect()->back();
    }

    public function checkout(CheckoutRequest $request)
    {
        $data = $request->all();

        // Get Carts Data
        $carts = Cart::with(['produk'])->where('users_id', Auth::user()->id)->get();

        // Add to Transasksi Data
        $data['users_id'] = Auth::user()->id;
        $data['total_price'] = $carts->sum('produk.price');

        //Create Transaksi
        $transaksi = Transaksi::create($data);

        // Transaksi Item 
        foreach ($carts as $cart) {
            $item[] = TransaksiItem::create([
                'transaksis_id' => $transaksi->id,
                'users_id'      => $cart->users_id,
                'produks_id'    => $cart->produks_id
            ]);
        }

        // Delete Transaksi
        Cart::where('users_id', Auth::user()->id)->delete();

        // Configruasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Setup Variable Midtrans
        $midtrans = array(
            'transaction_details' => array(
                'order_id' =>  'LX-' . $transaksi->id,
                'gross_amount' => (int) $transaksi->total_price,
            ),
            'customer_details' => array(
                'first_name'    => $transaksi->name,
                'email'         => $transaksi->email
            ),
            'enabled_payments' => array('gopay','bank_transfer'),
            'vtweb' => array()
        );

        try {
            // Ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $transaksi->payment_url = $paymentUrl;
            $transaksi->save();

            // Redirect ke halaman midtrans
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            return $e;
        }

        // return request()->all();
    }

    public function success(Request $request)
    {
        return view('pages.frontend.success');
    }
}
