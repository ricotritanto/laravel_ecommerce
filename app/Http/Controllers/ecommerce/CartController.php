<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Province;
use App\City;
use App\District;
use App\Customer;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Str;
use DB;
use cookie;
use App\Mail\CustomerRegisterMail;
use Mail;

class CartController extends Controller
{
    public function getCart() // ternary operatio function
    {
        //if datanya kosong /null /!=0 maka disimpan dalam variabel,
        //atau sebaliknya maka diberikan ke array yg kosong
        $carts = json_decode(request()->cookie('laravel_carts'),true);
        $carts = $carts !='' ? $carts:[];
        return $carts;
    }

    public function addToCart(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer',
        ]);
        // print_r($request['product_id']);exit();
        //ambil data cart dari cookie, karena bentuknya json maka pake json_decode utk mengubah jadi array
        //$cart = json_decode($request->cookie('laravel_carts'),true);//script error jika data keranjang null
        $carts = $this->getCart();
        //jika cart tidak null, dan product id didalam array
        if($carts && array_key_exists($request->product_id, $carts))
        {
            //maka update qtynya berdasarkan product_idnya yg dijadikan key array
            $carts[$request->product_id]['qty'] += $request->qty;
        }else
        {
            //make querynya untuk mengambil product berdasarkan product_id            
            $product = Product::find($request->product_id);
            //tambahkan data baru dgn menjadikan product_id sebagai array key
            $carts[$request->product_id]=[
                'qty' => $request->qty,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'product_image' => $product->image,
                'product_weight' => $product->weight
            ];
        }
            //buat cookiesnya dengan nama laravel_carts(nama bebas)
            //dont forget untuk di encode kembali, dan limitnya 2880 menit or 48jam
            $cookie = cookie('laravel_carts', json_encode($carts), 2880);
            //store di browser untuk disimpan
            return redirect(route('front.cart'))->cookie($cookie);
    }

    public function listCart(Request $request)
    {
        //get data dari cookie
        // $carts = json_decode(request()->cookie('laravel_cart'),true);
        $carts = $this->getCart();
        //ubah array to collection, next gunakan method sum untuk hitung subtotal
        $subtotal = collect($carts)->sum(function($q){
            return $q['qty'] * $q['product_price'];
        });
        return view('ecommerce.cart', compact('carts','subtotal'));
    }

    public function updateCart(Request $request)
    {
        //ambil data dari cookie
        $carts = $this->getCart();
        //looping data (array)
        foreach($request->product_id as $key=> $row)
        {
            if($request->qty[$key] == 0)
            {
                unset($carts[$row]);
            }else{
                $carts[$row]['qty'] = $request->qty[$key];
            }
        }
        $cookie = cookie('laravel_carts', json_encode($carts),2880);
        return redirect()->back()->cookie($cookie);
    }

    public function checkout()
    {
        $provinces = Province::orderBy('created_at', 'DESC')->get();
        $carts = $this->getCart();

        $subtotal = collect($carts)->sum(function($q){
            return $q['qty'] * $q['product_price'];
        });

        return view('ecommerce.checkout', compact('provinces', 'carts','subtotal'));
    }

    public function getCity()
    {
        $cities = City::where('province_id', request()->province_id)->get();
        return response()->json(['status' => 'success', 'data' => $cities]);
    }

    public function getDistrict()
    {
        $districts = District::where('city_id', request()->city_id)->get();
        return response()->json(['status' => 'success', 'data' => $districts]);
    }

    public function processCheckout(Request $request)
    {   
        $this->validate($request, [
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required',
            'email' => 'required|email',
            'customer_address' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id'
        ]);
        //inisiasi database transaksi
        DB::beginTransaction();
        try{
            //cek data customer dlu
            $customer = Customer::where('email', $request->email)->first();
            //jika tidak ada, user diarahkan utk login terlebih dahulu
            if(!auth()->guard('customer')->check() && $customer) {
                return redirect()->back()->with(['error' => 'Please Login..!!']);
            }
            //ambil data di keranjang belanja
            $carts = $this->getCart();
            //hitung subtotal belanja
            $subtotal = collect($carts)->sum(function($q){
                return $q['qty'] * $q['product_price'];
            });

            //utk menghindari duplicate customer, masukkan query utk menambahkan query baru
            if(!auth()->guard('customer')->check()){
                $password = Str::random(8);
                //simpan data customer baru dlu bro
                $customer = Customer::create([
                    'name' => $request->customer_name,
                    'email' => $request->email,
                    'password' => $password,
                    'phone_number' => $request->customer_phone,
                    'address' => $request->customer_address,
                    'district_id' => $request->district_id,
                    'activate_token' => Str::random(30),
                    'status' => false
                ]);
            }         

            //simpan data orderannya
            $order = Order::create([
                'invoice' => str::random(4).'-'. time(), //invoice nya dibuat dengan string random dan waktu
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'district_id' => $request->district_id,
                'subtotal' =>$subtotal
            ]);
            // print_r($carts);exit();
            //lakukan looping di carts
            foreach($carts as $row){
                //ambil data product berdasarkan id product
                $product = Product::find($row['product_id']);               
                //simpan detail ordernya
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $row['product_id'],
                    'price' => $row['product_price'],
                    'qty' => $row['qty'],
                    'weight' => $product->weight
                ]);
            }
            //jika tidak error, maka commit datanya utk informasi bhwa data sdh fix utk disimpan
            DB::Commit();
            $carts = [];
            $cookie = cookie('laravel_carts', json_encode($carts), 2880);
            //mengirim email ke customer dari service email
            Mail::to($request->email)->send(new CustomerRegisterMail($customer, $password));
            return redirect(route('front.finish_checkout', $order->invoice))->cookie($cookie);
        }catch(\Exception $e){
            DB::rollback(); //jika error, maka dirollback ulang dbnya
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function checkoutFinish($invoice)
    {
        //ambil data  pesanan berdasarkan invoice
        $order = Order::with(['district.city'])->where('invoice', $invoice)->first();
        return view('ecommerce.checkout_finish', compact('order'));
    }
}
