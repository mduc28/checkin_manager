<?php

use App\Http\Controllers\CheckInController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
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

Route::group([
    'middleware' => 'log.out'
], function (){
    //Login
    Route::get('login', [LoginController::class, 'index'])->name('login.index');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::group(['middleware' => 'force.password'], function (){
        Route::get('change-password-first', [LoginController::class, 'changePassFirstForm'])->name('change.pass.first.index');
        Route::post('change-password-first', [LoginController::class, 'changePassFirst'])->name('change.pass.first');
    });
   
    Route::group([
        'middleware' => 'check.auth',
    ], function (){
        //Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:admin');

        //Account
        

        //Member
        Route::resource('members', MemberController::class)->except(['update', 'destroy', 'edit', 'show']);
        Route::delete('members/delete', [MemberController::class, 'destroy'])->name('members.destroy');
        Route::put('members/update', [MemberController::class, 'update'])->name('members.update');
        Route::get('members/printf', [MemberController::class, 'print'])->name('members.print');
        Route::get('members/pdf/{id}', [MemberController::class, 'pdf'])->name('members.pdf');
        Route::get('members/edit/{id}', [MemberController::class, 'edit'])->name('members.edit');
        Route::get('members/export', [MemberController::class, 'export'])->name('members.export');
        Route::get('members/restore', [MemberController::class, 'restoreList'])->name('members.restore.index');
        Route::post('members/restore', [MemberController::class, 'restore'])->name('members.restore');

        Route::group([
            'middleware' => 'role:admin'
        ], function (){
            //User
            Route::resource('users', UserController::class)->except(['update', 'destroy', 'show']);
            Route::put('users/update', [UserController::class, 'update'])->name('users.update');
            Route::delete('users/delete', [UserController::class, 'destroy'])->name('users.destroy');
            Route::get('users/change-password', [UserController::class, 'changePasswordForm'])->name('users.change.password.index');
            Route::post('users/change-password', [UserController::class, 'changePassword'])->name('change.password');
        });

        //Check-In
        Route::resource('check_in', CheckInController::class)->except(['show', 'edit', 'update', 'destroy', 'index']);
        Route::get('check_in', [CheckInController::class, 'index'])->name('check_in.index')->middleware('role:admin');
        Route::post('check_in/member', [CheckInController::class, 'memberCheck'])->name('check_in.member');
        Route::post('check_in/guest', [CheckInController::class, 'guestStore'])->name('check_in.guest');
        Route::get('check_in/export', [CheckInController::class, 'export'])->name('check_in.export');
    });
});

