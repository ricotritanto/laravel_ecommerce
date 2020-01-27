<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use App\Product;
use App\Category;
use App\Jobs\ProductJob;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['category'])->orderBy('created_at', 'DESC');
        if(request()->q != '') {
            $product = $product->where('name', 'like', '%'. request()->q.'%');
        }
        $product = $product->paginate(10);

        return view('products.index', compact('product'));
    }

    public function create()
    {
        $category = Category::orderBy('name','DESC')->get();
        return view('products.create', compact('category'));

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:100',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);
        //jika filenya ada
        if($request->hasFile('image')){
            $file = $request->file('image'); // simpan sementara divariabel file
            //next nama filenya dibuat customer dgn gabungan time&slug fr product
            $filename = time().Str::slug($request->name).'.'. $file->getClientOriginalExtension();
            //save filenya ke folder public/products
            $file->storeAs('public/products', $filename);

            $product = Product::Create([
                'name' => $request->name,
                'slug' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image' => $filename,
                'price' => $request->price,
                'weight' => $request->weight,
                'status' => $request->status
            ]);

            return redirect(route ('product.index'))->with(['success'=> 'Add products Success !']);
        }
    }

    public function edit($id)
    {
        $product = Product::Find($id);
        $category = Category::orderBy('Name', 'DESC')->get();

        return view('products.edit', compact('product', 'category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

        $product = Product::find($id);
        $filename = $product->image;

        //jika ada file gambar yg dikirim maka,
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name). '.'. $file->getClientOriginalExtension();
            $file->storeAs('public/products', $filename);
            //dan hapus file gambar yg lama
            File::delete(storage_path('app/public/products/' .$product->image));
        }
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'weight' => $request->weight,
            'status' => $request->status,
            'image' => $filename
        ]);
        return redirect(route ('product.index'))->with(['success' => "Update Product Success..!!!"]);
    }

    public function destroy($id)
    {
        $product = Product::Find($id);
        File::delete(storage_path('app/public/products'. $product->image)); //untuk delete image di storage
        $product->delete();

        return redirect(route('product.index'))->with(['success' => 'Delete Product Success !!']);
    }

    public function massUploadForm()
    {
        $category = Category::orderBy('name','DESC')->get();
        return view('products.bulk', compact('category'));
    }

    public function massUpload(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|mimes:xlsx' //format excel must be xlsx
        ]);

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time(). '-product.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads', $filename);

            ProductJob::dispatch($request->category_id, $filename);
            return redirect()->back()->with(['success' => 'Upload Produk Dijadwalkan']);
        }
    }

    public function saveBulk()
    {

    }
}
