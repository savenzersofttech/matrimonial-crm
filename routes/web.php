<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboard,
    LeadAssignmentController
};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;


use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ServicesController;

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
    SalesTrackingController,
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
});



// Sales routes
Route::middleware(['auth'])->prefix('sales')->name('sales.')->group(function () {
    Route::get('/dashboard', [SalesController::class, 'index'])->name('dashboard');
    Route::resource('leads', LeadController::class);
    
    Route::resource('sales', SalesTrackingController::class);
    Route::resource('target', TargetSettingController::class);
    Route::resource('tasks', TodayTaskController::class);
    Route::resource('follow-up', FollowUpController::class);
    Route::resource('reports', SalesReportController::class);
});


// Services routes
Route::middleware(['auth'])->prefix('services')->name('services.')->group(function () {
    Route::get('/dashboard', [ServicesController::class, 'dashboard'])->name('dashboard');
    Route::resource('welcome-calls', WelcomeCallController::class);
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

require __DIR__ . '/auth.php';
