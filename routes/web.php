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
    return view('/home');
});

Auth::routes();

Route::get('', App\Http\Livewire\AllStaff\Index::class);
Route::get('/home', App\Http\Livewire\AllStaff\Index::class)->name('home');
Route::get('/profile/{staffId}', App\Http\Livewire\AllStaff\Profile::class);


Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function (){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    Route::get('/titles', App\Http\Livewire\Admin\Title\Index::class);
    Route::get('/social-media', App\Http\Livewire\Admin\SocialMedia\Index::class);
    // Route::get('/roles', App\Http\Livewire\Admin\Role\index::class);
    Route::get('/faculties', App\Http\Livewire\Admin\Faculty\Index::class);
    Route::get('/departments', App\Http\Livewire\Admin\Department\Index::class);
    Route::get('/programmes', App\Http\Livewire\Admin\Programme\Index::class);

    Route::get('/staff', App\Http\Livewire\Admin\User\AcademicStaff::class);
    Route::get('/profile/{staffId}', App\Http\Livewire\Admin\User\Profile::class);
});

Route::prefix('staff')->middleware(['isStaff'])->group(function (){
    Route::get('/profile', App\Http\Livewire\Staff\Profile\Index::class);
    Route::get('/interests', App\Http\Livewire\Staff\Interests\Index::class);
    Route::get('/publications', App\Http\Livewire\Staff\Publications\Index::class);
    Route::get('/socialmedia', App\Http\Livewire\Staff\SocialMedia\Index::class);
});

