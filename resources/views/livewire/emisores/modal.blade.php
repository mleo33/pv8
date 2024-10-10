<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $emisor->id ? "Editar" : "Agregar"}} Emisor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-7">
                            <div class="form-group">
                                <label for="emisor.nombre">Nombre</label>
                                <input wire:model.defer="emisor.nombre" maxlength="255" style="text-transform: uppercase;" type="text" class="form-control" />
                                @error('emisor.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="emisor.rfc">RFC</label>
                                <input wire:model.defer="emisor.rfc" style="text-transform: uppercase;" maxlength="15" type="text" class="form-control" />
                                @error('emisor.rfc') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label for="emisor.lugar_expedicion">Lugar de Expedición</label>
                                <input wire:model.defer="emisor.lugar_expedicion" maxlength="15" type="number" class="form-control" />
                                @error('emisor.lugar_expedicion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <div class="form-group">
                                <label for="emisor.regimen_fiscal">Régimen Fiscal</label>
                                <select wire:model.defer="emisor.regimen_fiscal" class="form-control">
                                    <option value=""></option>
                                    @foreach ($regimenes_fiscales as $key => $value)
                                        <option value="{{$key}}">{{$key . '-' . $value}}</option>
                                    @endforeach
                                </select>
                                @error('emisor.regimen_fiscal') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label>Serie Facturas</label>
                                <input wire:model.defer="emisor.serie" maxlength="6" style="text-transform: uppercase; text-align: center;" type="text" class="form-control" />
                                @error('emisor.serie') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Consecutivo</label>
                                <input wire:model.defer="emisor.folio_facturas" style="text-transform: uppercase; text-align: center;" type="number" class="form-control" />
                                @error('emisor.folio_facturas') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Serie Complementos</label>
                                <input wire:model.defer="emisor.serie_complementos" maxlength="6" style="text-transform: uppercase; text-align: center;" type="text" class="form-control" />
                                @error('emisor.serie_complementos') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Consecutivo</label>
                                <input wire:model.defer="emisor.folio_complementos" style="text-transform: uppercase; text-align: center;" type="number" class="form-control" />
                                @error('emisor.folio_complementos') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-7">
                            <div class="form-group">
                                <label for="emisor.no_certificado">No. Certificado</label>
                                <input wire:model.defer="emisor.no_certificado" maxlength="50" style="text-transform: uppercase;" type="text" class="form-control" />
                                @error('emisor.no_certificado') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="emisor.clave_certificado">Clave Certificado</label>
                                <input wire:model.defer="emisor.clave_certificado" maxlength="50" type="password" class="form-control" />
                                @error('emisor.clave_certificado') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="emisor.fd_user">FD Usuario</label>
                                <input wire:model.defer="emisor.fd_user" maxlength="50" type="text" class="form-control" />
                                @error('emisor.fd_user') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="emisor.fd_pass">FD Password</label>
                                <input wire:model.defer="emisor.fd_pass" maxlength="50" type="password" class="form-control" />
                                @error('emisor.fd_pass') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($emisor->id)
                    <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>