<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductImage;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'sku' => 'required',
            'price' => 'required',
            'description' => 'required|min:20',
            'image' => 'required|mimes:jpeg,jpg,png',
            'quantity' => 'required'
        ]);


        $product = new Product;
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        if($request->has('image'))
        {
//            dd($request->all());
            $imageName = md5(time()).'.'.$request->image->extension();
            $request->image->move(public_path('product-image'), $imageName);
            $product->image = 'product-image/'.$imageName;
        }
        $product->qty = $request->quantity;
        $product->save();
//        dd($request->name);

        toastSuccess('Product Added successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'sku' => 'required',
            'price' => 'required',
            'description' => 'required|min:20',
            'image' => 'nullable|image',
        ]);

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;

        if($request->has('image'))
        {
            $imageName = md5(time()).'.'.$request->image->extension();
            $request->image->move(public_path('product-image'), $imageName);
            $product->name = 'product-image/'.$imageName;
        }
        $product->save();

        toastSuccess('Product Added successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (file_exists(public_path($product->image)))
        {
            unlink(public_path($product->image));
            $product->delete();

            $images = ProductImage::where('product_id', $product->id)->get();

            foreach ($images as $image)
            {
                if (file_exists(public_path($image->image)))
                {
                    unlink(public_path($image->image));
                }
            }
            ProductImage::where('product_id', $product->id)->delete();

            toastSuccess('Product deleted successfully');
            return redirect()->back();
        }
        else{
            toastError('Product does not exists.');
            return redirect()->back();
        }
    }

    /**
     * Remove multiple items from database
     * @param Request $request
     */
    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Product::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
