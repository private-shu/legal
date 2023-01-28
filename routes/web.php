<?php

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

// ヘルスチェック通すために作ったエンドポイント
Route::get('/api/systems/ping', function () {
    return response()->json([
        'ping' => 'pong'
    ], 200);
});

Auth::routes();
Route::get('/', [App\Http\Controllers\ContractController::class, 'list'])->name('contract.list');
// 案件
Route::get('/contract/list', [App\Http\Controllers\ContractController::class, 'list'])->name('contract.list');
Route::post('/contract/search', [App\Http\Controllers\ContractController::class, 'search'])->name('contract.search');
Route::get('/contract/search', [App\Http\Controllers\ContractController::class, 'search'])->name('contract.search');
Route::get('/contract/create', [App\Http\Controllers\ContractController::class, 'create'])->name('contract.create');
Route::post('/contract/store', [App\Http\Controllers\ContractController::class, 'store'])->name('contract.store');
Route::get('/contract/detail/{id}', [App\Http\Controllers\ContractController::class, 'detail'])->where('id', '[0-9]+')->name('contract.detail');
Route::post('/contract/update', [App\Http\Controllers\ContractController::class, 'update'])->name('contract.update');
Route::post('/contract/delete', [App\Http\Controllers\ContractController::class, 'delete'])->name('contract.delete');
Route::get('/contract/summary', [App\Http\Controllers\ContractController::class, 'summary'])->name('contract.summary');
Route::post('/contract/getSummaryByYear', [App\Http\Controllers\ContractController::class, 'getSummaryByYear'])->name('contract.getSummaryByYear');

// お客様
Route::get('/member/detail/{id}', [App\Http\Controllers\MemberController::class, 'detail'])->where('id', '[0-9]+')->name('member.detail');
Route::post('/member/update', [App\Http\Controllers\MemberController::class, 'update'])->name('member.update');
// ユーザー
Route::get('/user/list', [App\Http\Controllers\UserController::class, 'list'])->name('user.list');
Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::get('/user/detail/{id}', [App\Http\Controllers\UserController::class, 'detail'])->where('id', '[0-9]+')->name('user.detail');
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::post('/user/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');