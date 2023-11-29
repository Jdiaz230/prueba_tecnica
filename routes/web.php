<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationSendController;

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
Route::get('/success', function () {return view('success');})->name('success_route');

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');

Route::get('/password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset');


Auth::routes();

//Profesional
Route::get('/profesional', [App\Http\Controllers\UsuarioController::class, 'index'])->name('profesional');
Route::post('/profesional/sideserver', [App\Http\Controllers\UsuarioController::class, 'sideserver'])->name('sideserver.profesional');
Route::get('/profesional/edit/{id}', [App\Http\Controllers\UsuarioController::class, 'edit'])->name('edit.profesional');
Route::post('/profesional/update/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])->name('update.profesional');

//Historial
Route::get('/historial/create', [App\Http\Controllers\HistoriaController::class, 'create'])->name('create.historial');
Route::post('/historial/store', [App\Http\Controllers\HistoriaController::class, 'store'])->name('store.historial');
Route::get('/historial',  [App\Http\Controllers\HistoriaController::class, 'index'])->name('historial');
Route::post('/historial/upload/{id?}', [App\Http\Controllers\HistoriaController::class, 'upload'])->name('upload.historial');

//Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Envio de notificaciones
Route::group(['middleware' => 'auth'],function(){
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notification');
});
