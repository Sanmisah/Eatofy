<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HotelsController;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{      
    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
  

    Route::group(['middleware' => ['guest']], function() {
        Route::get('/', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    });
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);

    Route::group(['middleware' => ['auth', 'permission']], function() {       
        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/users/store', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/destroy', 'UsersController@destroy')->name('users.destroy');
        });
        Route::get('profile', 'ProfileController@index')->name('profile.change');    
        /**
         * Masters Route
         */   
        Route::resource('hotels', HotelsController::class);
    });

    Route::group(['middleware' => ['auth']], function() {  

        Route::get('profile', 'ProfileController@index')->name('profile.change');       
        Route::post('profile', 'ProfileController@changePassword')->name('profile.change');       
        Route::get('profile/edit/{user}', 'ProfileController@edit')->name('profile.edit');       
        Route::post('profile/{user}/update', 'ProfileController@update')->name('profile.update');      
      
    });
});


require __DIR__.'/auth.php';
