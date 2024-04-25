<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\MenuCategoriesController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\ItemCategoriesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\HotelStaffsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\StoreIssuesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\ServersController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\DashboardController;
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
        Route::get('purchases/getPurchaseData/{id}', 'PurchasesController@getPurchaseData')->name('purchases.getPurchaseData');
        Route::get('menu_categories/getMenuData/{id}/', 'MenuCategoriesController@getMenuData')->name('menu_categories.getMenuData');
        Route::get('hotels/onboard_hotels', 'HotelsController@onboardHotels')->name('hotels.onboard_hotels');
        Route::get('hotels/register_hotels', 'HotelsController@registerHotels')->name('hotels.register_hotels');
        /**
         * Masters Route
         */   
        Route::resource('hotels', HotelsController::class);
        Route::resource('menu_categories', MenuCategoriesController::class);
        Route::resource('menus', MenusController::class);
        Route::resource('item_categories', ItemCategoriesController::class);
        Route::resource('items', ItemsController::class);
        Route::resource('hotel_staffs', HotelStaffsController::class);
        Route::resource('suppliers', SuppliersController::class);
        Route::resource('purchases', PurchasesController::class);
        Route::resource('store_issues', StoreIssuesController::class);
        Route::resource('payments', PaymentsController::class);
        Route::resource('tables', TablesController::class);
        Route::resource('servers', ServersController::class);
        Route::resource('packages', PackagesController::class);
        Route::resource('orders', OrdersController::class);
        Route::get('/{order}/bill', 'OrdersController@bill')->name('orders.bill');
        Route::patch('/{order}/updatePaymentData', 'OrdersController@updatePaymentData')->name('orders.updatePaymentData');
        // Route::resource('subscriptions', SubscriptionsController::class);
        Route::get('/{hotel}/subscription', 'HotelsController@subscription')->name('hotels.subscription');
        Route::patch('hotels/storeSubscription/{hotel}', 'HotelsController@storeSubscription')->name('hotels.storeSubscription');
        Route::patch('hotels/updateTagLine/{hotel}', 'HotelsController@updateTagLine')->name('hotels.updateTagLine');
        Route::resource('sections', SectionsController::class);   
        Route::resource('teams', TeamsController::class);   
        Route::resource('/table', DashboardController::class);
    });

    Route::group(['middleware' => ['auth']], function() {  

        Route::get('profile', 'ProfileController@index')->name('profile.change');       
        Route::post('profile', 'ProfileController@changePassword')->name('profile.change');       
        Route::get('profile/edit/{user}', 'ProfileController@edit')->name('profile.edit');       
        Route::post('profile/{user}/update', 'ProfileController@update')->name('profile.update');      
      
    });
});


require __DIR__.'/auth.php';
