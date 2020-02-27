<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Payment;
use Carbon\Carbon;
use DB;

class OrderContrller extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', auth()->guard('customer')->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('ecommerce.orders.index', compact('orders'));
    }

    public function view($invoice)
    {
        $oder = Order::with(['district.city.province', 'details', 'details.product','payment'])
        ->where('invoice', $invoice)->first();
        return view('ecommerce.orders.view', compact('order'));
    }

    public function paymentForm()
    {
        return view('ecommerce.payment');
    }

    public function storePayment(Request $request)
    {
        // validate datanya 
        $this->validate($request, [
            'invoice' => 'required|exist:orders,invoice',
            'name' => 'required|string',
            'transfer_to' => 'required|string',
            'transfer_date' => 'required',
            'amount' => 'required|integer',
            'proof' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        //define db transaction utk menghindari kesalahan syncronize data jika terjadi  error ditengah proses query
        DB::beginTransaction();
        try{
            //ambil data order berdasarkan invoice ID
            $order = Order::where('invoice', $request->invoice)->first();
            //if status masih 0 dan ada bukti  transfer yg dikirim
            if($order->status== 0 && $request->hasFile('proof')){
                //maka upload file gambar tersebut
                $file = $request->file('proof');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->storeAs('public/payment', $filename);

                //then, save info pembayarannya
                Payment::create([
                    'order_id' => $order->id,
                    'name' => $request->name,
                    'transfer_to' => $request->transfer_to,
                    'transfer_date' => Carbon::parse($request->transfer_date)->format('Y-m-d'),
                    'amount' => $request,
                    'proof' => $filename,
                    'status' => $false
                ]);
                //and ganti order status jadi 1
                $order->update(['status'=> 1]);
                //if not error, maka commit berhasil
                DB::commit();
                return redirect()->back()->with(['success' => 'Pesanan dikonfirmasi']);
            }
            return redirect()->back()->with(['error' => 'Error, Upload Bukti Transfer']);      
        } catch(\Exception $e)
        {
            //JIKA TERJADI ERROR, MAKA ROLLBACK SELURUH PROSES QUERY
            DB::rollback();
            //DAN KIRIMKAN PESAN ERROR
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }


    }
}
