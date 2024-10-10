<div class="card">

  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-barcode"></i> Productos</h3>
  </div>

  <div class="card-body p-3">
    <button wire:click="$emit('showModal','#mdlSelectProduct')" class="btn btn-sm btn-primary"><i
        class="fas fa-book"></i> Catalogo de Productos</button>
    <div class="form-group mt-2">
      <input type="text" class="form-control" id="code" placeholder="Codigo"
        wire:keydown.enter="setProductByCode($event.target.value)"
        onkeypress="(e => {if(e.key == 'Enter') $('#code').val('')})(event)">
    </div>
  </div>
</div>


