<div class="pt-4">

  <div class="row justify-content-center">
    <div class="col-md-auto">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Corte de Caja</h3>
        </div>
        <div class="card-body p-0">

          <div class="row m-2">
            <div class="col-md-6">
              <label>Inicio</label>
              <input type="date" class="form-control" wire:model.lazy="startDate">
            </div>

            <div class="col-md-6">
              <label>Final:</label>
              <input type="date" class="form-control" wire:model.lazy="endDate">
            </div>
          </div>

          <div class="row m-2">
            <div class="col">
              <label>Sucursal</label>
              <select wire:model="sucursal_id" wire:change="$set('user_id', 0)" class="form-control">
                @foreach ($sucursales as $item)
                    <option value={{$item->id}}>{{$item->nombre}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row m-2">
            <div class="col">
              <label>Usuarios</label>
              <select wire:model="user_id" class="form-control">
                <option value=0>TODOS</option>
                @foreach ($usuarios_sucursal as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row m-2 mt-4">
            <div class="col">
              <button wire:click="generarCorte" class="btn btn-large btn-block btn-primary"><i class="fas fa-check-double"></i> Generar Corte</button>
              {{-- {{$this->i_rentas->where(['tipo' => 'ANTICIPO', 'forma_pago' => 'EFECTIVO'])->sum('monto')}} --}}
            </div>
          </div>
          
          
          <br>
          
        </div>
    </div>
    </div>
  </div>


</div>
