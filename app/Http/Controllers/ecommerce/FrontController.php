<?php

namespace App\Http\Controllers\ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Customer;
use App\Province;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::OrderBy('created_at','DESC')->paginate(10);
        return view('ecommerce.index', compact('products'));
    }

    public function product()
    {
        //paginate 12 agar posisi tampilannya presisi
        $products = Product::OrderBy('created_at','DESC')->paginate(12);
        // $categories = Category::with(['child'])->withCount(['child'])->getParent()->orderBy('name','ASC')->get();
        return view('ecommerce.product', compact('products'));
    }

    public function categoryProduct($slug)
    {
        $products = Category::where('slug', $slug)->first()->product()->orderBy('created_at','DESC')->paginate(12);
        return view('ecommerce.product', compact('products'));
    }

    public function show($slug)
    {
        $products = Product::with(['category'])->where('slug', $slug)->first();
        return view('ecommerce.show', compact('products'));
    }

    public function verifyCustomerRegistration($token)
    {
        //get customer by token
        $customer = Customer::where('activate_token', $token)->first();
        if($customer)
        {
            $customer->update([
                'activate_token' => null,
                'status' => 1
            ]);
            return redirect(route('customer.login'))->with(['success' => 'verifikasi berhasil, silahkan login!']);
        }

        return redirect(route('customer.login'))->with(['error' => 'Invalid verifikasi token!!']);
    }

    public function CustomerSettingForm()
    {
        //get data dari customer yg sedang login
        $customer = auth()->guard('customer')->user()->load('district');
        // get data province utk didisplay pd select box
        $provinces = Province::orderBy('name', 'ASC')->get();
        //load view setting.blade.php & passing data customer-province
        return view('ecommerce.setting', compact('customer', 'provinces'));
    }

    public function customerUpdateProfile(Request $request)
    {
        //validasi data yg dikirim
        $this->validate($request,[
            'name' => 'required|string|max:100',
            'phone_number' => 'required|max:15',
            'address' => 'required|string',
            'district_id' => 'required|exists:districts,id',
            'password' => 'nullable|string|min:6'
        ]);

        //get data customer yg login
        $user = auth()->guard('customer')->user();
        //get data yg dkirim dri form
        //but, hnya  4 kolom saja sesuai yg ada dibwh
        $data = $request->only('name', 'phone_number', 'address', 'district_id');
        //untuk password kita cek dlu, jika tdk kosong
        if($request->password !=''){
            //maka tambahkan kedalam array
            $data['password'] = $request->password;
        }
        //then, update datanya
        $user->update($data);
        return redirect()->back()->with(['success' => 'Profile update success!']);

    }
}
