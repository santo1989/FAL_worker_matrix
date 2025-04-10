<?php
 
use App\Http\Controllers\CompanyController; 
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\MigrateWorkerListController;
use App\Http\Controllers\NotificationController; 
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SewingProcessListController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerEntryController;
use App\Models\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
    
// });

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/s', function () {
    return view('search');
});

// Route::get('/search',  [DivisionController::class, 'search'])->name('search');
Route::get('/user-of-supervisor', function () {
    return view('backend.users.superindex');
})->name('superindex');

//New registration ajax route

Route::get('/get-company-designation/{divisionId}', [CompanyController::class, 'getCompanyDesignations'])->name('get_company_designation');


Route::get('/get-department/{company_id}', [CompanyController::class, 'getdepartments'])->name('get_departments');


Route::middleware('auth')->group(function () {
    // Route::get('/check', function () {
    //     return "Hello world";
    // });

    Route::get('/home', function () {
        return view('backend.home');
    })->name('home');

    //role

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');


    //user

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get(
        '/users/{user}/edit',
        [UserController::class, 'edit']
    )->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/online-user', [UserController::class, 'onlineuserlist'])->name('online_user');

    Route::post('/users/{user}/users_active', [UserController::class, 'user_active'])->name('users.active');

    Route::post('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');

    //divisions

    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::get('/divisions/create', [DivisionController::class, 'create'])->name('divisions.create');
    Route::post('/divisions', [DivisionController::class, 'store'])->name('divisions.store');
    Route::get('/divisions/{division}', [DivisionController::class, 'show'])->name('divisions.show');
    Route::get('/divisions/{division}/edit', [DivisionController::class, 'edit'])->name('divisions.edit');
    Route::put('/divisions/{division}', [DivisionController::class, 'update'])->name('divisions.update');
    Route::delete('/divisions/{division}', [DivisionController::class, 'destroy'])->name('divisions.destroy');
   
    // companies
    Route::resource('companies', CompanyController::class);

    //departments
    Route::resource('departments', DepartmentController::class);

    // designations
    Route::resource('designations', DesignationController::class);

    //sewingProcessList
    Route::resource('sewingProcessList', SewingProcessListController::class);
    Route::post('/sewingProcessList/{spl}/sewingProcessList_active', [SewingProcessListController::class, 'sewingProcessList_active'])->name('sewingProcessList.active');

    //workerEntry 

    Route::get('/workerEntries', [WorkerEntryController::class, 'index'
    ])->name('workerEntries.index'); 
    Route::get('/old_index', [WorkerEntryController::class, 'old_index'])->name('old_index');
    Route::post('/workerEntries/workerEntrys_id_search', [WorkerEntryController::class, 'workerEntrys_id_search'])->name('workerEntrys_id_search');
    Route::get('/workerEntries/create', [WorkerEntryController::class, 'create'])->name('workerEntries.create');
    Route::post('/workerEntrys_id_entry', [WorkerEntryController::class, 'workerEntrys_id_entry'])->name('workerEntrys_id_entry');
    Route::get('/workerEntrys_process_entry_form/{workerEntry}', [WorkerEntryController::class, 'workerEntrys_process_entry_form'])->name('workerEntrys_process_entry_form'); 
    Route::post('/workerEntries/workerEntrys_process_type_search', [WorkerEntryController::class, 'workerEntrys_process_type_search'])->name('workerEntrys_process_type_search');
    Route::post('/workerEntries/workerEntrys_process_entry/{workerEntry}', [WorkerEntryController::class, 'workerEntrys_process_entry'])->name('workerEntrys_process_entry');
    Route::get('/cyclesData_entry_form/{workerEntry}', [WorkerEntryController::class, 'cyclesData_entry_form'])->name('cyclesData_entry_form'); 
    Route::get('/cyclesData_entry/{workerEntry}', [WorkerEntryController::class, 'cyclesData_entry'])->name('cyclesData_entry');
    Route::post('/workerEntries/cyclesData_store/{oe}', [WorkerEntryController::class, 'cyclesData_store'])->name('cyclesData_store');


    
    Route::get('/workerEntrys_matrixData_entry_form/{workerEntry}', [WorkerEntryController::class, 'workerEntrys_matrixData_entry_form'])->name('workerEntrys_matrixData_entry_form');
    Route::post('/matrixData', [WorkerEntryController::class, 'matrixData_store'])->name('matrixData_store');
    Route::get('/workerEntries/{workerEntry}', [WorkerEntryController::class, 'show'])->name('workerEntries.show');
    Route::get('/workerEntries/approval/{workerEntry}', [WorkerEntryController::class, 'approval'])->name('workerEntries.approval');
    Route::post('/approval', [WorkerEntryController::class, 'approval_store'])->name('approval_store');
    Route::get('/workerEntries/{workerEntry}/edit', [WorkerEntryController::class, 'edit'])->name('workerEntries.edit');
    Route::put('/workerEntries/{workerEntry}', [WorkerEntryController::class, 'update'])->name('workerEntries.update');
    Route::delete('/workerEntries/{workerEntry}', [WorkerEntryController::class, 'destroy'])->name('workerEntries.destroy');
    // workerEntries_Line_Entry
    Route::get('/workerEntries/{workerEntry}/workerEntries_Line_Entry', [WorkerEntryController::class, 'workerEntries_Line_Entry'])->name('workerEntries_Line_Entry');
    Route::put('/workerEntries/workerEntries_Line_Entry_store/{workerEntry}', [WorkerEntryController::class, 'workerEntries_Line_Entry_store'])->name('workerEntries_Line_Entry_store');
    
    //training development
    Route::get('/training_development', [WorkerEntryController::class, 'training_development'])->name('training_development');
    Route::post('/training_development', [WorkerEntryController::class, 'training_development_store'])->name('training_development_store');

    //disciplinary_problems
    Route::get('/disciplinary_problems', [WorkerEntryController::class, 'disciplinary_problems'])->name('disciplinary_problems');
    Route::post('/disciplinary_problems', [WorkerEntryController::class, 'disciplinary_problems_store'])->name('disciplinary_problems_store');

    //migrate_worker_lists

    Route::get('/migrate_worker_lists', [
        MigrateWorkerListController::class,
        'index'
    ])->name('migrate_worker_lists');
    Route::get('/migrate_worker_lists/create', [MigrateWorkerListController::class,
     'create'])->name('migrate_worker_lists.create');
    Route::post('/migrate_worker_lists', [MigrateWorkerListController::class, 'store'])->name('migrate_worker_lists.store');

    //empty_grade_list find and update
    Route::get('/empty_grade_list', [WorkerEntryController::class, 'empty_grade_list'])->name('empty_grade_list');


});


