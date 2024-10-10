<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Marca extends BaseModel
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'marcas';

    protected $fillable = ['nombre'];

    public function setNombreAttribute($value){
        $this->attributes['nombre'] = strtoupper($value);
    }
	
}
