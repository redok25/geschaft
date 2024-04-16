<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['permission:customer-crud'])->group(function () {
    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer');
        Route::post('/', [CustomerController::class, 'post'])->name('customer.post');
        Route::get('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
    });
});

Route::middleware(['permission:product-crud'])->group(function () {
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::post('/', [ProductController::class, 'post'])->name('product.post');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    });
});

Route::middleware(['permission:sale-crud'])->group(function () {
    Route::prefix('order')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('sale');
        Route::post('/', [SaleController::class, 'post'])->name('sale.post');
        Route::get('/delete/{id}', [SaleController::class, 'delete'])->name('sale.delete');
    });
});

require __DIR__ . '/auth.php';

// PART OF TEST
Route::get('test-datatables', function (Request $request) {

    if ($request->ajax()) {
        $model = User::query();

        return DataTables::eloquent($model)
            ->addColumn('role', function ($d) {
                return $d->roles[0]->name;
            })
            ->make(true);
    }

    return view('test.datatables');
})->name('test.datatables');
