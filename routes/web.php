<?php


use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/admin/dataadmin', function () {
    return view('admin.dataadmin');
});

Route::get('/admin/perusahaan', function () {
    return view('admin.perusahaan');
});

Route::get('/admin/arsip', function () {
    return view('admin.arsip');
});


Route::get('', function () {
    return view('admin.dashboard');
});



// Route::prefix('/')->middleware('auth')->group(function (){
    


//     Route::match(['POST','GET'],'/user', [\App\Http\Controllers\Admin\UserController::class,'index']);


// });





Route::match(['GET','POST'],'/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('login');
