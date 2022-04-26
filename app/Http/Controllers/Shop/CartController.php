<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;

class CartController extends Controller
{
    public function cartAdd(Request $request)
    {


        $product = $request->all();


        $cart = \Cart::add(array(
            'id' => $product['id'], // inique row ID
            'name' =>  $product['name'],
            'price' => $product['price'],
            'quantity' => $request['quantity'],
            'attributes' => array(
                'image' => $request->image,
                'ibv' => $product['ibv'],
                'bitterness' => $product['bitterness'],
                'type' => $product['type'],
                'resume' => $product['resume']


            )
        ));

        return redirect('/adc-carrinho');
    }
    public function itemRemove($id)
    {
        \Cart::remove($id);

        return redirect()->back();
    }
}
