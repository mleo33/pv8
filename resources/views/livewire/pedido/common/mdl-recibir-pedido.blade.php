<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Recibir Pedido #{{$pedido?->id_paddy}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">        
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                    <th>Cant. Solicitada</th>
                    <th>Cant. Recibida</th>
                    <th>Recibir</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pedido->conceptos ?? [] as $item)
                    <tr>
                      <td>{{ $item->codigo }}</td>
                      <td>{{ $item->descripcion }}</td>
                      <td>{{ $item->cantidad }}</td>
                      <td>@money($item->precio)</td>
                      <td>@money($item->importe)</td>
                      <td>{{ $item->cantidad }}</td>
                      <td>{{ $item->cantidad_recibida }}</td>
                      <td style="width: 100px;">
                        @if ($item->cantidad == $item->cantidad_recibida)
                          RECIBIDO
                        @else
                          <input wire:model='productQty.{{$item->id}}.recibir' style="text-align: center;" type="text" class="form-control" onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                          <span class="error text-danger">{{$this->errorMessage($item->id)}}</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
  
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>

            @if(!$this->isError() && collect($this->productQty)->sum('recibir') > 0)
              <button wire:click="$emit('confirm', '¿Desea continuar?', 'Recibir Pedido', 'recibir')" type="button" class="btn btn-success" ><i class="fas fa-check"></i> Recibir</button>
            @endif
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>