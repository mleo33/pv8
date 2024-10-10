<div class="card">

  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-comments"></i> Comentarios de Venta</h3>
  </div>

  <div class="card-body p-3">
    <div class="form-group mt-2">
      <textarea wire:model="venta_t.comentarios" wire:change="saveComment()" rows="3" placeholder="Comentarios" class="form-control"></textarea>
    </div>
  </div>
</div>


