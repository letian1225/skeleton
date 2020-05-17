<?php

use Nikservik\Subscriptions\Controllers\AdminTariffController;
use Nikservik\Subscriptions\Controllers\AdminUserController;
use Nikservik\Subscriptions\Controllers\CloudPaymentsController;
use Nikservik\Subscriptions\Controllers\SubscriptionController;

AdminUserController::routes();
AdminTariffController::routes();

CloudPaymentsController::apiRoutes();
SubscriptionController::apiRoutes();
