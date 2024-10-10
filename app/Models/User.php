<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $attributes = [
        'sucursal_default' => 1,
     ];

    public static function boot()
    {
        parent::boot();

        // self::creating(function($model){
        //     // ... code here
        // });

        self::created(function($model){
            if(Sucursal::all()->count() == 0){
                $sucursal = new Sucursal();
                $sucursal->nombre = 'DELICIAS';
                $sucursal->direccion = '';
                $sucursal->telefono = '(123)456-78-90';
                $sucursal->comentarios = 'Sucursal principal';
                $sucursal->save();
            }
            $model->sucursales()->sync([1]);
            $model->assignRole('gerente');
        });

        // self::updating(function($model){
        //     // ... code here
        // });

        // self::updated(function($model){
        //     // ... code here
        // });

        // self::deleting(function($model){
        //     // ... code here
        // });

        // self::deleted(function($model){
        //     // ... code here
        // });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class, 'sucursal_default');
    }

    public function sucursales(){
        return $this->belongsToMany(Sucursal::class);
    }

}
