<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Payment;
use Carbon\Carbon;
use App\OrderReturn;
use Illuminate\Support\Str;
use DB;
use PDF;



class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withCount(['return'])->where('customer_id', auth()->guard('customer')->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('ecommerce.orders.index', compact('orders'));
    }

    public function view($invoice)
    {
        $oder = Order::with(['district.city.province', 'details', 'details.product','payment'])
        ->where('invoice', $invoice)->first();
        $order = Order::with(['district.city.province','details','details.product', 'payment'])
        ->where('invoice', $invoice)->first();
        //JADI KITA CEK, VALUE forUser() NYA ADALAH CUSTOMER YANG SEDANG LOGIN
        //DAN ALLOW NYA MEMINTA DUA PARAMETER
        //PERTAMA ADALAH NAMA GATE YANG DIBUAT SEBELUMNYA DAN YANG KEDUA ADALAH DATA ORDER DARI QUERY DI ATAS
        if(\Gate::forUser(auth()->guard('customer')->user())->allows('order-view', $order))
        {
            return view('ecommerce.orders.view', compact('order'));
        }
        return redirect(route('customer.orders'))->with(['error' => 'Anda tidak diijinkan mengakses order org lain!']);
    }

    public function paymentForm()
    {
        return view('ecommerce.payment');
    }

    public function storePayment(Request $request)
    {
        // validate datanya 
        $this->validate($request,[
            'invoice' => 'required|exists:orders,invoice',
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
            if ($order->subtotal != $request->amount) return redirect()->back()->with(['error' => 'Error, Pembayaran Harus Sama Dengan Tagihan']); //HANYA TAMBAHKAN CODE INI
            
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
                    'amount' => $request->amount,
                    'proof' => $filename,
                    'status' => false
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

    public function pdf($invoice)
    {
        //get data berdasarkan invoice
        $order = Order::with(['district.city.province','details','details.product','payment'])
                ->where('invoice', $invoice)->first();
        //block direct akses oleh user, hanya pemilik yg display fakturnya
        if(!\Gate::forUser(auth()->guard('customer')->user())->allows('order-view', $order)){
            return redirect(route('customer.view_order', $order->invoice));
        }

        $pdf = PDF::loadView('ecommerce.orders.pdf', compact('order'));
        //kemudian open filenya di browser
        return $pdf->stream();
    }

    public function acceptOrder(Request $request)
    {
        //cari data berdasarkan id
        $order = Order::find($request->order_id);
        //validasi kepemilikan
        if(!\Gate::forUser(auth()->guard('customer')->user())->allows('order-view', $order)){
            return redirect()->back()->with(['error' => 'Bukan pesanan kamu!']);
        }

        //ubah status menjadi 4
        $order->update(['status'=> 4]);
        //redirect kembali dengan menampilkan alert success
        return redirect()->back()->with(['success' => 'pesanan dikonfirmasi']);
    }

    public function returnForm($invoice)
    {
        //load data berdasarkan invoice
        $order = Order::where('invoice', $invoice)->first();
        return view('ecommerce.orders.return', compact('order'));
    }

    public function processReturn(Request $request, $id)
    {
        $this->validate($request,[
            'reason' =>  'required|string',
            'refund_transfer' => 'required|string',
            'photo' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        //cari data return by order_id, yg ada ditable return_orders
        $return = OrderReturn::where('order_id', $id)->first();
        //jika ditemukan, maka display notifikasi error
        if($return) return redirect()->back()->with(['error'=>'Permintaan refund dalam proses!']);
        //jika tidak, lakukan pengecekan utk memastikan file foto dikirimkan
        if($request->hasFile('photo')){
            //get file
            $file = $request->file('photo');
            //generate file berdasarkan time dan string random
            $filename = time(). Str::random(5).'.'. $file->getClientOriginalExtension();
            $file->storeAs('public/return', $filename);
            //dan simpan informasinya kedalam table order_returns
            OrderReturn::create([
                'order_id'=> $id,
                'photo' => $filename,
                'reason' => $request->reason,
                'refund_transfer' => $request->refund_transfer,
                'status' => 0
            ]);

            //tambahan kode untuk BOT Telegram
            $order = order::find($id);
            $this->sendMessage('#'. $order->invoice, $request->reason);
            //then, tampilkan notif sukses
            return redirect()->back()->with(['success' => 'Permintaan refund dikirim.']);
        }
    }

    private function getTelegram($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . $params); 

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $content = curl_exec($ch);
        curl_close($ch);
        return json_decode($content, true);
    }

    private function sendMessage($order_id, $reason)
    {
        $key = env('=bot1129110624:AAEoAu2S52ijkd4ztLNcJYsRzLKWDNdVHO');
        $chat = $this->getTelegram('https://api.telegram.org/'. $key .'/getUpdates', '');
        if ($chat['ok']) {
            $chat_id = $chat['result'][0]['message']['chat']['id'];
            $text = 'Hai Customer Laravel_Ecommerce, OrderID ' . $order_id . ' Melakukan Permintaan Refund Dengan Alasan "'. $reason .'", Segera Dicek Ya!';
            return $this->getTelegram('https://api.telegram.org/'. $key .'/sendMessage', '?chat_id=' . $chat_id . '&text=' . $text);
        }
    }
}
