

@section('title', __('Rentas Prox. Vencimiento'))
@extends('adminlte::page')

@section('content')

    @include('partials.system.loader')
    <div class="pt-4">

        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Equipos proximos a vencer</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
    
              {{-- <div class="row m-2">
                <div class="col-md-12">
                  <label>Buscar</label>
                  <input type="text" wire:keydown="resetPage()" class="form-control" wire:model="searchValue">
                </div>
              </div> --}}
              
              <table class="table table-striped projects">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>FUA</th>
                    <th>Equipo</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    {{-- <th>Tel.</th> --}}
                    <th>Vencimiento</th>
                    <th>Renta</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($equipos as $item)
                    @php
                        $txtColor = now() > $item->retorno() ? 'red' : 'black';
                        $vence = 'Dentro de 1 Hora';
                    @endphp
                    <tr style="color: {{$txtColor}}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->fua }}</td>
                        <td data-toggle="tooltip" title="{{$item->descripcion}}">{{ $item->descripcion }}</td>
                        <td>{{ $item->renta->usuario->name }}</td>
                        <td>{{ $item->renta->cliente->nombre }}</td>
                        {{-- <td>{{ $item->renta->cliente->telefonos->count() > 0 ? 'TEL' : 'N/A' }}</td> --}}
                        <td>
                            {{ $item->retorno_format() }}
                            <br>
                            <small>{{$item->retorno()->diffForHumans()}}</small>
                        </td>
                        <td><a href="/administrar_renta/{{$item->renta_id}}" target="_blank" class="btn btn-sm btn-warning"><i class="fas fa-handshake"></i> Renta #@paddy($item->renta_id)</a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              
            </div>
            
            <!-- /.card-body -->
        </div>
        {{-- {{ $rentas->links() }} --}}
        
    </div>

@endsection