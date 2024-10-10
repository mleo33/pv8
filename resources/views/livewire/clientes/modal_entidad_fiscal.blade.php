<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlEntidadFiscal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ isset($entidadFiscal->id) ? "Editar Entidad Fiscal" : "Agregar Entidad Fiscal"}}</h4>
                <button type="button" wire:click.prevent="cancelEntidadFiscal()" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="entidadFiscal.razon_social">Razón Social</label>
                        <input style="text-transform: uppercase;" wire:model="entidadFiscal.razon_social" type="text" name="entidadFiscal.razon_social" class="form-control"/>
                        @error('entidadFiscal.razon_social') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <div class="form-group">
                                <label for="entidadFiscal.regimen_fiscal">Regimen Fiscal</label>
                                <select wire:model="entidadFiscal.regimen_fiscal" class="form-control"/>
                                    <option></option>
                                    <option value='601'>601-General de Ley Personas Morales</option>
                                    <option value='603'>603-Personas Morales con Fines no Lucrativos</option>
                                    <option value='605'>605-Sueldos y Salarios e Ingresos Asimilados a Salarios</option>
                                    <option value='606'>606-Arrendamiento</option>
                                    <option value='607'>607-Régimen de Enajenación o Adquisición de Bienes</option>
                                    <option value='608'>608-Demás ingresos</option>
                                    <option value='610'>610-Residentes en el Extranjero sin Establecimiento Permanente en México</option>
                                    <option value='611'>611-Ingresos por Dividendos (socios y accionistas)</option>
                                    <option value='612'>612-Personas Físicas con Actividades Empresariales y Profesionales</option>
                                    <option value='614'>614-Ingresos por intereses</option>
                                    <option value='615'>615-Régimen de los ingresos por obtención de premios</option>
                                    <option value='616'>616-Sin obligaciones fiscales</option>
                                    <option value='620'>620-Sociedades Cooperativas de Producción que optan por diferir sus ingresos</option>
                                    <option value='621'>621-Incorporación Fiscal</option>
                                    <option value='622'>622-Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras</option>
                                    <option value='623'>623-Opcional para Grupos de Sociedades</option>
                                    <option value='624'>624-Coordinados</option>
                                    <option value='625'>625-Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas</option>
                                    <option value='626'>626-Régimen Simplificado de Confianza</option>                                
                                </select>
                                @error('entidadFiscal.regimen_fiscal') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <div class="form-group">
                                <label for="entidadFiscal.calle">Calle</label>
                                <input style="text-transform: uppercase;" wire:model="entidadFiscal.calle" type="text" name="entidadFiscal.calle" class="form-control"/>
                                @error('entidadFiscal.calle') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
            
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="entidadFiscal.numero">Numero</label>
                                <input style="text-transform: uppercase;"  wire:model="entidadFiscal.numero" type="text" name="entidadFiscal.numero" class="form-control"/>
                                @error('entidadFiscal.numero') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="entidadFiscal.numero_int">Numero Interior</label>
                                <input style="text-transform: uppercase;" wire:model="entidadFiscal.numero_int" type="text" name="entidadFiscal.numero_int" class="form-control"/>
                                @error('entidadFiscal.numero_int') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
            
                        <div class="form-group col-md-8">
                            <div class="form-group">
                                <label for="entidadFiscal.colonia">Colonia</label>
                                <input style="text-transform: uppercase;" wire:model="entidadFiscal.colonia" type="text" name="entidadFiscal.colonia" class="form-control"/>
                                @error('entidadFiscal.colonia') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="entidadFiscal.cp">Código Postal</label>
                                <input wire:model="entidadFiscal.cp" type="number" name="entidadFiscal.cp" class="form-control" />
                                @error('entidadFiscal.cp') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
            
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="entidadFiscal.ciudad">Ciudad</label>
                                <input style="text-transform: uppercase;" wire:model="entidadFiscal.ciudad" type="text" name="entidadFiscal.ciudad" class="form-control"/>
                                @error('entidadFiscal.ciudad') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
            
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="entidadFiscal.estado">Estado</label>
                                <input style="text-transform: uppercase;" wire:model="entidadFiscal.estado" type="text" name="entidadFiscal.estado" class="form-control"/>
                                @error('entidadFiscal.estado') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="entidadFiscal.rfc">RFC</label>
                                <input style="text-transform: uppercase;" wire:model="entidadFiscal.rfc" type="text" name="entidadFiscal.rfc" class="form-control" />
                                @error('entidadFiscal.rfc') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
            
                        <div class="form-group col-md-7">
                            <div class="form-group">
                                <label for="entidadFiscal.correo">Correo Electrónico</label>
                                <input style="text-transform: lowercase;" wire:model="entidadFiscal.correo" type="email" name="entidadFiscal.correo" class="form-control" />
                                @error('entidadFiscal.correo') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label for="entidadFiscal.comentarios">Comentarios</label>
                        <textarea wire:model="entidadFiscal.comentarios" type="text" name="entidadFiscal.comentarios" class="form-control"></textarea>
                        @error('entidadFiscal.comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancelEntidadFiscal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($entidadFiscal->id)
                    <button type="button" wire:click.prevent="saveEntidadFiscal()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="saveEntidadFiscal()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>