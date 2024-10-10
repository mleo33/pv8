<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlIO">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registrar {{ ($this->movimientoInventario->receptor_id && !$transferencia) ? 'Entrada' : ($transferencia ? 'Transferencia' : 'Salida')}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          @isset($movimientoInventario->emisor_id)
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="codigo">Transferencia</label>
                <label class="content-input">
                  <input type="checkbox" wire:change="cbTransferChange" wire:model="transferencia"/>
                  <i></i>
                </label>
              </div>

              @if($transferencia)
                <div class="form-group col-md-8">
                  <label for="codigo">Transferir a:</label>
                  <select class="form-control" wire:model='movimientoInventario.receptor_id'>
                    <option value=0>Seleccione...</option>
                    @foreach ($inventario->otras_sucursales() as $item)
                      <option value={{$item->id}}>{{$item->nombre}}</option>
                    @endforeach
                  </select>
                  @error('movimientoInventario.receptor_id') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
              @endif
            </div>
          @endisset

          <div class="form-row">
            <div class="form-group col-md-auto">
              <label for="movimientoInventario.cantidad">Cantidad a {{ ($this->movimientoInventario->receptor_id && !$transferencia) ? 'agregar' : ($transferencia ? 'transferir' : 'retirar') }}</label>
              <input wire:model="movimientoInventario.cantidad" style="text-align: center;" min="0" type="number" name="codigo" class="form-control" />
              @error('movimientoInventario.cantidad') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="codigo">Comentarios</label>
              <textarea wire:model="movimientoInventario.comentarios" class="form-control" col="2"></textarea>
              @error('movimientoInventario.comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
        <button type="button" wire:click="saveIO" class="btn btn-{{ ($this->movimientoInventario->receptor_id && !$transferencia) ? 'success' : ($transferencia ? 'warning' : 'danger') }}"><i class="fas fa-{{ ($this->movimientoInventario->receptor_id && !$transferencia) ? 'plus' : ($transferencia ? 'exchange-alt' : 'minus') }}"></i> Registrar {{ ($this->movimientoInventario->receptor_id && !$transferencia) ? 'Entrada' : ($transferencia ? 'Transferencia' : 'Salida') }}</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>