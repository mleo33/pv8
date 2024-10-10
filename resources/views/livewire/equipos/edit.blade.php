@section('title', __('Equipos'))
<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h2 class="card-title">{{ isset($this->equipo->id) ? $this->equipo->fua : 'Registrar Nuevo Equipo' }}</h2>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        
        <div class="card-body">

          <div class="form-row">
            <div class="form-group col">
              <label for="equipo.familia_id">Familia</label>
              <select class="form-control" wire:model="equipo.familia_id">
                <option value=0>Seleccione Familia....</option>
                  @foreach ($familias as $item)
                  <option value={{$item->id}}>{{$item->nombre}}</option>
                  @endforeach
              </select>
              @error('equipo.familia_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.serie">Modelo</label>
              <input wire:model="equipo.modelo" style="text-transform: uppercase;" type="text" name="equipo.modelo" class="form-control" />
              @error('equipo.modelo') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.serie">Serie</label>
              <input wire:model="equipo.serie" style="text-transform: uppercase;" type="text" name="equipo.serie" class="form-control" />
              @error('equipo.serie') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.year">Año</label>
              <input wire:model="equipo.year" style="text-align: right;" type="number" min="0" name="equipo.year" class="form-control" />
              @error('equipo.year') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-2">
              <label for="equipo.cantidad">Cantidad</label>
              <input wire:model="equipo.cantidad" style="text-align: center;" type="number" min="1" name="equipo.cantidad" class="form-control" />
              @error('equipo.cantidad') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.descripcion">Descripción</label>
              <input wire:model="equipo.descripcion" style="text-transform: uppercase;" type="text" name="equipo.descripcion" class="form-control" />
              @error('equipo.descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-3">
              <label for="equipo.origen">Origen</label>
              <select class="form-control" wire:model="equipo.origen">
                <option></option>
                <option value="NACIONAL">NACIONAL</option>
                <option value="IMPORTADO">IMPORTADO</option>
              </select>
              @error('equipo.origen') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

          </div>

          <div class="form-row">
            <div class="form-group col-md-2">
              <label for="equipo.factura">Factura</label>
              <input wire:model="equipo.factura" style="text-transform: uppercase;" type="text" name="equipo.factura" class="form-control" />
              @error('equipo.factura') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-2">
              <label for="equipo.pedimento">Pedimento</label>
              <input wire:model="equipo.pedimento" style="text-transform: uppercase;" type="text" name="equipo.pedimento" class="form-control" />
              @error('equipo.pedimento') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-3">
              <label for="equipo.fecha_adquisicion">Fecha de adquisición</label>
              <input wire:model="equipo.fecha_adquisicion" style="text-transform: uppercase;" type="date" name="equipo.fecha_adquisicion" class="form-control" />
              @error('equipo.fecha_adquisicion') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.horometro">Horómetro (0 = N/A)</label>
              <input wire:model="equipo.horometro" type="number" min="0" name="equipo.horometro" class="form-control" />
              @error('equipo.horometro') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-2">
              <label for="equipo.placas">Placas</label>
              <input wire:model="equipo.placas" style="text-transform: uppercase;" type="text" name="equipo.placas" class="form-control" />
              @error('equipo.placas') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-2">
              <label for="equipo.moneda">Moneda</label>
              <select class="form-control" wire:model="equipo.moneda">
                <option></option>
                <option value="MXN">MXN</option>
                <option value="USD">USD</option>
              </select>
              @error('equipo.moneda') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-2">
              <label for="equipo.cotizacion_usd">Cotización USD</label>
              <input wire:model="equipo.cotizacion_usd" style="text-align: right;" type="number" min="0" name="equipo.cotizacion_usd" class="form-control" />
              @error('equipo.cotizacion_usd') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-3">
              <label for="equipo.valor_compra">Valor de Compra</label>
              <input wire:model="equipo.valor_compra" style="text-align: right;" type="number" min="0" name="equipo.valor_compra" class="form-control" />
              @error('equipo.valor_compra') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.valor_traslado">Valor de Traslado</label>
              <input wire:model="equipo.valor_traslado" style="text-align: right;" type="number" min="0" name="equipo.valor_traslado" class="form-control" />
              @error('equipo.valor_traslado') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-2">
              <label for="equipo.valor_importacion">Valor de Importación</label>
              <input wire:model="equipo.valor_importacion" style="text-align: right;" type="number" min="0" name="equipo.valor_importacion" class="form-control" />
              @error('equipo.valor_importacion') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col">
              <label for="equipo.renta_hora">Renta x Hora</label>
              <input wire:model="equipo.renta_hora" style="text-align: right;" type="number" min="0" name="equipo.renta_hora" class="form-control" />
              @error('equipo.renta_hora') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.renta_dia">Renta x Día</label>
              <input wire:model="equipo.renta_dia" style="text-align: right;" type="number" min="0" name="equipo.renta_dia" class="form-control" />
              @error('equipo.renta_dia') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.renta_semana">Renta x Semana</label>
              <input wire:model="equipo.renta_semana" style="text-align: right;" type="number" min="0" name="equipo.renta_semana" class="form-control" />
              @error('equipo.renta_semana') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.renta_mes">Renta x Mes</label>
              <input wire:model="equipo.renta_mes" style="text-align: right;" type="number" min="0" name="equipo.renta_mes" class="form-control" />
              @error('equipo.renta_mes') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-5">
              <label for="equipo.v">Clave Producto</label>
              <select class="form-control" wire:model="equipo.clave_producto_id">
                <option></option>
                @foreach ($clave_productos as $item)
                  <option value="{{$item->id}}">{{$item->clave}} - {{$item->nombre}}</option>
                @endforeach
              </select>
              @error('equipo.clave_producto_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-5">
              <label for="equipo.clave_unidad_id">Clave Unidad</label>
              <select class="form-control" wire:model="equipo.clave_unidad_id">
                <option></option>
                @foreach ($clave_unidades as $item)
                  <option value="{{$item->id}}">{{$item->clave}} - {{$item->nombre}}</option>
                @endforeach
              </select>
              @error('equipo.clave_unidad_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            
          </div>

          <div class="form-row">
            <div class="form-group col">
              <label for="equipo.comentarios">Comentarios</label>
              <textarea wire:model="equipo.comentarios" name="equipo.comentarios" class="form-control"></textarea>
              @error('equipo.comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-3">
              <label for="equipo.propietario">Propietario</label>
              <select class="form-control" wire:model="equipo.propietario">
                <option></option>
                <option value="DM">DM</option>
                <option value="G3">G3</option>
              </select>
              @error('equipo.propietario') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col">
              <label for="equipo.activo">Equipo Activo</label>
              <label class="content-input">
                <input type="checkbox" wire:model="equipo.activo"/>
                <i></i>
              </label>
            </div>
          </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer justify-content-between">
          <button class="btn btn-secondary" wire:click="cancel()"><i class="fas fa-times"></i> Cancelar</button>
          <button class="btn btn-{{ isset($equipo->id) ? 'primary' : 'success'}}" wire:click="saveEquipo()"><i class="fas fa-{{ isset($equipo->id) ? 'save' : 'plus'}}"></i> {{ isset($equipo->id) ? 'Guardar' : 'Registrar'}} Equipo</button>
        </div>

    </div>

</div>