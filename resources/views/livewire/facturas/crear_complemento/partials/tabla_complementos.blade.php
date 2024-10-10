<div class="card">
  <div class="card-header">
    <h2 class="card-title font-weight-bold"><i class="fas fa-file-alt"></i> Complementos de Pago</h2>
    <div class="card-tools">
      <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mdl"><i class="fas fa-plus"></i> Generar Complemento</button>
    </div>
  </div>
  <div class="card-body p-0" style="min-height: 50vh">
    <table class="table table-hover">
      <thead>
        <tr>
          <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Folio</th>
            <th>Usuario</th>
            <th>Estatus</th>
            <th>Monto</th>
            <th>Opciones</th>
            <th>Cancelar</th>
          </tr>
        </tr>
      </thead>
      <tbody>
        @foreach ($this->factura->complementos as $elem)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $elem->fecha_format() }}</td>
            <td>{{ $elem->serie }}{{ $elem->folio }}</td>
            <td>{{ $elem->usuario->name }}</td>
            <td>{{ $elem->estatus }}</td>
            <td>{{ $elem->monto }}</td>
            <td>
              <a class="btn btn-xs btn-primary" href="/complementos/ver_pdf/{{$elem->id}}" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a>
              <a class="btn btn-xs btn-primary" href="/complementos/xml/{{$elem->id}}" target="_blank"><i class="fas fa-code"></i> XML</a>
              <button class="btn btn-xs btn-warning" wire:click="mdlEnviarComplemento({{$elem->id}})"><i class="fas fa-envelope"></i> Enviar</button>
            </td>
            <td>
              <button wire:click="$emit('initMdlCancelarFactura', {{$elem->id}}, 'Pago')" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>


  </div>
</div>