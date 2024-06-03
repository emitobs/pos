<?php

use App\Http\Controllers\ConfigController;
use App\Http\Livewire\AssignPermissionToRoleController;
use App\Http\Livewire\PaymentsMethodsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\ClientsController;
use App\Http\Livewire\ProductsController;
use App\Http\Livewire\CoinsController;
use App\Http\Livewire\DebtsController;
use App\Http\Livewire\PosController;
use App\Http\Livewire\LocalController;
use App\Http\Livewire\OrdersController;
use App\Http\Livewire\ReportsController;
use App\Http\Livewire\ReportsdaysController;
use App\Http\Livewire\PayrollsController;
use App\Http\Livewire\KitchenController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\PermissionController;
use App\Http\Livewire\UserController;
use App\Http\Livewire\Menu;
use App\Http\Livewire\DeliveriesController;
use App\Http\Livewire\Beepersperson;
use App\Http\Livewire\BeepersController;
use App\Models\Address;
use App\Models\Cliente;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PdfController;
use App\Http\Livewire\PaymentsOutController;
use App\Http\Livewire\TablesController;

use App\Http\Livewire\ProcesarPedido;
use App\Http\Livewire\RafflesController;

use App\Http\Livewire\QrCajasController;

use App\Http\Livewire\QuickPosController;
use App\Models\Articulos;
use App\Models\Product;
use App\Models\Supplier;
use App\Http\Livewire\Suppliers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Menu::class)->name('shop');
Route::get('/menu', Menu::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('categories', CategoriesController::class)->middleware('auth');

Route::get('products', ProductsController::class)->middleware('auth');
Route::get('coins', CoinsController::class)->middleware('auth');
//Route::get('local', LocalController::class)->middleware('auth')->name('PosController');
Route::get('nuevopedido', PosController::class)->middleware('auth')->name('PosController');
Route::get('nueva-venta', QuickPosController::class)->middleware('auth')->name('QuickPosController');
Route::get('pedidos', OrdersController::class)->middleware('auth');
Route::get('reports', ReportsController::class)->middleware('auth');
Route::get('reportsdays', ReportsdaysController::class)->middleware('auth');
Route::get('payrolls', PayrollsController::class)->middleware('auth');
Route::get('kitchen', KitchenController::class)->middleware('auth');
Route::get('roles', RolesController::class)->middleware('auth');
Route::get('permissions', PermissionController::class)->middleware('auth');
Route::get('asignPermissionsToRole', AssignPermissionToRoleController::class)->middleware('auth');
Route::get('usuarios', UserController::class);
Route::get('deliveries', DeliveriesController::class);
Route::get('clients', ClientsController::class);
Route::get('debts', DebtsController::class);
Route::get('beepers', BeepersController::class);
Route::get('beepersperson', Beepersperson::class);
Route::get('/generatePDF', [PdfController::class, 'generatePDF'])->name('generatePDF');
Route::get('/mesas', TablesController::class)->name('mesas');
//Route::get('/procesarServicio/{id}', ProcessServicioController::class)->name('endservice');
Route::get('/procesar', ProcesarPedido::class)->name('endservice');
Route::get('/sorteos', RafflesController::class);
Route::get('/qrcajas', QrCajasController::class);
Route::get('/config', [ConfigController::class, 'index']);
Route::get('/payments_methods', PaymentsMethodsController::class);
Route::get('/proveedores', Suppliers::class);
Route::get('/gastos', PaymentsOutController::class);
//Route::get('/processCart', ProcessCartController::class)->name('processCart');
Route::get('/migrar', function () {
    $articulos = Articulos::on('bellas')->get();

    foreach ($articulos as $proveedor) {
        try {
            if (!$proveedor->IdFamilia || $proveedor->IdFamilia == "")
                $proveedor->IdFamilia = "0";

            if (!$proveedor->Ganancia)
                $proveedor->Ganancia = 0;

            if (!$proveedor->StockActual)
                $proveedor->StockActual = 0;
            if (!$proveedor->PrecioCompra)
                $proveedor->PrecioCompra = 0;

            Product::create([
                'id' => $proveedor->codbarra,
                'name' => $proveedor->proveedor,
                'barcode' => $proveedor->codbarra,
                'stock' => $proveedor->StockActual,
                'alerts' => $proveedor->StockMin,
                'category_id' => $proveedor->IdFamilia,
                'unit_sale' => $proveedor->UnidadId,
                'price' => $proveedor->PrecioVenta,
                'cost' => $proveedor->PrecioCompra,
                'gain' => $proveedor->Ganancia
            ]);

        } catch (Exception $e) {
            dd($e, $proveedor);
        }

    }
    echo 'COMPLETADO';
});

Route::get('/migrate-suppliers', function () {
    $proveedores = DB::connection('bellas')->table('proveedor')->get();
    foreach ($proveedores as $proveedor) {
        try {
            Supplier::create([
                'name' => $proveedor->nombre,
                'contactPerson' => $proveedor->contacto,
                'phone' => $proveedor->telefono,
                'email' => $proveedor->mail,
                'address' => $proveedor->direccion,
                'location' => $proveedor->Localidad,
                'rut' => $proveedor->rut
            ]);

        } catch (Exception $e) {
            dd($e, $proveedor);
        }

    }
    echo 'COMPLETADO';
});
// Route::get('/generarCodebar', function () {
//     foreach (Product::where('barcode', '')->get() as $product) {
//         $barcode = mt_rand(100000000, 999999999999);
//         $xproduct = Product::where('barcode', $barcode)->get()->first();
//         if (isset($xproduct)) {
//             break;
//         } else {
//             $product->barcode = $barcode;
//             $product->save();
//         }
//     }
//     echo 'completado';
// });

// Route::get('/actualizarPrecios', function () {
//     $articulos = Articulos::on('bellas')->get();

//     foreach ($articulos as $proveedor) {
//         $product = Product::where('name', $proveedor->proveedor)->get()->first();
//         if ($product) {
//             $product->price = $proveedor->PrecioVenta;
//             $product->cost = $proveedor->PrecioCompra;
//             $product->save();
//         }
//     }
//     echo 'completado';
// });


// Route::get('/actualizarGanancia', function () {
//     $articulos = Articulos::on('bellas')->get();

//     foreach ($articulos as $proveedor) {
//         $product = Product::where('name', $proveedor->proveedor)->get()->first();
//         if ($product) {
//             $product->gain = $proveedor->Ganancia;
//             $product->save();
//         }
//     }
//     echo 'completado';
// });

Route::get('/migrateClients', function () {
    try {

        $clientes = Cliente::on('bellas')->get();
        foreach ($clientes as $cliente) {
            $new_client = Client::create([
                'name' => $cliente->Nombre,
                'telephone' => $cliente->Telefono,
                'email' => $cliente->Mail,
                'rut' => $cliente->Rut,
                'ci' => $cliente->Ci,
                'creditLimit' => $cliente->Limite,
                'allowed_debts' => $cliente->Credito,

            ]);

            if ($new_client && strlen($cliente->Direccion) > 0) {
                $default_address = Address::create([
                    'address' => $cliente->Direccion,
                    'client_id' => $new_client->id,
                    'default' => 1
                ]);

                if ($default_address) {
                    $new_client->address_id = $default_address->id;
                    $new_client->save();
                }
            }
        }

        echo 'completado';
    } catch (Exception $e) {
        DB::rollBack();
        dd($e);
    }
});
