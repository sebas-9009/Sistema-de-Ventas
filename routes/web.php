<?php

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

Route::group(['middleware' => ['guest']], function () {
     
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/','Auth\LoginController@showLoginForm')->name('/');

    Route::get('/register', 'Auth\LoginController@showLoginFormRegister')->name('register');
    Route::post('/registersave', 'Auth\LoginController@store')->name('registersave');

});


Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/home', 'HomeController@index');

  
    Route::group(['middleware' => ['Comprador']], function () {
         
        Route::resource('categoria', 'CategoriaController');
        Route::resource('producto', 'ProductoController');
        Route::get('/listarProductoPdf', 'ProductoController@listarPdf')->name('productos_pdf');
        Route::resource('proveedor', 'ProveedorController');
        Route::resource('compra', 'CompraController'); 
        Route::get('/pdfCompra/{id}', 'CompraController@pdf')->name('compra_pdf');
    
    });

    Route::group(['middleware' => ['Vendedor']], function () {

         Route::resource('categoria', 'CategoriaController');
         Route::resource('producto', 'ProductoController');
         Route::get('/listarProductoPdf', 'ProductoController@listarPdf')->name('productos_pdf');
         Route::resource('cliente', 'ClienteController');
         Route::resource('venta', 'VentaController');
         Route::get('/pdfVenta/{id}', 'VentaController@pdf')->name('venta_pdf');
    
         
    });

    Route::group(['middleware' => ['Cliente']], function () {

        Route::get('/listarProductoPdf', 'ProductoController@listarPdf')->name('productos_pdf');
        Route::resource('venta', 'VentaController');
        Route::get('/pdfVenta/{id}', 'VentaController@pdf')->name('venta_pdf');
   
        
   });

    Route::group(['middleware' => ['Administrador']], function () {
          
      Route::resource('categoria', 'CategoriaController');
      Route::resource('producto', 'ProductoController');
      Route::get('/listar', 'ProductoController@listar')->name('listar');
      Route::get('/carrito', 'ProductoController@carrito')->name('carrito');
      Route::get('/agregarcarrito/{id}', 'ProductoController@agregarCarrito');
      Route::get('/procesarpago', 'ProductoController@procesarpago')->names('procesarpago');
      Route::patch('update-cart', 'ProductoController@updateCart');
      Route::delete('remove-from-cart', 'ProductoController@removeCart');
      Route::get('/listarProductoPdf', 'ProductoController@listarPdf')->name('productos_pdf');
      Route::resource('proveedor', 'ProveedorController');
      Route::resource('compra', 'CompraController'); 
      Route::get('/pdfCompra/{id}', 'CompraController@pdf')->name('compra_pdf');
      Route::resource('venta', 'VentaController');
      Route::get('/pdfVenta/{id}', 'VentaController@pdf')->name('venta_pdf'); 
      Route::resource('cliente', 'ClienteController');
      Route::resource('rol', 'RolController');
      Route::resource('user', 'UserController');

	    
    
    });


});

