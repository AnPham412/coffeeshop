<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class AdminController extends Controller{
    public function index(){
        return view('admin.index');
    }

    //CateGory
    public function categories(){
        $categories = Category::orderBy('id','DESC')->paginate(10);
        return view('admin.categories',compact('categories'));
    }
    public function category_add(){
        return view('admin.category-add');
    }
    public function CategoryThumbnails($image,$imageName){
        $destination = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124,124,"top");
        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
        })->save($destination.'/'.$imageName);
    }
    public function category_store(Request $request){
        $request->validate([
            'name'=>'required',
            'image'=>'mimes:png,jpg,jpeg|max:2048'
        ]);
        $category = new Category();
        $category->name = $request->name;
        $image=$request->file('image');
        $file_extension=$request->file('image')->extension();
        $file_name=Carbon::now()->timestamp.'.'.$file_extension;
        $this->CategoryThumbnails($image,$file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status','Category has been added succesfully');
    }
    public function category_edit($id){
        $category = Category::find($id);
        return view('admin.category-edit',compact('category'));
    }
    public function category_update(Request $request){
        $request->validate([
            'name'=>'required',
            'image'=>'mimes:png,jpg,jpeg|max:2048'
        ]);
        $category= Category::find($request->id);
        $category->name = $request->name;
        if ($request->hasFile('image')) {
            if (File::exists(public_path('upload/categories').'/'.$category->image)) {
                File::delete(public_path('upload/categories').'/'.$category->image);
            }
            $image=$request->file('image');
            $file_extension=$request->file('image')->extension();
            $file_name=Carbon::now()->timestamp.'.'.$file_extension;
            $this->CategoryThumbnails($image,$file_name);
            $category->image = $file_name;
        }
        $category->save();
        return redirect()->route('admin.categories')->with('status','Categories has been updated succesfully');
    }

    public function category_delete($id){
        $category = Category::find($id);
        if (File::exists(public_path('uploads/categories').'/'.$category->image)) {
             File::delete(public_path('uploads/categories').'/'.$category->image);
        }$category->delete();
        return redirect()->route('admin.categories')->with('status','Category has been deleted');
    }


    //BRAND
    public function brands(){
        $brands = Brand::orderBy('id','DESC')->paginate(10);
        return view('admin.brands',compact('brands'));
    }
    public function add_brand(){

        return view('admin.brand-add');
    }
    public function brand_store(Request $request){
        $request->validate([
            'name'=>'required',
            'image'=>'mimes:png,jpg,jpeg|max:2048'
        ]);
        $brand = new Brand();
        $brand->name = $request->name;
        $image=$request->file('image');
        $file_extension=$request->file('image')->extension();
        $file_name=Carbon::now()->timestamp.'.'.$file_extension;
        $this->BrandThumbnails($image,$file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status','Brand has been added succesfully');
    }

    public function BrandThumbnails($image,$imageName){
        $destination = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124,124,"top");
        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
        })->save($destination.'/'.$imageName);
    }
    public function brand_edit($id){
        $brand = Brand::find($id);
        return view('admin.brand-edit',compact('brand'));
    }
    public function brand_update(Request $request){
        $request->validate([
            'name'=>'required',
            'image'=>'mimes:png,jpg,jpeg|max:2048'
        ]);
        $brand= Brand::find($request->id);
        $brand->name = $request->name;
        if ($request->hasFile('image')) {
            if (File::exists(public_path('upload/brands').'/'.$brand->image)) {
                File::delete(public_path('upload/brands').'/'.$brand->image);
            }
            $image=$request->file('image');
            $file_extension=$request->file('image')->extension();
            $file_name=Carbon::now()->timestamp.'.'.$file_extension;
            $this->BrandThumbnails($image,$file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status','Brand has been updated succesfully');
    }
    public function brand_delete($id){
        $brand = Brand::find($id);
        if (File::exists(public_path('uploads/brands').'/'.$brand->image)) {
             File::delete(public_path('uploads/brands').'/'.$brand->image);
        }$brand->delete();
        return redirect()->route('admin.brands')->with('status','Brand has been deleted');
    }


    //Product
    public function products(){
        $products = Product::orderBy('created_at','ASC')->paginate(10);
        return view('admin.products',compact('products'));
    }

    public function product_add(){
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get(); 
        return view('admin.product-add',compact('categories','brands'));
    }
    public function product_store(Request $request){//lưu trữ hình ảnh sản phẩm
        $request->validate([
        'name'=>'required',
        'slug'=>'required|unique:products,slug',
        'short_description'=>'required',
        'description'=>'required',
        'regular_price'=>'required',
        'sale_price'=>'required',
        'stock_status'=>'required',
        'featured'=>'required',
        'quantity'=>'required',
        'image'=>'required|mimes:png,jpg,jpeg|max:2048',
        'category_id'=>'required',
        'brand_id'=>'required',
        ]);

        $product = new Product();
        $product->name=$request->name;
        $product->slug=Str::slug($request->name);
        $product->short_description=$request->short_description;
        $product->description=$request->description;
        $product->regular_price=$request->regular_price;
        $product->sale_price=$request->sale_price;
        $product->stock_status=$request->stock_status;
        $product->featured=$request->featured;
        $product->quantity=$request->quantity;
        $product->category_id=$request->category_id;
        $product->brand_id=$request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName= $current_timestamp .'.'. $image->extension();
            $this->productThumbnail($image,$imageName);
            $product->image = $imageName;
        }
        //tạo hình ảnh cho thư viện
        $gallery_arr=array();
        $gallery_images="";
        $counter = 1;
        
        if ($request->hasFile('images')) {
            $allowFileExtension=['jpg','png','jpeg'];
            $files = $request->file('images');

            foreach ($files as $file) {
                $getExtension = $file->getClientOriginalExtension();
                $getCheck = in_array($getExtension,$allowFileExtension);

                if ($getCheck) {
                    $getFileName = $current_timestamp . '-' . $counter . '.' . $getExtension;
                    $this->productThumbnail($file,$getFileName);
                    array_push($gallery_arr,$getFileName);
                    $counter = $counter+1;
                }
            }

            $gallery_images = implode(',',$gallery_arr);
        }
        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('admin.products')->with('status','Product has been added succesfully');
    }
    public function productThumbnail($image,$imageName){
        $destinationThumbnail = public_path('uploads/products/thumbnails');
        $destination = public_path('uploads/products');
        $img = Image::read($image->path());

        $img->cover(540,689,"top");
        $img->resize(540,689,function($constraint){
            $constraint->aspectRatio();
        })->save($destination.'/'.$imageName);

        $img->resize(104,104,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationThumbnail.'/'.$imageName);
    }
    public function product_edit($id){
        $product = Product::find($id);
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get(); 
        return view('admin.product-edit',compact('product','categories','brands'));
    }
    public function product_update(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug,'.$request->id,
            'short_description'=>'required',
            'description'=>'required',
            'regular_price'=>'required',
            'sale_price'=>'required',
            'stock_status'=>'required',
            'featured'=>'required',
            'quantity'=>'required',
            'image'=>'mimes:png,jpg,jpeg|max:2048',
            'category_id'=>'required',
            'brand_id'=>'required',
            ]);

            $product = Product::find($request->id);
            
            $product->name=$request->name;
            $product->slug=Str::slug($request->name);
            $product->short_description=$request->short_description;
            $product->description=$request->description;
            $product->regular_price=$request->regular_price;
            $product->sale_price=$request->sale_price;
            $product->stock_status=$request->stock_status;
            $product->featured=$request->featured;
            $product->quantity=$request->quantity;
            $product->category_id=$request->category_id;
            $product->brand_id=$request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            //xóa hình cũ
            if (File::exists(public_path('uploads/products'.'/'.$product->image))) {
                File::delete(public_path('uploads/products'.'/'.$product->image));
            }
            //xóa thumbnail cũ
            if (File::exists(public_path('uploads/products/thumbnails'.'/'.$product->image))) {
                File::delete(public_path('uploads/products/thumbnails'.'/'.$product->image));
            }
            $image = $request->file('image');
            $imageName= $current_timestamp .'.'. $image->extension();
            $this->productThumbnail($image,$imageName);
            $product->image = $imageName;
        }
        //tạo hình ảnh cho thư viện
        $gallery_arr=array();
        $gallery_images="";
        $counter = 1;
        
        if ($request->hasFile('images')) {
            foreach (explode(',',$product->images) as $ofile) {
                //xóa hình cũ
            if (File::exists(public_path('uploads/products').'/'. $ofile)) {
                File::delete(public_path('uploads/products').'/'. $ofile);
            }
            //xóa thumbnail cũ
            if (File::exists(public_path('uploads/products/thumbnails').'/'. $ofile)) {
                File::delete(public_path('uploads/products/thumbnails').'/'. $ofile);
            }
            }

            $allowFileExtension=['jpg','png','jpeg'];
            $files = $request->file('images');

            foreach ($files as $file) {
                $getExtension = $file->getClientOriginalExtension();
                $getCheck = in_array($getExtension,$allowFileExtension);

                if ($getCheck) {
                    $getFileName = $current_timestamp . '-' . $counter . '.' . $getExtension;
                    $this->productThumbnail($file,$getFileName);
                    array_push($gallery_arr,$getFileName);
                    $counter = $counter+1;
                }
            }

            $gallery_images = implode(',',$gallery_arr);
            $product->images = $gallery_images;
        }
        
        $product->save();
        return redirect()->route('admin.products')->with('status','Product has been updated succesfully');
    }

    public function product_delete($id){
        
        $product = Product::find($id);

        //Product image delete
        if(File::exists(public_path('uploads/products').'/'.$product->image)){
            File::delete(public_path('uploads/products').'/'.$product->image);
        }
        if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image)){
            File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
        }

        //product gallery delete
        foreach(explode(',',$product->images) as $gallery_images){
            if (File::exists(public_path('uploads/products').'/'.$gallery_images)) {
                File::delete(public_path('uploads/products').'/'.$gallery_images);
            }
            if (File::exists(public_path('uploads/products/thumbnails').'/'.$gallery_images)) {
                File::delete(public_path('uploads/products/thumbnails').'./'.$gallery_images);
            }
        }
        $product->delete();
        return redirect()->route('admin.products')->with('status','Product deleted succesful');
    }

}