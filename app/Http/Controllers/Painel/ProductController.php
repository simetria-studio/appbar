<?php

namespace App\Http\Controllers\Painel;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!empty($_GET['name'])){
            switch($_GET['coluna']){
                case 'produto':
                    $products = Product::where('name', 'like', '%'.$_GET['name'].'%')->with(['stock' => function($query) {
                        return $query->orderBy('created_at', 'DESC');
                    }])->paginate(15);
                break;
                case 'fornecedor':
                    $products = Product::where('provider', 'like', '%'.$_GET['name'].'%')->with(['stock' => function($query) {
                        return $query->orderBy('created_at', 'DESC');
                    }])->paginate(15);
                break;
                case 'contato':
                    $products = Product::where('provname', 'like', '%'.$_GET['name'].'%')->with(['stock' => function($query) {
                        return $query->orderBy('created_at', 'DESC');
                    }])->paginate(15);
                break;
            }
        }else{
            $products = Product::with(['stock' => function($query) {
                return $query->orderBy('created_at', 'DESC');
            }])->paginate(15);
        }

        return view('painel.products.index', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'buyprice' => 'required',
            'sellprice' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ];

        $customMessages = [
            'name.required' => 'O campo Nome é obrigatório!',
            'name.min' => 'O campo Nome precisa no minimo 3 caracteres',
            'name.max' => 'O campo Nome excede o numero de caracteres',
            'buyprice.required' => 'O campo preço de compra e obrigatório!',
            'sellprice.required' => 'O campo preço de venda e obrigatório!',
            'image.required' => 'O campo imagem do produto e obrigatório!',
            'image.mimes' => 'Formato de imagem não aceito! por favor coloque jpeg, jpg, png ou svg',
            'image.max' => 'Imagem excede limite de tamanho',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();

        // $price = str_replace(['.', ','], ['', '.'], $data['price']);
        $img = ImageManagerStatic::make($data['image']);

        $name = Str::random() . '.jpg';

        $originalPath = storage_path('app/public/produtos/');

        $img->save($originalPath . $name);

        $sellprice = str_replace(['.', ','], ['', '.'], $data['sellprice']);
        $buyprice = str_replace(['.', ','], ['', '.'], $data['buyprice']);

        $product = Product::create([
            'name' => $data['name'],
            'resume' => $data['resume'],
            'provider' => $data['provider'],
            'provphone' => $data['provphone'],
            'provname' => $data['provname'],
            'buyprice' => $buyprice,
            'sellprice' => $sellprice,
            'bitterness' => $data['bitterness'],
            'temperature' => $data['temperature'],
            'ibv' => $data['ibv'],
            'type' => $data['type'],
            'image' => $name,
            'categoria' => $data['categoria'],
            'description' => $data['description'],
            'spotlight' => $data['spotlight'],
            'delivery' => $data['delivery'],
            'location' => $data['location'],
            'stock' => $data['stock'],
        ]);

        Stock::create([
            'product_id' => $product->id,
            'type' => 'E',
            'value' => $data['stock'],
            'description' => 'Entrada inicial!'
        ]);

        return redirect()->back()->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, $id)
    {
        $product = Product::find($id);
        return view('painel.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = Product::find($id);

        $data = $request->all();

        if ($request->image != '') {
            $path = storage_path('app/public/produtos/');

            //code for remove old file
            if ($produto->image != ''  && $produto->image != null) {
                $file_old = $path . $produto->image;
                unlink($file_old);
            }

            //upload new file
            $img = ImageManagerStatic::make($data['image']);


            $name = Str::random() . '.jpg';

            $originalPath = storage_path('app/public/produtos/');

            $img->save($originalPath . $name);

            //for update in table
            $produto->update(['image' => $name]);
        }


        $sellprice = str_replace(['.', ','], ['', '.'], $data['sellprice']);
        $buyprice = str_replace(['.', ','], ['', '.'], $data['buyprice']);

        $produto->name =     $request->get('name');
        $produto->resume = $request->get('resume');
        $produto->provider = $request->get('provider');
        $produto->provphone = $request->get('provphone');
        $produto->provname = $request->get('provname');
        $produto->buyprice =  $buyprice;
        $produto->sellprice = $sellprice;
        $produto->bitterness = $request->get('bitterness');
        $produto->temperature = $request->get('temperature');
        $produto->temperature = $request->get('temperature');
        $produto->ibv = $request->get('ibv');
        $produto->type = $request->get('type');
        $produto->categoria = $request->get('categoria');
        $produto->description = $request->get('description');
        $produto->spotlight = $request->get('spotlight');
        $produto->delivery = $request->get('delivery');
        $produto->location = $request->get('location');
        $produto->save();



        return redirect()->route('products')->with('success', 'Produto alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {

            $user = Product::findOrFail($id);

            if ($user) {

                $user->delete();

                return response()->json(array('success' => true));
            }
        }
    }

    /**
     * Atualização do Stock
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Stock $stock
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function stockUpdate(Request $request)
    {
        $product = Product::find($request->id);
        $new_stock = 0;
        if($request->stock_type == 'E'){
            $new_stock = ($product->stock ?? 0) + $request->new_stock;
        }elseif($request->stock_type == 'S'){
            $new_stock = ($product->stock ?? 0) - $request->new_stock;
        }

        $product->update([
            'stock' => $new_stock
        ]);

        Stock::create([
            'product_id' => $product->id,
            'type' => $request->stock_type,
            'value' => $request->new_stock,
            'description' => $request->description ?? ($request->stock_type == 'E' ? '(Entrada no Estoque)' : '(Saída no Estoque)'),
        ]);

        return redirect()->route('products')->with('success', 'Estoque adicionado ao produto "'.$product->name.'"');
    }
}
