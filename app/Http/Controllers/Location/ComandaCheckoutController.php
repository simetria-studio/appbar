<?php

namespace App\Http\Controllers\Location;

use App\Models\Adress;
use App\Models\Unity;
use App\Models\Table;
use App\Models\Product;
use App\Models\Comanda;
use App\Models\OrderFlow;
use App\Models\ComandaPayment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComandaCheckoutController extends Controller
{
    public function connect($endpoint, $method, $dados)
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
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($dados),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic '.base64_encode('sk_test_adMxDGMUdAuRw2EO:'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function checkout(Request $request)
    {
        $comanda = Comanda::with('table.unity', 'products.product')->where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->first();
        $address = Adress::where('user_id', auth()->guard('cliente')->user()->id)->orderBy('created_at', 'desc')->first();

        $items = [];
        foreach($comanda->products as $product) {
            $items[] = [
                'amount' => (str_replace('.', '', number_format($product->product->sellprice, 2, '.', ''))),
                'description' => $product->product->name,
                'quantity' => (int)$product->quantity,
            ];
        }

        switch($request->metodo){
            case 'dinheiro': 
                Comanda::find($comanda->id)->update([
                    'payment_method' => $request->metodo,
                    'installments' => '1',
                    'troco' => $request->troco,
                    'status' => 2,
                ]);

                OrderFlow::create([
                    'key' => 'payment_comanda',
                    'key_id' => $comanda->id,
                    'reason' => 'Solicitando pagamento em dinheiro'
                ]);

                return response()->json(['success',route('comanda.checkout.confirma')], 200);
            break;
            case 'card':
                Comanda::find($comanda->id)->update([
                    'payment_method' => $request->metodo,
                    'installments' => '1',
                    'troco' => $request->troco,
                    'status' => 2,
                ]);

                $dados = [
                    'items' =>  $items,
                    'customer' => [
                        'name' => auth()->guard('cliente')->user()->name,
                        'email' => auth()->guard('cliente')->user()->email,
                    ],
                    'ip' => '52.168.67.32',
                    'location' => [
                        'latitude' => '-22.970722',
                        'longitude' => '43.182365',
                    ],
                    'antifraud' =>[
                        'type' => 'clearsale',
                        'clearsale' => [
                            'custom_sla' => '90',
                        ],
                    ],
                    'session_id' => '322b821a',
                    'device' => [
                        'platform' => 'ANDROID OS',
                    ],
                    'payments' =>[
                        [
                            'payment_method' => 'credit_card',
                            'credit_card' => [
                                'recurrence' => false,
                                'installments' => 1,
                                'statement_descriptor' => 'LOJA',
                                'card' => [
                                    'number' => $request->numero,
                                    'holder_name' => $request->name,
                                    'exp_month' => $request->mes,
                                    'exp_year' => $request->ano,
                                    'cvv' => $request->cvv,
                                    'billing_address' => [
                                        'line_1' => $address->endereco,
                                        'zip_code' => $address->cep,
                                        'city' => $address->cidade,
                                        'state' => $address->estado,
                                        'country' => 'BR',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ];

                $transaction = $this->connect('orders', 'POST', $dados);
                \Log::info($transaction);

                $transaction = json_decode($transaction);
                ComandaPayment::create([
                    'client_id' => auth()->guard('cliente')->user()->id,
                    'comanda_id' => $comanda->id,
                    'order_id' => $transaction->id,
                    'payment_method' => $request->metodo,
                    'url_qr' => null,
                ]);
    
                return response()->json(['success', route('comanda.finalizado')], 200);
            break;
            case 'pix':
                Comanda::find($comanda->id)->update([
                    'payment_method' => $request->metodo,
                    'installments' => '1',
                    'troco' => $request->troco,
                ]);

                $dados = [
                    'items' => $items,
                    'customer' =>[
                        'name' => auth()->guard('cliente')->user()->name,
                        'email' => auth()->guard('cliente')->user()->email,
                        'type' => 'individual',
                        'document' => str_replace(['.','-'], '', auth()->guard('cliente')->user()->cpf),
                        'phones' =>[
                            'home_phone' =>[
                                'country_code' => '55',
                                'number' => str_replace(['-'], '', explode(' ',auth()->guard('cliente')->user()->whatsapp)[1]),
                                'area_code' => explode(' ',auth()->guard('cliente')->user()->whatsapp)[0],
                            ],
                        ],
                    ],
                    'payments' =>[
                        [
                            'payment_method' => 'pix',
                            'pix' =>[
                                'expires_in' => '52134613',
                            ],
                        ],
                    ],
                    'shipping' =>[
                        'amount' => null,
                        'description' => 'LOJA',
                        'recipient_name' => auth()->guard('cliente')->user()->name,
                        'recipient_phone' => str_replace([' ', '-'], '', auth()->guard('cliente')->user()->whatsapp),
                        'address' =>[
                            'line_1' => $address->endereco,
                            'zip_code' => $address->cep,
                            'city' => $address->cidade,
                            'state' => $address->estado,
                            'country' => 'BR',
                        ],
                    ],
                ];

                $transaction = $this->connect('orders', 'POST', $dados);
                \Log::info($transaction);

                $transaction = json_decode($transaction);

                $payment = ComandaPayment::create([
                    'client_id' => auth()->guard('cliente')->user()->id,
                    'comanda_id' => $comanda->id,
                    'order_id' => $transaction->id,
                    'payment_method' => $request->metodo,
                    'url_qr' => $transaction->charges[0]->last_transaction->qr_code_url,
                ]);

                return response()->json(['success', route('comanda.pix', $payment->id)], 200);
            break;
        }
    }

    public function comandaCheckoutConfirma()
    {
        $comanda = Comanda::with('table', 'products.product')->where('client_id', auth()->guard('cliente')->user()->id)->where('status', 2)->first();
        if(empty($comanda)) {
            return redirect()->route('comanda.finalizado');
        }

        $OrderFlow = OrderFlow::where('key', 'payment_comanda')->where('key_id', $comanda->id)->where('status', 0)->first();
        return view('location.checkoutConfirma', get_defined_vars());
    }

    public function comandaPix($id)
    {
        $comanda_payment = ComandaPayment::find($id);
        $code = $this->getCode($comanda_payment->url_qr);

        $transaction = $this->connect('orders/'.$comanda_payment->order_id, 'GET', '');
        $transaction = json_decode($transaction);
        if($transaction->status == 'paid') {
            Comanda::with('table.unity', 'products.product')->where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->update(['status' => 2]);
            return redirect()->route('comanda.finalizado');
        }

        return view('location.comandaPix', get_defined_vars());
    }

    public function comandaFinalizado()
    {
        return view('location.finalizado');
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
}
