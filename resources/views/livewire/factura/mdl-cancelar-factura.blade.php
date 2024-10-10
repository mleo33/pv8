<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cancelar Factura</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <center>
                        <h3>Factura: {{$this->factura->no_factura}}</h3>
                        <h3>Monto: @money($this->factura->total)</h3>
                        <div style="width: 50%" class="form-group">
                            <h4>Motivo de Cancelación</h4>
                            <select wire:model="tipoCancelacion" class="form-control">
                                <option></option>
                                @foreach ($this->tipos_cancelacion as $key => $item)
                                    <option value="{{$key}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </center>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    @if ($this->tipoCancelacion == '1')

                    @if ($this->selectedFactura)
                        <h3 style="color: green;">Documento Relacionado</h3>
                        <h4>Folio: {{$this->selectedFactura->no_factura}}</h4>
                        <h4>RFC Receptor: {{$this->selectedFactura->entidad_fiscal->rfc}}</h4>
                        <h4>UUID: {{$this->selectedFactura->uuid}}</h4>
                        <h4>Total: @money($this->selectedFactura->total)</h4>
                        <button wire:click="setFacturaSustitution(0)" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i> Quitar Factura</button>
                    @else
                        <h5>Seleccione Factura</h5>
                        <label>Buscar</label>
                        <input type="text" wire:model.lazy="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Razón Social</th>
                                    <th>RFC Receptor</th>
                                    <th>UUID</th>
                                    <th>Total</th>
                                    <th>Selecc.</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($facturas as $item)
                                @if ($item->id != $this->factura->id)                                
                                <tr>
                                    <td>{{$item->no_factura}}</td>
                                    <td>{{$item->entidad_fiscal->razon_social}}</td>
                                    <td>{{$item->entidad_fiscal->rfc}}</td>
                                    <td>{{$item->uuid}}</td>
                                    <td>@money($item->total)</td>
                                    <td>
                                        <button wire:click="setFacturaSustitution('{{$item->id}}')" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Seleccionar</button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        {{$facturas->links()}}
                    @endif

                    @endif
                </div>
            </div>

            
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          @if($this->showCancelarButton())
          <div wire:loading wire:target="cancelarFactura">
            <button disabled type="button" class="btn btn-info" wire:click="cancelarFactura"><i class="fas fa-spin fa-spinner"></i> Cancelando CFDI</button>
          </div>
          <div wire:loading.remove wire:target="cancelarFactura">
              <button type="button" class="btn btn-danger" wire:click="cancelarFactura"><i class="fas fa-window-close"></i> Cancelar Factura</button>
          </div>
          @endif
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>