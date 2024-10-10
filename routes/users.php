<?php

// use App\Models\User;
use Illuminate\Support\Facades\Route;


// Route::middleware(['auth'])->prefix('usuarios')->group(function () 
// {

//     Route::middleware(['permission:administrar-usuarios'])
//     ->get('/', function(){
//         return view('livewire.user.catalogo-users.index');
//     });

//     Route::middleware(['permission:administrar-permisos'])
//     ->get('/roles-permisos', function(){
//         return view('livewire.user.roles.admin');
//     });
    
//     Route::middleware(['permission:administrar-usuarios'])
//     ->get('/{user}', function(User $user){
//         return view('livewire.user.edit-user.index', compact('user'));
//     });
// });

Route::middleware(['auth'])->prefix('users')->group(function () {
    
    Route::get('/change-password', function(){
        return view('livewire.user.change-password.index');
    });

});
