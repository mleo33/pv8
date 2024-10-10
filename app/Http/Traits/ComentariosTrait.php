<?php


namespace App\Http\Traits;

use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;

trait ComentariosTrait {

    public Comentario $comentario;

    public function initComentario(){
        $this->comentario = new Comentario();
    }

    public function agregarComentario(){
        $this->validate(['comentario.mensaje' => 'string|min:10|max:255']);

        $this->comentario->tipo = 'NORMAL';
        $this->comentario->model_id = $this->model->id;
        $this->comentario->model_type = $this->modelClass;
        $this->comentario->usuario_id = Auth::user()->id;
        if($this->comentario->save()){
            $this->emit('ok', 'Se ha agregado comentario');
            $this->loadComentarios();
            $this->initComentario();
            $this->emit('closeModal');
        }
    }
}