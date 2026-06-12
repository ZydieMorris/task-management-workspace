<?php
use App\Http\Controllers\admin\DashboardAdminController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\PositionController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\TaskController;
use App\Http\Controllers\manager\DashboardManagerController;
use App\Http\Controllers\member\DashboardMemberController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'auth/Login')->name('home');

Route::middleware(['auth', 'verified'])->get('/redirect', function(){
        $role = auth()->user()->role;

        if($role === 'admin'){
            return redirect('/admin/dashboard');
        } elseif($role === 'manager'){
            return redirect('/manager/dashboard');
        } elseif ($role === 'member'){
            return redirect('/member/dashboard');
        } else {
            abort(403);
        }
})->name('dashboard');

Route::prefix('admin')->middleware(['auth', 'admin', 'verified'])->group(function () {
    Route::resource('dashboard', DashboardAdminController::class);
    Route::resource('users', UserController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('projects.tasks', TaskController::class);
    Route::get('projects/{project}/members', [ProjectController::class, 'members'])->name('projects.members');


});

Route::prefix('manager')->middleware(['auth', 'manager' , 'verified'])->group(function () {
 Route::resource('dashboard', DashboardManagerController::class);
});

Route::prefix('member')->middleware(['auth', 'member' , 'verified'])->group(function () {
 Route::resource('dashboard', DashboardMemberController::class);
});



require __DIR__.'/settings.php';
