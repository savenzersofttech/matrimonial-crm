<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\Api\WelcomeCallApiController;
use App\Http\Controllers\{
    EmployeesController,
    LocationController,
};
use App\Http\Controllers\Admin\SalesTargetController;
use App\Http\Controllers\ {
    CustomerProfileController,
    ProfileAssignmentController,
};
use App\Http\Controllers\Services\{ 
    ProfileSearchController,
    PaymentLinkController,
    WelcomeCallController,

};

use App\Http\Controllers\Sales\{ 
    LeadController,
    LeadActivityController,

};


// For API usage:    
Route::get('/locations/countries', [LocationController::class, 'getCountries'])->name('getCountries.api');
Route::get('api/locations/states', [LocationController::class, 'getStates'])->name('getStates.api');
Route::get('/locations/cities/{state_id}', [LocationController::class, 'getCities'])->name('getCities.api');



// Route::middleware(['auth'])->group(function () {

    Route::prefix('welcome-calls')->group(function () {
        Route::get('{profile}', [WelcomeCallApiController::class, 'show'])->name('xxx');


    });

    Route::post('/sales-targets/show-all', [SalesTargetController ::class, 'showAll'])->name('admin.sales-targets.showAll.api');
    Route::post('/sales-activity/show-all', [LeadActivityController::class, 'showAll'])->name('sales.leadactivity.showAll.api');

   

            Route::post('/payments/show-all', [PaymentLinkController::class, 'showAll'])->name('services.payments.showAll');
            Route::post('/employees/show-all', [EmployeesController::class, 'showAll'])->name('admin.employees.showAll');
            Route::post('/profiles/show-all', [CustomerProfileController::class, 'showAll'])->name('admin.profiles.showAll');
            
            Route::post('/assigns/show-all', [ProfileAssignmentController::class, 'showAll'])->name('assigns.showAll.api');
            Route::post('/leads/show-all', [LeadController::class, 'showAll'])->name('leads.showAll.api');
            Route::get('/assigns/json', [ProfileAssignmentController::class,'userAndemployees'])->name('assigns.userAndemployees.api');

// });