<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\WebHomeController;
use App\Http\Controllers\API\WebCityController;
use App\Http\Controllers\API\WebCategoryController;
use App\Http\Controllers\API\WebCartController;

use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\API\AdminCompanyController;
use App\Http\Controllers\API\AdminProductCategoryController;
use App\Http\Controllers\API\AdminProductController;
use App\Http\Controllers\API\AdminUserController;

use App\Http\Controllers\API\AdminSettingCategoryController;
use App\Http\Controllers\API\AdminSettingCityController;
use App\Http\Controllers\API\AdminSettingStatusController;
use App\Http\Controllers\API\AdminSettingRoleController;



    Route::prefix('web')->middleware('cors')->group(function () {

        Route::prefix('home')->group(function () {
            Route::get('/category-list', [WebHomeController::class, 'categoryList']);
            Route::get('/city-list', [WebHomeController::class, 'cityList']);
            Route::get('/company-list', [WebHomeController::class, 'companyList']);
        });

        Route::get('/search', [WebHomeController::class, 'search']);

        Route::get('/filter/{city_slug}/{category_slug}', [WebHomeController::class, 'filter']);
        Route::get('/company/{company_slug}', [WebHomeController::class, 'companyShow']);
        Route::get('/category/{category_slug}', [WebCategoryController::class, 'show']);

        // Public products list for frontend home page
        Route::get('/product-list', [WebHomeController::class, 'productList']);

        // Cart endpoints (token-based)
        Route::post('/cart/init', [WebCartController::class, 'init']);
        Route::get('/cart/{token}', [WebCartController::class, 'get']);
        Route::post('/cart/add', [WebCartController::class, 'add']);
        Route::post('/cart/update', [WebCartController::class, 'update']);
        Route::post('/cart/remove', [WebCartController::class, 'remove']);
        Route::post('/cart/clear', [WebCartController::class, 'clear']);


    });

    Route::controller(AuthController::class)->group(function(){
        Route::post('register', 'register');
        Route::post('login', 'login');
    });

    Route::middleware('auth:sanctum')->group( function () {

        Route::prefix('app')->group(function () {

            Route::prefix('admin')->group(function () {

                Route::prefix('company')->group(function () {
                    Route::get('/list', [AdminCompanyController::class, 'list']);
                    Route::post('/create', [AdminCompanyController::class, 'create']);
                    Route::get('/{id}/show',  [AdminCompanyController::class, 'show']);
                    Route::post('/{id}/update',  [AdminCompanyController::class, 'update']);
                    Route::post('/sort-update',  [AdminCompanyController::class, 'sortUpdate']);
                    Route::get('/{id}/delete',  [AdminCompanyController::class, 'delete']);

                    Route::prefix('product-category')->group(function () {
                        Route::get('/{id}/list', [AdminProductCategoryController::class, 'list']);
                        Route::post('/create', [AdminProductCategoryController::class, 'create']);
                        Route::get('/{id}/show',  [AdminProductCategoryController::class, 'show']);
                        Route::post('/{id}/update',  [AdminProductCategoryController::class, 'update']);
                        Route::post('/sort-update',  [AdminProductCategoryController::class, 'sortUpdate']);
                        Route::get('/{id}/delete',  [AdminProductCategoryController::class, 'delete']);
                    });

                    Route::prefix('product')->group(function () {
                        Route::get('{id}/list', [AdminProductController::class, 'list']);
                        Route::post('/create', [AdminProductController::class, 'create']);
                        Route::get('/{id}/show',  [AdminProductController::class, 'show']);
                        Route::post('/{id}/update',  [AdminProductController::class, 'update']);
                        Route::get('/{id}/delete',  [AdminProductController::class, 'delete']);
                    });
                });



                Route::prefix('user')->group(function () {
                    Route::get('/list', [AdminUserController::class, 'list']);
                    Route::get('/{id}/show',  [AdminUserController::class, 'show']);
                    Route::post('/{id}/update',  [AdminUserController::class, 'update']);
                });

                Route::prefix('setting')->group(function () {

                    Route::prefix('category')->group(function () {
                        Route::get('/list', [AdminSettingCategoryController::class, 'list']);
                        Route::post('/create', [AdminSettingCategoryController::class, 'create']);
                        Route::get('/{id}/show',  [AdminSettingCategoryController::class, 'show']);
                        Route::post('/{id}/update',  [AdminSettingCategoryController::class, 'update']);
                        Route::post('/sort-update',  [AdminSettingCategoryController::class, 'sortUpdate']);
                        Route::get('/{id}/delete',  [AdminSettingCategoryController::class, 'delete']);
                    });

                    Route::prefix('city')->group(function () {
                        Route::get('/list', [AdminSettingCityController::class, 'list']);
                        Route::post('/create', [AdminSettingCityController::class, 'create']);
                        Route::get('/{id}/show',  [AdminSettingCityController::class, 'show']);
                        Route::post('/{id}/update',  [AdminSettingCityController::class, 'update']);
                        Route::get('/{id}/delete',  [AdminSettingCityController::class, 'delete']);
                    });

                    Route::prefix('role')->group(function () {
                        Route::get('/list', [AdminSettingRoleController::class, 'list']);
                        Route::post('/create', [AdminSettingRoleController::class, 'create']);
                        Route::get('/{id}/show',  [AdminSettingRoleController::class, 'show']);
                        Route::post('/{id}/update',  [AdminSettingRoleController::class, 'update']);
                        Route::get('/{id}/delete',  [AdminSettingRoleController::class, 'delete']);
                    });

                    Route::prefix('status')->group(function () {
                        Route::get('/list', [AdminSettingStatusController::class, 'list']);
                        Route::post('/create', [AdminSettingStatusController::class, 'create']);
                        Route::get('/{id}/show',  [AdminSettingStatusController::class, 'show']);
                        Route::post('/{id}/update',  [AdminSettingStatusController::class, 'update']);
                        Route::get('/{id}/delete',  [AdminSettingStatusController::class, 'delete']);
                    });

                });

            });

        });

    });


