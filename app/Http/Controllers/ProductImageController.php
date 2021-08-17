<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImage;

class ProductImageController extends Controller
{
    public function index($id)
    {
//        dd($id);
        $images = ProductImage::where('product_id', $id)->get();
        return view('product-images.index', compact('id', 'images'));
    }

    public function store(Request $request)
    {

        if($request->hasFile('file')) {
            $destinationPath = 'images/';
            $extension = $request->file('file')->getClientOriginalExtension();
            $validextensions = array("jpeg","jpg","png");
            if(in_array(strtolower($extension), $validextensions))
            {
                $fileName = md5(time()) .'.' . $extension;
                $request->file('file')->move($destinationPath, $fileName);
                $image = new ProductImage;
                $image->product_id = $request->product_id;
                $image->image = $destinationPath.$fileName;
                $image->save();


            }

        }

    }

    public function destroy(ProductImage $image)
    {
        if(file_exists(public_path($image->image))){
            unlink(public_path($image->image));
            $image->delete();

            toastSuccess('Image deleted successfully');
            return redirect()->back();
        }else{
            toastError('Image does not exists.');
            return redirect()->back();
        }
    }

}
