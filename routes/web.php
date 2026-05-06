<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarSaleRequestController;
use App\Http\Controllers\ChatbotController;
// use App\Http\Controllers\CarSaleRequestController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\CarSaleRequest;
use Illuminate\Support\Facades\Route;
// use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Redirect رئيسي حسب role
|--------------------------------------------------------------------------
*/
// Route::get('/', function () {
//     if (!auth()->check()) {
//         return redirect()->route('/');
//     }

//     $role = auth()->user()->role;

//     if ($role === 'customer') {
//         return redirect()->route('welcome');
//     }

//     return redirect()->route('dashboard');
// });


/*
|--------------------------------------------------------------------------
| Dashboard (admin, manager, employee, driver)
|--------------------------------------------------------------------------
*/

Route::prefix('dashboard')
    ->middleware(['auth', 'role:admin,manager,employee,driver'])
    ->group(function () {

        Route::get('/', function () {
            return view('dashboard.index');
        })->name('dashboard');

        // ─── Manager routes ────────────────────────────────────────────
        Route::middleware(['role:manager'])->group(function () {
            Route::resource('employees', EmployeeController::class);
            Route::resource('brands',    BrandController::class);
            Route::resource('models',    ModelController::class);
            Route::resource('drivers',   DriverController::class);
            Route::resource('users',     UserController::class);



        Route::get ('car-sale-requests',[CarSaleRequestController::class, 'index'])->name('car-sale-requests.index');
        Route::get ('car-sale-requests/{carSaleRequest}',[CarSaleRequestController::class, 'show'])->name('car-sale-requests.show');
        Route::post('car-sale-requests/{carSaleRequest}/approve',[CarSaleRequestController::class, 'approve'])->name('car-sale-requests.approve');
        Route::post('car-sale-requests/{carSaleRequest}/reject',[CarSaleRequestController::class, 'reject'])->name('car-sale-requests.reject');
        Route::post('car-sale-requests/{carSaleRequest}/needs-modification',[CarSaleRequestController::class, 'needsModification']) ->name('car-sale-requests.needs-modification');




        });

        // ─── Employee routes ───────────────────────────────────────────
        Route::middleware(['role:employee'])->group(function () {

            Route::resource('cars',      CarController::class);
            Route::resource('customers', CustomerController::class);
            Route::resource('reservations', ReservationController::class);

            // Reservation approval
            Route::get( 'reservations/{reservation}/approve', [ReservationController::class, 'approveForm'])->name('reservations.approve.form');
            Route::post('reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
            Route::post('reservations/{reservation}/reject',  [ReservationController::class, 'reject'])->name('reservations.reject');

            // Deliveries — employee view
            // Route::get(  'deliveries',                       [DeliveryController::class, 'index'])->name('deliveries.index');
            // Route::get(  'deliveries/{delivery}',            [DeliveryController::class, 'show'])->name('deliveries.show');
            // Route::patch('deliveries/{delivery}/reassign',   [DeliveryController::class, 'reassign'])->name('deliveries.reassign');

            // Contacts
            Route::get(   'contacts',             [ContactController::class, 'index'])->name('contacts.index');
            Route::delete('contacts/{contact}',   [ContactController::class, 'destroy'])->name('contacts.destroy');
            Route::delete('contacts',             [ContactController::class, 'destroyAll'])->name('contacts.destroy.all');
        });

        // ─── Driver Portal ─────────────────────────────────────────────
        Route::prefix('driver')
            ->middleware(['role:driver'])
            ->name('driver.')
            ->group(function () {

                Route::get('/dashboard',[DeliveryController::class, 'driverDashboard'])->name('dashboard');
                Route::get('/deliveries',[DeliveryController::class, 'index'])->name('deliveries');
                Route::get('/del/{delivery}/',[DeliveryController::class, 'show'])->name('del.show');

                Route::patch('deliveries/{delivery}/accept',[DeliveryController::class, 'accept'])->name('delivery.accept');
                Route::patch('deliveries/{delivery}/reject',[DeliveryController::class, 'reject'])->name('delivery.reject');
                Route::patch('deliveries/{delivery}/start',[DeliveryController::class, 'startDelivery'])->name('delivery.start');
                Route::patch('deliveries/{delivery}/delivered',[DeliveryController::class, 'markDelivered'])->name('delivery.delivered');
            });

        // ─── Catch-all (must be last) ──────────────────────────────────
        Route::get('/{page}', [AdminController::class, 'index']);
    });

/*
|--------------------------------------------------------------------------
| Customer (welcome)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])
    ->group(function () {
Route::prefix('')->name('welcome.')->group(function () {
    Route::get('/',[WelcomeController::class, 'index'])->name('index');
    Route::get('/rentcar',[WelcomeController::class, 'rentcar'])->name('rentcar');
    Route::get('/buycar',[WelcomeController::class, 'buycar'])->name('buycar');


//    Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');



    Route::get('/about',   fn() => view('welcome.about'))  ->name('about');
    Route::get('/vehicle', fn() => view('welcome.vehicle'))->name('vehicle');
    Route::get('/team',    fn() => view('welcome.team'))   ->name('team');
    Route::get('/blog',    fn() => view('welcome.blog'))   ->name('blog');
    Route::get('/contact', fn() => view('welcome.contact'))->name('contact');


 Route::post('/favorites/{car}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
// Welcome / Customer routes
Route::get('/booking/{car}',  [BookingController::class, 'showBooking'])->name('booking.show')->middleware('auth');
Route::post('/booking/{car}', [BookingController::class, 'storeBooking'])->name('booking.store')->middleware('auth');
Route::get('/booking/success/{id}', [BookingController::class, 'bookingSuccess'])->name('booking.success');



        Route::get ('car-sale-requests/create',[CarSaleRequestController::class, 'create'])->name('car-sale-requests.create');
        Route::post('car-sale-requests',[CarSaleRequestController::class,'store'])      ->name('car-sale-requests.store');
        Route::get ('car-sale-requests/my',[CarSaleRequestController::class, 'myRequests']) ->name('car-sale-requests.my');

// Welcome frontend routes
Route::get('/sell-your-car', [WelcomeController::class, 'sellCar'])->name('sell-car');

Route::post('/chatbot/message', [ChatbotController::class, 'sendMessage'])->name('chatbot.message');





});


});


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Auth (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
