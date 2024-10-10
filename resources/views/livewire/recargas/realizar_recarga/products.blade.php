<div class="pt-4">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Productos</h3>
        </div>
        <div class="card-body p-0">
            <button wire:click="$set('idSelectedProvider', 0)" class="m-3 btn btn-lg btn-secondary"><i class="fa fa-long-arrow-alt-left"></i> Regresar</button>
            {{-- <div class="m-3" wire:loading.remove>
                <button wire:click="$set('idSelectedProvider', 0)" class="m-3 btn btn-lg btn-secondary"><i class="fa fa-long-arrow-alt-left"></i> Regresar</button>
            </div>
            <div class="m-3" wire:loading>
                <h1><i class="fa fa-spinner fa-spin"></i> Cargando...</h1>
            </div> --}}


            <div class="row">
                @foreach ($products ?? [] as $prod)                   
                <div wire:click="mdlRecarga('{{$prod->Codigo}}')" class="col-4">
                    <center style="margin: 15px; padding:20px; border: solid 2px gray; border-radius: 12px; cursor: pointer;">
                        <h4>{{$prod->Categoria}} @money($prod->Monto)</h4>
                        <image style="height: 50px;" src="{{$selectedProvider['Logotipo']}}" />
                    </center>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    

    @if ($selectedProduct)
        @include('livewire.recargas.realizar_recarga.modal_no_celular')
    @endif
    @include('livewire.recargas.realizar_recarga.modal_pago')
</div>