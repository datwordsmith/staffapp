<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function (){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    Route::get('/titles', App\Http\Livewire\Admin\Title\index::class);
    // Route::get('/roles', App\Http\Livewire\Admin\Role\index::class);
    Route::get('/faculties', App\Http\Livewire\Admin\Faculty\index::class);
    Route::get('/departments', App\Http\Livewire\Admin\Department\index::class);
    Route::get('/programmes', App\Http\Livewire\Admin\Programme\index::class);

    Route::get('/academic_staff', App\Http\Livewire\Admin\User\AcademicStaff::class);
    Route::get('/profile/{staffId}', App\Http\Livewire\Admin\User\Profile::class);

});
