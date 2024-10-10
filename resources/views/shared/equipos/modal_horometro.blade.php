<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlHorometro">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $this->registro_t->model->descripcion }}</h5>    
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="direccion">Horómetro</label>
                        <input wire:model="registro_t.horometro_inicio" style="text-align: center;" type="number" class="form-control" />
                        @error('registro_t.horometro_inicio') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click="setHorometro" class="btn btn-primary"><i class="fas fa-tachometer-alt"></i> Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>