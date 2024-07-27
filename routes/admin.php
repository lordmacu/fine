<?php

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => config('admin.prefix'),
    'middleware' => ['auth', 'verified'],
    'as' => 'admin.',
], function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
    Route::resource('menu', 'MenuController')->except([
        'show',
    ]);
    Route::resource('menu.item', 'MenuItemController');
    Route::group([
        'prefix' => 'category',
        'as' => 'category.',
    ], function () {
        Route::resource('type', 'CategoryTypeController')->except([
            'show',
        ]);
        Route::resource('type.item', 'CategoryController');
    });
    Route::get('edit-account-info', 'UserController@accountInfo')->name('account.info');
    Route::post('edit-account-info', 'UserController@accountInfoStore')->name('account.info.store');
    Route::post('change-password', 'UserController@changePasswordStore')->name('account.password.store');

    Route::resource('client', App\Http\Controllers\Admin\ClientController::class);
    Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
    Route::get('client/{client}/observations', 'ClientObservationController@create')->name('client.observation.create');
    Route::post('client/{client}/observations', 'ClientObservationController@store')->name('clients.observations.store');
    Route::post('client/import', [ClientController::class, 'import'])->name('client.import');

    Route::resource('purchase_orders', PurchaseOrderController::class);

    Route::get('purchase_orders/getClientProducts/{clientId}', 'PurchaseOrderController@getClientProducts')->name('purchase_orders.getClientProducts');

});
