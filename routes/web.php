<?php

use Illuminate\Support\Facades\Route;



Route::view('/', 'welcome');

Route::get('/login', function () {
    redirect('/dashbord');
});



require __DIR__.'/auth.php';
