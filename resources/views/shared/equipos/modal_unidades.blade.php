<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlUnidades">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $this->registro_t->model->fua }}</h5>    
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="registro_t.unidades">{{$this->registro_t->model->descripcion}}</label>
                        <center>
                            <input wire:model="registro_t.unidades" style="text-align: center; width: 40%" min="1" type="number" class="form-control" />
                        </center>
                        @error('registro_t.unidades') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click="setUnidades" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>