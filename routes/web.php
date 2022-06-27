<?php

use App\Models\User;
use App\Modules\V1\Auth\Domain\Jobs\SendOtpNotification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
    return view('welcome');
});
// Route::get('/notification', function () {
//     // dd(request()->getPreferredLanguage());
//     $user = User::find(1);
//     $otp = Str::padLeft(mt_rand(0, 999999), 6, 0);
//     $url = config('app.reset_password_url') . Str::random();
//     return (new SendOtpNotification($otp))->toMail($user->email);
// });
