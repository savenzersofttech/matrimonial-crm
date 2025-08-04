<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboard,
    LeadAssignmentController,
    SalesTargetController,
};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;


use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\PaypalController;

use App\Http\Controllers\Services\{
    ProfileSearchController,
    PaymentLinkController,
    ServiceController as OngoingServicesController,
    WelcomeCallController,
};
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileAssignmentController;

//sales
use App\Http\Controllers\Sales\{
    LeadController,
    LeadActivityController,
    LeadManagementController,
    TargetSettingController,
    TodayTaskController,
    FollowUpController,
    SalesReportController,
};



Route::get('/dashboard', function () {
    return 'Hello Dashboard';
})->name('dashboard');


Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');

    return '✅ All caches cleared successfully!';
});


Route::get('/get-country', function () {
    $path = public_path('assets/custom/country-list.json');
    return response()->file($path);
})->name('get-countrys');

// Root route: Redirect based on user role
Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'super-admin' => redirect()->route('admin.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            'sales' => redirect()->route('sales.dashboard'),
            'services' => redirect()->route('services.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});


foreach (['admin','super-admin', 'sales', 'services'] as $role) {
    Route::prefix($role)->middleware(['auth'])->group(function () use ($role) {
        Route::resource('profiles', CustomerProfileController::class)->names([
            'index' => "$role.profiles.index",
            'create' => "$role.profiles.create",
            'store' => "$role.profiles.store",
            'show' => "$role.profiles.show",
            'edit' => "$role.profiles.edit",
            'update' => "$role.profiles.update",
            'destroy' => "$role.profiles.destroy",
        ]);

        Route::post('profiles/casts', [CustomerProfileController::class, 'showCasts'])->name("$role.profiles.showCasts");
        Route::get('profiles/next-id', [CustomerProfileController::class, 'peekNextProfileId'])->name("$role.profiles.nextId");
        Route::get('profiles/pdf', [CustomerProfileController::class, 'downloadProfilePdf'])->name("$role.profiles.pdf");
        
    });
}


// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('profiles', CustomerProfileController::class);
    Route::post('/profiles/casts', [CustomerProfileController::class, 'showCasts'])->name('profiles.showCasts');


    Route::get('/profiles/next-id', [CustomerProfileController::class, 'peekNextProfileId'])->name('profiles.nextId');
    Route::get('/profiles/pdf', [CustomerProfileController::class, 'downloadProfilePdf'])->name('profiles.pdf');
    Route::resource('employees', EmployeesController::class);
    Route::get('employees/xxx', [EmployeesController::class, 'index'])->name('employees.assign');

    //ROLES AMD PERMISSIONS
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/', [PermissionController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::put('/{role}', [PermissionController::class, 'update'])->name('update');
    });

    Route::resource('assigns', ProfileAssignmentController::class);
    Route::resource('lead_assignments', LeadAssignmentController::class);
    Route::resource('sales-targets', SalesTargetController::class);
});



// Sales routes
Route::middleware(['auth'])->prefix('sales')->name('sales.')->group(function () {
    Route::get('/dashboard', [SalesController::class, 'index'])->name('dashboard');
    Route::resource('leads', LeadController::class);
    
    Route::resource('sales', LeadActivityController::class);
    Route::resource('target', TargetSettingController::class);
    Route::resource('tasks', TodayTaskController::class);
    Route::resource('follow-up', FollowUpController::class);
    Route::resource('reports', SalesReportController::class);
});


// Services routes
Route::middleware(['auth'])->prefix('services')->name('services.')->group(function () {
    Route::get('/dashboard', [ServicesController::class, 'dashboard'])->name('dashboard');
    Route::resource('welcome-calls', WelcomeCallController::class);
    //for show log of welcomecall
    Route::post('/welcome-calls/log', [WelcomeCallController::class, 'historyLogs'])->name('welcome-calls.logs');

    Route::resource('services', OngoingServicesController::class);
    Route::get('/history/{id}', [OngoingServicesController::class, 'showHistory'])->name('services.history');

    Route::resource('reports', ProfileSearchController::class);
    Route::get('/reports/profiles/search/results', [ProfileSearchController::class, 'search'])->name('reports.search');
    Route::get('/profile-reports-z', [ProfileSearchController::class, 'index'])->name('profile-reports.send');

    Route::resource('payments', PaymentLinkController::class);
});


// Profile routes
Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    
    Route::get('//users/{users}/profile', [ProfileController::class, 'profile'])->name('profile.edit');
    Route::get('/profile/{profile}/edit', [UserController::class, 'edit'])->name('user_management.users.edit');
    Route::post('/user_management/users/{user}', [UserController::class, 'update'])->name('user_management.users.update');
    Route::delete('/user_management/users/{user}/destroy', [UserController::class, 'destroy'])->name('user_management.users.destroy');

});

Route::prefix('paypal')->name('paypal.')->group(function () {
    Route::post('/create-order', [PaypalController::class, 'createOrder'])->name('create');
    Route::get('/success', [PaypalController::class, 'capture'])->name('success');
    Route::get('/cancel', [PaypalController::class, 'cancel'])->name('cancel');
});


Route::prefix('paypal')->name('paypal.')->group(function () {
    Route::get('/payment/success', [PaypalController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/cancel', [PaypalController::class, 'paymentCancel'])->name('payment.cancel');
    Route::get('/payment/failed', [PaypalController::class, 'paymentFailed'])->name('payment.failed');
});


Route::get('/paypal/create', [PayPalController::class, 'createTransaction'])->name('paypal.create');
Route::get('/pay-payment/{token}', [PaypalController::class, 'showPaymentPage'])->name('paypal.payment.page');



//API ROUTES
 //servies api
    Route::post('services/welcome-calls/show-all', [WelcomeCallController::class, 'showAll'])->name('services.welcome-calls.showAll.api');

    
require __DIR__ . '/auth.php';
