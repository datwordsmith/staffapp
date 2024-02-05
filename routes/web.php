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

Route::get('', App\Http\Livewire\AllStaff\index::class);
Route::get('/home', App\Http\Livewire\AllStaff\index::class)->name('home');
Route::get('/profile/{staffId}', App\Http\Livewire\AllStaff\Profile::class);


Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function (){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    Route::get('/titles', App\Http\Livewire\Admin\Title\index::class);
    Route::get('/social-media', App\Http\Livewire\Admin\SocialMedia\index::class);
    // Route::get('/roles', App\Http\Livewire\Admin\Role\index::class);
    Route::get('/faculties', App\Http\Livewire\Admin\Faculty\index::class);
    Route::get('/departments', App\Http\Livewire\Admin\Department\index::class);
    Route::get('/programmes', App\Http\Livewire\Admin\Programme\index::class);

    Route::get('/staff', App\Http\Livewire\Admin\User\AcademicStaff::class);
    Route::get('/profile/{staffId}', App\Http\Livewire\Admin\User\Profile::class);
});

Route::prefix('staff')->middleware(['isStaff'])->group(function (){
    Route::get('/profile', App\Http\Livewire\Staff\Profile\index::class);
    Route::get('/interests', App\Http\Livewire\Staff\Interests\index::class);
    Route::get('/publications', App\Http\Livewire\Staff\Publications\index::class);
    Route::get('/socialmedia', App\Http\Livewire\Staff\SocialMedia\index::class);
});

