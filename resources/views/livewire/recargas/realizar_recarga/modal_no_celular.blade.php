<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlNoCelular">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Descripción</h5>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <center style="margin: 15px; padding:20px; border: solid 2px gray; border-radius: 12px; cursor: pointer;">
                                    <h4>{{$selectedProduct['Categoria']}} @money($selectedProduct['Monto'])</h4>
                                    <image style="height: 50px;" src="{{$selectedProvider['Logotipo']}}" />
                                    <label>{{$selectedProduct['Descripcion']}}</label>
                                </center>
                            </div>
                            <div class="form-group">
                                <label>Número Celular</label>
                                <input wire:model="numeroCelular" {{-- wire:keydown.enter="realizarRecarga" --}} style="text-align: center; font-size: 30px;" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control form-control-lg" />
                                @error('numeroCelular') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Confirmar Número</label>
                                <input wire:model="numeroCelular_confirmation" {{-- wire:keydown.enter="realizarRecarga" --}} style="text-align: center; font-size: 30px;" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control form-control-lg" />
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button wire:click="realizarRecarga()" type="button" class="btn btn-success"><i class="fas fa-check"></i> Aceptar</button>
            </div>
        </div>
    </div>
</div>