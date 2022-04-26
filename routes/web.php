<?php

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Notifications\AccountActivated;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TesteController;

use App\Http\Controllers\User\ShippMethod;
use App\Http\Controllers\CapturaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\AdressController;
use App\Http\Controllers\User\PedidoController;

use App\Http\Controllers\User\PerfilController;
use App\Http\Controllers\Painel\TableController;
use Intervention\Image\Commands\ChecksumCommand;

use App\Http\Controllers\Painel\PainelController;
use App\Http\Controllers\Painel\WaiterController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\User\CashbackController;
use App\Http\Controllers\User\RegisterController;

use App\Http\Controllers\Painel\ProductController;
use App\Http\Controllers\Painel\SettingsController;
use App\Http\Controllers\Location\ComandaController;
use App\Http\Controllers\User\ShippMethodController;
use App\Http\Controllers\Location\LocationController;
use App\Http\Controllers\Location\ComandaCheckoutController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group whichmj
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('noti', function () {
    $user = Cliente::where('id', 4)->first();

    $notification_id = $user->notification_id;
    $title = "Greeting Notification";
    $message = "Have good day!";
    $id = $user->id;
    $type = "basic";

    $res = send_notification_FCM($notification_id, $title, $message, $id,$type);
    \Log::info($res);
    if($res == 1){



    }else{

      // fail code
    }
});

Route::get('teste', [TesteController::class, 'index']);

Route::get('store/register', [RegisterController::class, 'index'])->name('store.register');
Route::post('store/register', [RegisterController::class, 'store'])->name('store.register');

Route::get('store/login', [LoginController::class, 'index'])->name('store.login');
Route::post('store/login', [LoginController::class, 'login'])->name('store.login');
Route::post('store/logout', [LoginController::class, 'logout'])->name('store.logout');

Route::get('garcom/login', [WaiterController::class, 'waiterIndex'])->name('waiter.login');
Route::post('garcom/login', [WaiterController::class, 'waiterAuth'])->name('waiter.login');
Route::post('garcom/logout', [WaiterController::class, 'waiterLogout'])->name('waiter.logout');

