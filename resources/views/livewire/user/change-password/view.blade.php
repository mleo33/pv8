<div class="pt-4">

    <div class="row justify-content-center">
        <div class="card" style="width: 350px;">
            <div class="card-header">
              <h3 class="card-title">Cambiar Contraseña</h3>
              <div class="card-tools">
                <a href="/" class="btn btn-tool">
                  <i class="fas fa-times"></i>
                </a>
              </div>
            </div>
            <div class="card-body">
                <center>
                    <label>Usuario: {{$this->user->name ?? 'N/A'}}</label>
                    <br>
                    <br>
                    <div class="form-group">
                        <p>Contraseña Anterior:</p>
                        <input wire:model.defer="password_old" type="password" style="text-align: center" class="form-control">
                        @error('password_old')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="form-group">
                        <p>Nueva Contraseña:</p>
                        <input wire:model.defer="password" type="password" style="text-align: center" class="form-control">
                        @error('password')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="form-group">
                        <p>Confirmar Contraseña:</p>
                        <input wire:model.defer="password_confirmation" type="password" style="text-align: center" class="form-control">
                        @error('password_confirmation')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            {{-- <a href="/inicio" class="btn btn-md btn-primary"><i class="fa fa-check"></i> Cancelar</a> --}}
                            <button wire:click="changePassword" class="btn btn-md btn-primary"><i class="fa fa-key"></i> Cambiar Contraseña</button>
                        </div>
                    </div>

                </center>


            </div>
        </div>
    </div>
  
  
</div>
  