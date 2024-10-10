<div class="card">
  <div class="card-header">
    <h2 class="card-title font-weight-bold"><i class="fas fa-file-alt"></i> Factura # @paddy($factura->id)</h2>
    <div class="card-tools">
      {{-- <button class="btn btn-sm btn-danger"><i class="fas fa-minus"></i> Remover factura</button> --}}
    </div>
  </div>
  <div class="row card-body">
    <div class="col">
      <h5><b>Fecha:</b> {{$factura->fecha_format}}</h5>
      <h5><b>Folio:</b> {{$factura->folio}}</h5>
      <h5><b>Razón Social:</b> {{$factura->entidad_fiscal->razon_social}}</h5>
      <h5><b>RFC:</b> {{$factura->entidad_fiscal->rfc}}</h5>
      @if ($factura->model_type == 'App\\Models\\Venta')
        <button class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Venta #@paddy($factura->model_id)</button>
      @endif
    </div>
    <div class="col">
      <h5><b>Serie:</b> {{$factura->serie}}</h5>
      <h5><b>UUID:</b> {{$factura->uuid}}</h5>
      <h5><b>Sub Total:</b> @money($factura->subtotal)</h5>
      <h5><b>Total:</b> @money($factura->total)</h5>
    </div>
    
  </div>
</div>