<?php


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

Route::match(['GET','POST'],'/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('login');

Route::group(['prefix' => 'admin'], function (){
    Route::get('/', [\App\Http\Controllers\MainController::class, 'index']);

    Route::group(['prefix' => 'admin'], function (){
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'index']);
        Route::post('/create', [\App\Http\Controllers\AdminController::class, 'create']);
        Route::post('/patch', [\App\Http\Controllers\AdminController::class, 'patch']);
        Route::post('/delete', [\App\Http\Controllers\AdminController::class, 'delete']);
    });

    Route::group(['prefix' => 'perusahaan'], function () {
        Route::get('/', [\App\Http\Controllers\PerusahaanController::class, 'index']);
        Route::post('/create', [\App\Http\Controllers\PerusahaanController::class, 'create']);
        Route::post('/patch', [\App\Http\Controllers\PerusahaanController::class, 'patch']);
    });

    Route::group(['prefix' => 'arsip'], function () {
        Route::get('/', [\App\Http\Controllers\ArsipController::class, 'index']);
        Route::get('/data', [\App\Http\Controllers\ArsipController::class, 'get_data_arsip']);
        Route::post('/confirm', [\App\Http\Controllers\ArsipController::class, 'confirm_arsip']);
        Route::post('/delete', [\App\Http\Controllers\ArsipController::class, 'destroy_arsip']);
    });
});

//Route::get('/admin', function () {
//    return view('admin.dashboard');
//});

//Route::get('/admin/dataadmin', function () {
//    return view('admin.dataadmin');
//});

//Route::get('/admin/perusahaan', function () {
//    return view('admin.perusahaan');
//});

//Route::get('/admin/arsip', function () {
//    return view('admin.arsip');
//});


//Route::get('/perusahaan', function () {
//    return view('perusahaan.dashboard');
//});
//
Route::get('/perusahaan/arsip', function () {
    return view('perusahaan.arsip');
});
//
//Route::get('', function () {
//    return view('admin.dashboard');
//});
//Route::get('', function () {
//    return view('admin.dashboard');
//});



// Route::prefix('/')->middleware('auth')->group(function (){



//     Route::match(['POST','GET'],'/user', [\App\Http\Controllers\Admin\UserController::class,'index']);


// });






