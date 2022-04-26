<?php

namespace App\Http\Controllers\Shop;

use PagarMe\Client;
use App\Models\Item;
use App\Models\Adress;
use App\Models\Pedido;
use App\Models\Transporte;
use App\Models\ShippMethod;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;

class CheckoutController extends Controller
{

    public function connect($endpoint, $dados)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.pagar.me/core/v5/$endpoint",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dados),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic '.base64_encode('sk_Od29W0EhVZCD1gQ0:'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function preCheck()
    {
        $address = Adress::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        if ($address) {
            $transporte = Transporte::where('estado', $address->estado)->where('cidade', $address->cidade)->where('bairro', 'like', '%' . $address->bairro . '%')->first();
        } else {
            $transporte = '';
        }
        $ship = ShippMethod::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        return view('front.carrinho.finalizar-compra', get_defined_vars());
    }

    public function proccess()
    {
        $adress = Adress::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        $transporte = Transporte::where('estado', ($adress->estado ?? ''))->where('cidade', ($adress->cidade ?? ''))->where('bairro', 'like', '%' . ($adress->bairro ?? '') . '%')->first();
        return view('front.carrinho.efetuar-pagamento', compact('transporte'));
    }

    public function checkout(Request $request)
    {


        $telefone = str_replace([' ', '-'], '', auth()->user()->whatsapp);

        $adress = Adress::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        $transporte = Transporte::where('estado', $adress->estado)->where('cidade', $adress->cidade)->where('bairro', 'like', '%' . $adress->bairro . '%')->first();

        $valor = number_format((\Cart::getTotal() + ($transporte->valor_frete ?? 0)), 2, '.', '');
        $valor = str_replace('.', '', $valor);
        $ship = ShippMethod::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        $validade = str_replace('/', '', $request->validade);

        $items = [];
        // foreach (\Cart::getContent() as $key => $value) {

        //     $items[] = [
        //         'id' => (string)$value->id,
        //         'title' => $value->name,
        //         'unit_price' => (str_replace('.', '', number_format($value->price, 2, '.', ''))),
        //         'quantity' => (int)$value->quantity,
        //         'tangible' => true
        //     ];
        // }


        $pedido = Pedido::create([
            'user_id' => auth()->user()->id,
            'adress_id' => $adress->id,
            'produto_id' => 0,
            'pagamento' => $request->metodo,
            'troco' => $request->troco,
            'ship_id' => $ship->id,
            'valor_frete' => $ship->tipo == 'Receber em Casa' ? $transporte->valor_frete : null,
            'tempo_entrega' => $ship->tipo == 'Receber em Casa' ? $transporte->tempo_entrega : null,
        ]);

        foreach (\Cart::getContent() as $key => $value) {

            $items[] = [
                // 'id' => (string)$value->id,
                'amount' => (str_replace('.', '', number_format($value->price, 2, '.', ''))),
                'description' => $value->name,
                'quantity' => (int)$value->quantity,
                // 'tangible' => true
            ];

            $produtos = Item::create([
                'user_id' => auth()->user()->id,
                'produto_id' => $value->id,
                'pedido_id' => $pedido->id,
                'title' => $value->name,
                'unit_price' => $value->price,
                'quantity' => $value->quantity,
            ]);
        }


        if ($request->metodo == 'dinheiro') {
            \Cart::clear();
            return response()->json(['success'], 200);
        }

        $cpf = str_replace(['.', '-',], '', $request->cpf);
        if ($request->metodo == 'card') {
            $dados = array(
                'items' =>  $items,
                'customer' =>
                array(
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ),
                'ip' => '52.168.67.32',
                'location' =>
                array(
                    'latitude' => '-22.970722',
                    'longitude' => '43.182365',
                ),
                'shipping' =>
                array(
                    'amount' => $ship->tipo == 'Receber em Casa' ? (str_replace('.', '', number_format($transporte->valor_frete, 2, '.', ''))) : null,
                    'description' => $ship->tipo == 'Receber em Casa' ? 'Entrega' : 'Retirar na Loja',
                    'recipient_name' => auth()->user()->name,
                    'recipient_phone' => $telefone,
                    'address' =>
                    array(
                        'line_1' => $adress->endereco,
                        'zip_code' => $adress->cep,
                        'city' => $adress->cidade,
                        'state' => $adress->estado,
                        'country' => 'BR',
                    ),
                ),
                'antifraud' =>
                array(
                    'type' => 'clearsale',
                    'clearsale' =>
                    array(
                        'custom_sla' => '90',
                    ),
                ),
                'session_id' => '322b821a',
                'device' =>
                array(
                    'platform' => 'ANDROID OS',
                ),
                'payments' =>
                array(
                    0 =>
                    array(
                        'payment_method' => 'credit_card',
                        'credit_card' =>
                        array(
                            'recurrence' => false,
                            'installments' => 1,
                            'statement_descriptor' => 'AVENGERS',
                            'card' =>
                            array(
                                'number' => $request->numero,
                                'holder_name' => $request->name,
                                'exp_month' => $request->mes,
                                'exp_year' => $request->ano,
                                'cvv' => $request->cvv,
                                'billing_address' =>
                                array(
                                    'line_1' => $adress->endereco,
                                    'zip_code' => $adress->cep,
                                    'city' => $adress->cidade,
                                    'state' => $adress->estado,
                                    'country' => 'BR',
                                ),
                            ),
                        ),
                    ),
                ),
            );
            $transaction = $this->connect('orders', $dados);
            \Log::info($transaction, $items);
            \Cart::clear();
            $transaction = json_decode($transaction);
            Payment::create([
                'user_id' => auth()->user()->id,
                'pedido_id' => $pedido->id,
                'payment_method' => $request->metodo,
                'url_qr' => null,
            ]);

            return response()->json(['success'], 200);
        }
        if ($request->metodo == 'pix') {
            $dados = array(
                'items' => $items,
                'customer' =>
                array(
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'type' => 'individual',
                    'document' => '09392129947',
                    'phones' =>
                    array(
                        'home_phone' =>
                        array(
                            'country_code' => '55',
                            'number' => '985214474',
                            'area_code' => '41',
                        ),
                    ),
                ),
                'payments' =>
                array(
                    0 =>
                    array(
                        'payment_method' => 'pix',
                        'pix' =>
                        array(
                            'expires_in' => '52134613',
                            // 'additional_information' =>
                            // array(
                            //     0 =>
                            //     array(
                            //         'name' => 'Quantidade',
                            //         'value' => '2',
                            //     ),
                            // ),
                        ),
                    ),
                ),
                'shipping' =>
                array(
                    'amount' => $ship->tipo == 'Receber em Casa' ? (str_replace('.', '', number_format($transporte->valor_frete, 2, '.', ''))) : null,
                    'description' => $ship->tipo == 'Receber em Casa' ? 'Entrega' : 'Retirar na Loja',
                    'recipient_name' => auth()->user()->name,
                    'recipient_phone' => $telefone,
                    'address' =>
                    array(
                        'line_1' => $adress->endereco,
                        'zip_code' => $adress->cep,
                        'city' => $adress->cidade,
                        'state' => $adress->estado,
                        'country' => 'BR',
                    ),
                ),
            );
            $transaction = $this->connect('orders', $dados);
            \Log::info($transaction);
            // \Cart::clear();

            $transaction = json_decode($transaction);
            $code = $this->getCode($transaction->charges[0]->last_transaction->qr_code_url);

            $payment = Payment::create([
                'user_id' => auth()->user()->id,
                'pedido_id' => $pedido->id,
                'order_id' => $transaction->id,
                'payment_method' => $request->metodo,
                'url_qr' => $transaction->charges[0]->last_transaction->qr_code_url,
            ]);

            return response()->json(['success', $payment->id], 200);
        }
        // or_orVjzeKuJugPJyGX

        // if ($transaction->metodo == 'pix') {
        //     \Cart::clear();
        //     return response()->json(['success'], 200);
        // }
        // $transaction = json_decode($transaction);
        // $dados = [
        //     'amount' => $valor,
        //     'code' => $transaction->code,
        // ];
        // $transaction = $this->connect("charges/".$transaction->charges[0]->id."/capture", $dados);

    }

    public function pedidoConcluido($id = null)
    {
        if($id){
            $payment = Payment::find($id);
            if ($payment->payment_method == 'pix') {
                $code = $this->getCode($payment->url_qr);
            } else {
                $code = '';
            }
        }

        return view('front.carrinho.pedido-concluido', get_defined_vars());
    }

    public function getCode($code)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);

        curl_close($curl);
        return $image = 'data:' . $info['content_type'] . ';base64,' . base64_encode($response);
    }


    public function webhook(Request $request)
    {
        \Log::info(json_encode($request->getContent()));
    }
}