// all_data_download
Route::get('/all_data_download', [WorkerEntryController::class, 'all_data_download'])->name('all_data_download');
























Route::get('/read/{notification}', [NotificationController::class, 'read'])->name('notification.read');


require __DIR__ . '/auth.php';

//php artisan command

Route::get('/foo', function () {
    Artisan::call('storage:link');
});

Route::get('/cleareverything', function () {
    $clearcache = Artisan::call('cache:clear');
    echo "Cache cleared<br>";

    $clearview = Artisan::call('view:clear');
    echo "View cleared<br>";

    $clearconfig = Artisan::call('config:cache');
    echo "Config cleared<br>";
});

Route::get('/key =', function () {
    $key =  Artisan::call('key:generate');
    echo "key:generate<br>";
});

Route::get('/migrate', function () {
    $migrate = Artisan::call('migrate');
    echo "migration create<br>";
});

Route::get('/migrate-fresh', function () {
    $fresh = Artisan::call('migrate:fresh --seed');
    echo "migrate:fresh --seed create<br>";
});

Route::get('/optimize', function () {
    $optimize = Artisan::call('optimize:clear');
    echo "optimize cleared<br>";
});
Route::get('/route-clear', function () {
    $route_clear = Artisan::call('route:clear');
    echo "route cleared<br>";
});

Route::get('/route-cache', function () {
    $route_cache = Artisan::call('route:cache');
    echo "route cache<br>";
});

Route::get('/updateapp', function () {
    $dump_autoload = Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});
