<?php

// By jeancinck
// Check if user has relevant role else logout him
// ---

/*
|--------------------------------------------------------------------------
| Wallet Routes
|--------------------------------------------------------------------------
|
| Here is where you can register wallet routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WalletController@index')->name('wallet.index');
Route::get('/login', 'LoginController@showLoginForm')->name('wallet.login');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout')->name('wallet.logout');

Route::match(['get', 'post'], '/search', 'WalletController@search')->name('wallet.search');
Route::match(['get', 'post'], '/account/{frontuser}/deposit', 'WalletController@deposit')->name('wallet.deposit');

Route::get('/reports/{type?}', 'WalletController@reports')->name('wallet.reports');

// Fallback route
Route::get('{params}', function ($params) {
    $request = resolve('Illuminate\Http\Request');
    return redirect()->to(str_replace('wallet.', '', $request->url()));
});


// ---

