<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

Route::get('/', function () {
    return view('index');
})->middleware('checklogin')->name('home');

Route::get('/admin', function () {
    return view('admin.index');
})->middleware('checkadminlogin')->name('adminhome');

Route::post('/user/login', [SocialController::class, 'userlogin'])->name('userlogin');

Route::get('/admin/logout', function () {
    session()->forget('admindata');
    session()->flush();
    return redirect()->route('adminhome');
})->name('adminlogout');

Route::post('/admin/checklogin', function(Request $request){
       
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);
    $log = DB::table('tbl_admin')
               ->select('password')
               ->where('username', '=', $request->username)->first();
    if(!is_null($log)){
        if (Hash::check($request->password, $log->password)) {
            session(['admindata' => $request->username]);
            return redirect()->route('adminhome');
        } else {
            return back()->with('failed', 'Wrong Password. Please try again');
        }
    }
         return back()->with('failed', 'Wrong Username/Password. Please try again');                   
})->name('adminlogin');

Route::get('/admin/changepassword/{id}', function (Request $request) {
    return view('form', ['id' => $request->id]);
})->name('changepassword')->middleware('checkadminsession');
Route::get('/admin/user-table', function () {
    return view('table');
})->name('admindashboard')->middleware('checkadminsession');

Route::get('/dashboard', [SocialController::class, 'Dashboard'])->middleware('auth')->name('dashboard');
Route::get('/logout', [SocialController::class, 'UserLogout'])->name('logout');

//Social route for facebook routes
Route::get('/auth/facebook', [SocialController::class, 'facebookRedirect'])->name('login');
Route::get('/auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);
