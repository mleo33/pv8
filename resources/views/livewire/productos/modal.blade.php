<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{ (isset($producto->id)) ? 'Editar Producto' : 'Agregar Producto' }}</h4>
        <button type="button" wire:click="cancel" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="codigo">Código</label>
              <input wire:model.defer="producto.codigo" style="text-transform: uppercase;" type="text" name="codigo"
                class="form-control" />
              @error('producto.codigo') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-6">
              <button type="button" wire:click="mdlMarca" class="btn btn-default btn-xs"><i class="fa fa-plus"></i></button> <label for="marca">Marca</label>
              <div wire:ignore>
                <select class="form-control select2-single" wire:model.defer="producto.marca" id="select_marca" style="width: 100%;">
                  <option value=''></option>
                  @foreach ($catalogo_marcas as $elem)
                    <option value="{{ $elem->nombre }}">{{ $elem->nombre }}</option>
                  @endforeach
                </select>
              </div>
              @error('producto.marca') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-9">
              <label for="descripcion">Descripción</label>
              <input wire:model.defer="producto.descripcion" style="text-transform: uppercase;" type="text" name="descripcion"
                class="form-control" />
              @error('producto.descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-3">
              <label for="unidad">Unidad</label>
              <input wire:model.defer="producto.unidad" style="text-transform: uppercase;" type="text" name="unidad"
                class="form-control" />
              @error('producto.unidad') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <button type="button" wire:click="mdlClaveProducto" class="btn btn-default btn-xs"><i class="fa fa-plus"></i></button> <label for="producto.clave_producto_id">Clave de Producto</label>
              <select class="form-control" wire:model.defer="producto.clave_producto_id">
                <option></option>
                @foreach ($clave_productos as $item)
                  <option value="{{$item->id}}">{{$item->clave}} - {{$item->nombre}}</option>
                @endforeach
              </select>
              @error('producto.clave_producto_id') <span class="error text-danger">{{ $message }}</span> @enderror
              
            </div>
            <div class="form-group col-md-6">
              <button type="button" wire:click="mdlClaveUnidad" class="btn btn-default btn-xs"><i class="fa fa-plus"></i></button> <label for="producto.clave_unidad_id">Clave de Unidad</label>
              <select class="form-control" wire:model.defer="producto.clave_unidad_id">
                <option></option>
                @foreach ($clave_unidades as $item)
                  <option value="{{$item->id}}">{{$item->clave}} - {{$item->nombre}}</option>
                @endforeach
              </select>
              @error('producto.clave_unidad_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-5">
              <label for="categorias">Categorias</label><br>
              <div wire:ignore>
                <select {{-- wire:model.defer="categorias" --}} class="form-control select2-multiple" style="width: 100%"
                  multiple="multiple" id="select_categorias">
                  @foreach ($catalogo_categorias as $categoria)
                    <option value="{{ $categoria->nombre }}">{{ $categoria->nombre }}</option>
                  @endforeach
                </select>
                @error('producto.categorias') <span class="error text-danger">{{ $message }}</span> @enderror
              </div>
            </div>


            @if (!isset($producto->id))                
              <div class="form-group col-md-7">
                
                <div class="row">
                  <div class="col">
                    <br>
                    <h4>Sucursal: {{$sucursalActual}}</h4>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <label for="productCosto">Costo</label>
                    <input wire:model.defer="productCosto" onkeypress="return event.charCode >= 46 && event.charCode <= 57" name="productCosto" class="form-control" />
                    @error('productCosto') <span class="error text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col">
                    <label for="productPrecio">Precio</label>
                    <input wire:model.defer="productPrecio" onkeypress="return event.charCode >= 46 && event.charCode <= 57" name="productPrecio" class="form-control" />
                    @error('productPrecio') <span class="error text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col">
                    <label for="productMinimo">Mínimo</label>
                    <input wire:model.defer="productMinimo" onkeypress="return event.charCode >= 46 && event.charCode <= 57" name="productMinimo" class="form-control" />
                    @error('productMinimo') <span class="error text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col">
                    <label for="productExistencia">Existencia</label>
                    <input wire:model.defer="productExistencia" onkeypress="return event.charCode >= 46 && event.charCode <= 57" name="productExistencia" class="form-control" />
                    @error('productExistencia') <span class="error text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>



              </div>
            @endif


          </div>


          
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i
            class="fas fa-window-close"></i> Cancelar</button>
        @if (isset($producto->id))
          <button type="button" wire:click.prevent="update()" class="btn btn-primary"><i class="fas fa-save"></i>
            Guardar</button>
        @else
          <button type="button" wire:click.prevent="update()" class="btn btn-primary"><i class="fas fa-plus"></i>
            Agregar</button>
        @endif

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    $('.select2-single').select2({
      theme: "bootstrap4",
      placeholder: "Elige una Marca",
      containerCssClass: ':all:'
    });
    
    $('.select2-multiple').select2({
      theme: "bootstrap4",
      placeholder: "Elige categorías",
      maximumSelectionSize: 6,
      containerCssClass: ':all:'
    });

    Livewire.on('setCategoria', function(values){
      $('.select2-multiple').val(values).trigger("change");
    });

    Livewire.on('setMarca', function(values){
      $('#select_marca').val(values).trigger("change");
    });

    Livewire.on('addMarca', function(value){
      var newOption = new Option(value, value, true, true);
      $('#select_marca').append(newOption).trigger('change');
    });

    $("#select_marca").on('change', () => {
      var marca = $("#select_marca").select2("val");
      @this.set('producto.marca', marca);
    });

    $("#select_categorias").on('change', () => {
      var categoria = $("#select_categorias").select2("val");
      @this.set('producto.categorias', JSON.stringify(categoria));
    });
  });
</script>
