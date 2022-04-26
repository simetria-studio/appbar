<?php

namespace App\Http\Controllers\Painel;

use App\Models\Waiter;
use App\Models\Unity;
use App\Models\Comanda;
use App\Models\OrderFlow;
use App\Models\Product;
use App\Models\ComandaProduct;
use App\Models\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WaiterController extends Controller
{
    public function index()
    {
        $waiters = Waiter::all();
        return view('painel.settings.waiter.index', get_defined_vars());
    }

    public function store(Request $request)
    {
        $waiter['name'] = $request->name;
        $waiter['email'] = $request->email;
        $waiter['user'] = $request->user;
        $waiter['password'] = Hash::make($request->password);

        Waiter::create($waiter);

        return redirect()->back()->with('success', 'Garçom registrado com successo!');
    }

    public function edit($id)
    {
        $waiter = Waiter::find($id);
        return view('painel.settings.waiter.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $waiter['name'] = $request->name;
        $waiter['email'] = $request->email;
        $waiter['user'] = $request->user;
        if($request->password) $waiter['password'] = Hash::make($request->password);

        Waiter::find($id)->update($waiter);

        return redirect()->route('setting.waiter')->with('success', 'Garçom alterado com successo!');
    }

    public function destroy(Request $request, $id)
    {
        Waiter::find($id)->delete();

        return response()->json('success', 200);
    }

    // Informaçãoes para o garçon e funções
    function waiterIndex()
    {
        return view('waiter.auth.index');
    }

    public function waiterAuth(Request $request)
    {
        $remember = $request->remember ? true : false;

        $authValid = Auth::guard('waiter')->validate(['user' => $request->user, 'password' => $request->password]);
        
        if($authValid){
            if (Auth::guard('waiter')->attempt(['user' => $request->user, 'password' => $request->password], $remember)) {
                return response()->json(route('waiter.check_in'), 200);
            }
        }else{
            return response()->json(['invalid' => 'Usuario ou Senha invalidos'], 422);
        }
    }

    public function logout(Request $request)
    {
        auth()->guard('waiter')->logout();
        return redirect()->route('waiter.login');
    }

    // Funções do garçom para comanda
    public function waiterCheckInindex()
    {
        $unities = Unity::all();

        if(auth()->guard('waiter')->user()->unity_id) return redirect()->route('waiter.comanda');

        return view('waiter.checkIn', get_defined_vars());
    }

    public function waiterCheckIn(Request $request)
    {
        if($request->leave_unity){
            Waiter::find(auth()->guard('waiter')->user()->id)->update(['unity_id' => null]);
            return redirect()->route('waiter.check_in');
        }
        Waiter::find(auth()->guard('waiter')->user()->id)->update(['unity_id' => $request->unity_id]);

        return redirect()->route('waiter.comanda');
    }

    public function waiterComandas()
    {
        $comandas = Comanda::with('table', 'client', 'products.product')->whereIn('status', [1,2])->whereHas('table', function($query) {
            return $query->where('unity_id', auth()->guard('waiter')->user()->unity_id);
        })->get();

        return view('waiter.comandas', get_defined_vars());
    }

    public function waiterComanda($id)
    {
        $comanda = Comanda::with('table', 'client', 'products.product')->find($id);
        if(empty($comanda->waiter_id)){
            $comanda->update([
                'waiter_id' => auth()->guard('waiter')->user()->id,
                'waiter_status' => 2
            ]);

            OrderFlow::where('key', 'comanda')->where('key_id', $comanda->id)->where('status', 0)->update([
                'status' => 1,
                'user' => 'waiter',
                'user_id' => auth()->guard('waiter')->user()->id
            ]);

            foreach($comanda->products as $product) {
                OrderFlow::create([
                    'key' => 'comanda_produto',
                    'key_id' => $product->id,
                    'reason' => 'Solicitando pedido'
                ]);
            }
        }

        return view('waiter.comandaProduto', get_defined_vars());
    }

    public function waiterComandaProductDelivered(Request $request)
    {
        $order_flow = OrderFlow::where('key', 'comanda_produto')->where('key_id', $request->id)->where('status', 0)->first();
        OrderFlow::find($order_flow->id)->update([
            'user' => 'waiter',
            'user_id' => auth()->guard('waiter')->user()->id,
            'status' => 1
        ]);

        ComandaProduct::find($request->id)->update(['status' => 2]);
        $comanda_product = ComandaProduct::find($request->id);

        $product_stock = Product::find($comanda_product->product_id);
        Product::find($comanda_product->product_id)->update([
            'stock' => ($product_stock->stock - $comanda_product->quantity)
        ]);

        Stock::create([
            'product_id' => $product_stock->id,
            'type' => 'S',
            'value' => $comanda_product->quantity,
            'description' => '(Venda no local - '.auth()->guard('waiter')->user()->unity->name.')',
        ]);

        return response()->json('success', 200);
    }

    public function waiterComandaClose($id)
    {
        Comanda::find($id)->update(['status' => 3]);

        $order_flow = OrderFlow::where('key', 'payment_comanda')->where('key_id', $id)->where('status', 0)->first();
        if($order_flow){
            OrderFlow::find($order_flow->id)->update([
                'user' => 'waiter',
                'user_id' => auth()->guard('waiter')->user()->id,
                'status' => 1
            ]);
        }

        return redirect()->route('waiter.comanda')->with('success', 'Comanda fechada com successo');
    }
}
