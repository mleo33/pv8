<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold"><i class="fas fa-user"></i> Facturación</h3>      
    </div>

    <div class="card-body p-3" style="min-height: 25vh">
        <h6><b>Forma Pago: </b></h6>
        <select wire:model="factura_t.forma_pago" wire:change="saveFactura" style="width: 40%;" class="form-control">
            @foreach ($this->formas_pago as $key => $value)
                <option value="{{$key}}">{{$key}} - {{$value}}</option>
            @endforeach
        </select>
        
    </div>
</div>