//checkout
Route::middleware(['auth:cliente'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Delivery App
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('cervejas', [ShopController::class, 'cervejas'])->name('shop.cervejas');
    Route::get('kits', [ShopController::class, 'kits'])->name('shop.kits');
    Route::get('embutidos', [ShopController::class, 'embutidos'])->name('shop.embutidos');
    Route::get('produto/{slug}', [ShopController::class, 'single'])->name('shop.single');

    Route::post('search', [ShopController::class, 'search'])->name('search');
    //cart
    Route::post('cart-add', [CartController::class, 'cartAdd'])->name('cart.add');
    Route::any('cart-remove/{id}', [CartController::class, 'itemRemove'])->name('cart.remove');

    Route::get('pre-checkout', [CheckoutController::class, 'preCheck'])->name('pre.checkout');

    Route::get('perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::get('perfil/editar', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::post('perfil/update', [PerfilController::class, 'update'])->name('perfil.update');
    Route::post('perfil/photo-update', [PerfilController::class, 'update_photo'])->name('perfil.photo.update');

    Route::get('endereco', [AdressController::class, 'index'])->name('address');
    Route::post('endereco/update', [AdressController::class, 'update'])->name('address.update');

    Route::get('perfil/buscaCep', [AdressController::class, 'buscaCep'])->name('address.cep');

    Route::get('cashback', [CashbackController::class, 'index'])->name('cashback');

    Route::get('process', [CheckoutController::class, 'proccess'])->name('checkout.process');
    Route::post('checkout', [CheckoutController::class, 'checkout'])->name('finish');

    Route::get('/pedido-concluido/{id?}', [CheckoutController::class, 'pedidoConcluido'])->name('pedido.concluido');

    Route::get('user/pedidos', [PedidoController::class, 'index'])->name('user.pedidos');
    Route::get('user/pedidos/ver/{id}', [PedidoController::class, 'indexVer'])->name('user.pedidos.ver');

    Route::get('check-in', [LocationController::class, 'checkIn'])->name('checkIn');
    Route::get('check-in/mesa/{unidade?}', [LocationController::class, 'mesa'])->name('mesa');
    Route::post('mesa/gerarComanda', [LocationController::class, 'gerarComanda'])->name('gerarComanda');
    Route::get('mesa/home', [LocationController::class, 'mesaHome'])->name('mesa.home');

    Route::get('mesa/catalogo/{slug}', [LocationController::class, 'catalogo'])->name('mesa.catalogo');
    Route::get('mesa/produto/{slug}', [LocationController::class, 'produto'])->name('mesa.produto');
    Route::post('mesa/add-produto', [LocationController::class, 'addProduto'])->name('mesa.produto.add');
    Route::get('mesa/remove-produto/{id}', [LocationController::class, 'removeProduto'])->name('mesa.produto.remove');

    Route::get('comanda', [ComandaController::class, 'comanda'])->name('comanda');
    Route::get('comanda/fazer-pedido', [ComandaController::class, 'makeWish'])->name('comanda.make_wish');
    Route::get('comanda/confirma', [ComandaController::class, 'comandaConfirma'])->name('comanda.confirma');
    Route::get('comanda/checkout', [ComandaController::class, 'comandaCheckout'])->name('comanda.checkout');
    Route::post('comanda/checkout/finalizar', [ComandaCheckoutController::class, 'checkout'])->name('comanda.checkout.finalizar');
    Route::get('comanda/checkout/confirma', [ComandaCheckoutController::class, 'comandaCheckoutConfirma'])->name('comanda.checkout.confirma');

    Route::get('comanda/give-up', [ComandaController::class, 'give_up'])->name('comanda.give_up');

    Route::get('comanda/pix/{id}', [ComandaCheckoutController::class, 'comandaPix'])->name('comanda.pix');
    Route::get('comanda/finalizado', [ComandaCheckoutController::class, 'comandaFinalizado'])->name('comanda.finalizado');
});

// Waiter / Garçom
Route::middleware(['auth:waiter'])->group(function () {
    Route::get('garcom/check-in', [WaiterController::class, 'waiterCheckInindex'])->name('waiter.check_in');
    Route::post('garcom/check-in', [WaiterController::class, 'waiterCheckIn'])->name('waiter.check_in');
    Route::get('garcom/comandas', [WaiterController::class, 'waiterComandas'])->name('waiter.comanda');
    Route::get('garcom/comanda/{id}', [WaiterController::class, 'waiterComanda'])->name('waiter.comanda.pedido');
    Route::post('garcom/comanda-produto-entregue', [WaiterController::class, 'waiterComandaProductDelivered'])->name('waiter.comanda.pedido.entregue');
    Route::get('garcom/comanda/fechar/{id}', [WaiterController::class, 'waiterComandaClose'])->name('waiter.comanda.fechar');
});

Route::post('user-store', [CapturaController::class, 'store']);
Route::get('obrigado', [CapturaController::class, 'thanks'])->name('thanks');

// Local App


Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/clientes', [DashboardController::class, 'clientes']);

    Route::get('/produtos', [ProductController::class, 'index'])->name('products');
    Route::get('/produtos-edit/{id}', [ProductController::class, 'edit']);
    Route::post('/produtos-store', [ProductController::class, 'store']);
    Route::any('/produtosDelete/{id}', [ProductController::class, 'destroy']);
    Route::any('/produtos-update/{id}', [ProductController::class, 'update']);

    Route::post('/atualizar-stock', [ProductController::class, 'stockUpdate'])->name('stockUpdate');

    Route::get('/painel/pedidos', [PainelController::class, 'index']);
    Route::get('/painel/pedidos/ver/{id}', [PainelController::class, 'ver']);
    Route::post('/painel/pedidos/status/{id}', [PainelController::class, 'status']);

    Route::get('/painel/buscaEstado', [PainelController::class, 'buscaEstado']);
    Route::get('/painel/buscaCidade/{id}', [PainelController::class, 'buscaCidade']);
    Route::get('/painel/buscaBairro/{id}', [PainelController::class, 'buscaBairro']);
    Route::get('/painel/transportes', [PainelController::class, 'transportes']);
    Route::get('/painel/transportes-id/{id}', [PainelController::class, 'transportesId']);

    Route::post('/painel/cadastrarTransporte', [PainelController::class, 'cadastrarTransporte']);
    Route::post('/painel/transportadorEdit', [PainelController::class, 'transportadorEdit']);
    Route::any('/painel/transportadorDelete/{id}', [PainelController::class, 'transportadorDelete']);

    Route::get('/mesas', [TableController::class, 'index'])->name('table');
    Route::post('/mesa/store', [TableController::class, 'store'])->name('table.store');
    Route::get('/mesa/edit/{id}', [TableController::class, 'edit'])->name('table.edit');
    Route::post('/mesa/update/{id}', [TableController::class, 'update'])->name('table.update');
    Route::delete('/mesa/delete/{id?}', [TableController::class, 'destroy'])->name('table.delete');

    Route::post('/unity/store', [TableController::class, 'storeUnity'])->name('table.store.unity');
    Route::get('/unity/edit/{id}', [TableController::class, 'editUnity'])->name('table.edit.unity');
    Route::post('/unity/update/{id}', [TableController::class, 'updateUnity'])->name('table.update.unity');
    Route::delete('/unity/delete/{id?}', [TableController::class, 'destroyUnity'])->name('table.delete.unity');

    Route::get('/settings/admin', [SettingsController::class, 'index'])->name('setting.admin');
    Route::post('/settings/admin/store', [SettingsController::class, 'store'])->name('setting.admin.store');
    Route::get('/settings/admin/edit/{id}', [SettingsController::class, 'edit'])->name('setting.admin.edit');
    Route::post('/settings/admin/update/{id}', [SettingsController::class, 'update'])->name('setting.admin.update');
    Route::delete('/settings/admin/delete/{id?}', [SettingsController::class, 'destroy'])->name('setting.admin.delete');

    Route::get('/settings/waiter', [WaiterController::class, 'index'])->name('setting.waiter');
    Route::post('/settings/waiter/store', [WaiterController::class, 'store'])->name('setting.waiter.store');
    Route::get('/settings/waiter/edit/{id}', [WaiterController::class, 'edit'])->name('setting.waiter.edit');
    Route::post('/settings/waiter/update/{id}', [WaiterController::class, 'update'])->name('setting.waiter.update');
    Route::delete('/settings/waiter/delete/{id?}', [WaiterController::class, 'destroy'])->name('setting.waiter.delete');

    Route::get('/buscaCep', [AdressController::class, 'buscaCep'])->name('painel.cep');
});

