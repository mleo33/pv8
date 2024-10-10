<div>
    <div>
        <center>
            @if (!$this->factura_t->model_id)
                <button data-toggle="modal" data-target="#mdlSelectRenta" class="btn btn-sm btn-warning"><i
                        class="fas fa-handshake"></i> Seleccionar Renta</button>
                <button data-toggle="modal" data-target="#mdlSelectVenta" class="btn btn-sm btn-primary"><i
                        class="fas fa-shopping-basket"></i> Seleccionar Venta</button>
            @elseif ($this->factura_t->model_type == 'App\\Models\\Venta')
                <a href="/venta/{{ $this->factura_t->model_id }}" target="_blank" class="btn btn-md btn-primary"><i
                        class="fas fa-shopping-basket"></i> Venta #@paddy($this->factura_t->model_id)</a>
            @elseif ($this->factura_t->model_type == 'App\\Models\\Renta')
                <a href="/administrar_renta/{{ $this->factura_t->model_id }}" target="_blank"
                    class="btn btn-md btn-warning"><i class="fas fa-handshake"></i> Renta #@paddy($this->factura_t->model_id)</a>
            @endif

        </center>
    </div>
    <hr>


    <div class="row layout-top-spacing">
        <div class="col-12 col-md-6">
            <h4>Subtotal</h4>
        </div>
        <div class="col-12 col-md-6">
            <h3 class="m-0">@money($this->factura_t->subtotal) </h3>
        </div>
    </div>


    <hr>


    <div class="row layout-top-spacing">
        <div class="col-12 col-md-6">
            <h4>IVA</h4>
        </div>
        <div class="col-12 col-md-6">
            <h3 class="m-0">@money($this->factura_t->iva()) </h3>
            <p class="m-0" style="font-size: 15px;">IVA @php echo number_format($factura_t->tasa_iva, 2) @endphp%</p>
        </div>
    </div>


    <hr>


    <div class="row layout-top-spacing">
        <div class="col-12 col-md-6">
            <h4>Total</h4>
        </div>
        <div class="col-12 col-md-6">
            <h3 class="m-0">@money($this->factura_t->total_c_iva) </h3>
        </div>
    </div>

    <hr>


    <div class="row layout-top-spacing">
        <div class="col-12 col-md-6">
            <h4>Desglosar IVA</h4>
        </div>
        <div class="col-12 col-md-6">
            <label class="content-input">
                <input type="checkbox" wire:model="factura_t.desglosar_iva" wire:change="desglosarIvaToggle" />
                <i></i>
            </label>
        </div>
    </div>

    {{-- @if ($this->factura_t->conceptos->count() > 0 && $this->cliente) --}}
    @if (!$this->factura_t->sucursal->emisor)
        <hr>
        <div class="row layout-top-spacing">
            <div class="col-12">
                <button wire:click="" disabled class="btn btn-large btn-block btn-danger"><i
                        class="fas fa-university"></i> Sucursal no cuenta con emisor fiscal</button>
            </div>
        </div>
    @endif

    @if (
        $this->factura_t->cliente &&
            $this->factura_t->entidad_fiscal &&
            $this->factura_t->conceptos &&
            $this->factura_t->conceptos->count() > 0 &&
            $this->factura_t->sucursal->emisor)
        <hr>
        <div class="row layout-top-spacing">
            <div class="col-12">
                <button wire:click="confirm" class="btn btn-large btn-block btn-success"><i class="fas fa-file-alt"></i>
                    Generar Factura</button>
            </div>
        </div>
    @endif

</div>
