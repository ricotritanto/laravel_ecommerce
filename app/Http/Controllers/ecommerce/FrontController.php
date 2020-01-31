<?php

namespace App\Http\Controllers\ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Customer;

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
}