//layouts e rotas provisorias

// Route::get('/', function () {
//     return view('front.idade.idade');
// });
Route::get('/inicio', function () {
    return view('front.home.inicio');
});
Route::get('/adc-carrinho', function () {
    return view('front.carrinho.adc-carrinho');
});
//produtos//

// Route::get('/cervejas', function () {
//     return view('front.produtos.cervejas.cervejas');
// });
// Route::get('/kits', function () {
//     return view('front.produtos.kits.kits');
// });
// Route::get('/embutidos', function () {
//     return view('front.produtos.embutidos.embutidos');
// });
// Route::get('/produto-single', function () {
//     return view('front.produto-single.produto-single');
// });

//carrinho//


// Route::get('/finalizar-compra', function () {
//    return view('front.carrinho.finalizar-compra');
//  });
//  Route::get('/efetuar-pagamento', function () {
//    return view('front.carrinho.efetuar-pagamento');
//  });

//Suas Preferencia//

// Route::get('/perfil', function () {
//     return view('front.suas-preferencia.perfil');
// });
// Route::get('/atualizar-perfil', function () {
//     return view('front.suas-preferencia.atualizar-perfil');
// });
// Route::get('/atualizar-endereco', function () {
//     return view('front.suas-preferencia.atualizar-endereco');
// });
// Route::get('/atualizado', function () {
//     return view('front.suas-preferencia.atualizado');
// });

