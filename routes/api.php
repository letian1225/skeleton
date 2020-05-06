<?php

use App\Http\Controllers\Admin\PaymentTestController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PlainContentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

LocaleController::apiRoutes();
ProfileController::apiRoutes();
DemoController::apiRoutes();
PlainContentController::apiRoutes();
// PaymentTestController::apiRoutes();
