<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\CartProduct;

class UserOrderController extends Controller
{
    //
    public function create(Request $request){//create Order
        if($request-> isMethod('post')){
            //$request->validate([]);
            $order=new Order();
            $order->status=$request->status;
            $order->total_price=$request->total_price;
            $order->saved();
            return redirect()->route('o.create');
        }else{
            return view('admin/order/cart');
            }
    }

    public function add(Request $request){ 
        
        //đưa dữ liệu vào cart= add Item
        //id sản phẩm
        //$request->validate([]);//kiểm tra đăng nhập và nhận id cart từ User
        $productId = $request->input('product_id');//tên field trong views 
        $quantity = $request->input('quantity');
        $cartItemId = $request->input('cart_item_id');
        $product=Product::find($productId);
            if (!product) {
                return alert('not found');
             }
        if ($request->isMethod('post')) {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']+=$quantity;
            }else{
                $cart[$productId]=[
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity ,    
                ];
            }
            session()->put('cart', $cart);
            $cart->save();
            return redirect()->route('o.add');
        }else {
            # code...
        }
    }

    public function delete(Request $request,$id=null){
        //id sản phẩm

        return redirect()->route('o.del');
    }
}
