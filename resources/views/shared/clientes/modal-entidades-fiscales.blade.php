<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlEntidadesFiscales">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Entidades Fiscales: {{$cliente->nombre ?? ''}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Razón Social</th>
                  <th>RFC</th>
                  <th>Dirección</th>
                  <th>Correo</th>
                  <th>Comentarios</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($cliente->entidades_fiscales ?? array() as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->razon_social }}</td>
                    <td>{{ $item->rfc }}</td>
                    <td>{{ $item->direccion }}</td>
                    <td>{{ $item->correo }}</td>
                    <td>{{ $item->comentarios }}</td>
                    <td>
                      <button wire:click="setEntidadFiscal({{ $item->id }})" class="btn btn-sm btn-secondary"><i class="fa fa-university"></i> Seleccionar</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
  