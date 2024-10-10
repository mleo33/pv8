<div class="pt-4">

    <div class="row justify-content-center">
        <div class="card" style="width: 400px;">
            <div class="card-header">
                <h3 class="card-title">Capturar Conteo Físico</h3>
            </div>
            <div class="card-body">
                <center>

                    <h2>@money($total)</h2>
                    <br>

                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-4">
                                <p>Efectivo:</p>
                                <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center;" wire:model.lazy="efectivo" class="form-control" />
                                @error('efectivo')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4">
                                <p>Tarjetas:</p>
                                <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center;" wire:model.lazy="tarjeta" class="form-control" />
                                @error('tarjeta')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-4">
                                <p>Transferencias:</p>
                                <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center;" wire:model.lazy="transferencia" class="form-control" />
                                @error('transferencia')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4">
                                <p>Cheques:</p>
                                <input onkeypress="return event.charCode >= 46 && event.charCode <= 57" style="text-align: center;" wire:model.lazy="cheque" class="form-control" />
                                @error('cheque')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <h5>{{$this->user->name}}</h5>
                            <h4>Conteo registrado Hoy:</h4>
                            <h3>@money($this->conteoRegistrado)</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button wire:click="capturarConteo" class="btn btn-md btn-primary btn-block"><i class="fa fa-check"></i> Aceptar</button>
                        </div>
                    </div>

                </center>
            </div>
        </div>
        
    </div>


</div>
