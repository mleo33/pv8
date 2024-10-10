<div class="pt-4">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Venta de Tiempo Aire</h3>
        </div>
        <div class="card-body p-0">
            {{-- <div class="m-3" wire:loading.remove>
            </div>
            <div class="m-3" wire:loading>
                <h1><i class="fa fa-spinner fa-spin"></i> Cargando...</h1>
            </div> --}}

            <div class="row">

                @if (collect($providers)->isEmpty())
                <div class="col-12">
                    <center class="p-5">
                        <h1>Credenciales TAECEL no configuradas</h1>
                    </center>
                </div>
                @endif

                @foreach ($providers ?? [] as $provider)                   
                <div wire:click="getProducts({{$provider->ID}})" class="col-4">
                    <center style="margin: 15px; padding:20px; border: solid 2px gray; border-radius: 12px; cursor: pointer;">
                        <label>{{$provider->Nombre}}</label><br>
                        <image style="height: 50px;" src="{{$provider->Logotipo}}" />
                    </center>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
</div>