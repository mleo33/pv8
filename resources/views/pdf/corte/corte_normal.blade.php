@extends('pdf.layout.template2')
@section('title', __('Corte de Caja'))

@section('content')
    <h2>Corte de Caja</h2>
    <h3>
        Sucursal: {{ $sucursal->nombre }}
        - {{ $startDate }} al {{ $endDate }}
        @if ($usuario->id)
            - Usuario: {{ $usuario->name }}
        @endif
    </h3>


    <section>
        <div class="d-flex justify-content-between mt-3">
            {{-- <h3 class="ml-3">DM</h3> --}}
            <h4 class="ml-2">Ingresos: @money($ingresos->where('forma_pago', '!=', 'PUNTOS')->sum('monto'))</h4>
        </div>

        <table class="table table-striped projects" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>EFECTIVO</th>
                    <th>TARJETAS</th>
                    <th>TRANSFERENCIAS</th>
                    <th>CHEQUES</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>VENTAS FACTURADAS</td>
                    <td align="right">@money($i_ventas_f->where('forma_pago', 'EFECTIVO')->sum('monto'))</td>
                    <td align="right">@money($i_ventas_f->where('forma_pago', 'TARJETA')->sum('monto'))</td>
                    <td align="right">@money($i_ventas_f->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</td>
                    <td align="right">@money($i_ventas_f->where('forma_pago', 'CHEQUE')->sum('monto'))</td>
                </tr>
                <tr>
                    <td>VENTAS NO FACTURADAS</td>
                    <td align="right">@money($i_ventas_nf->where('forma_pago', 'EFECTIVO')->sum('monto'))</td>
                    <td align="right">@money($i_ventas_nf->where('forma_pago', 'TARJETA')->sum('monto'))</td>
                    <td align="right">@money($i_ventas_nf->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</td>
                    <td align="right">@money($i_ventas_nf->where('forma_pago', 'CHEQUE')->sum('monto'))</td>
                </tr>
                <tr>
                    <td>ABONOS</td>
                    <td align="right">@money($i_ventas->where('tipo', 'ABONO')->where('forma_pago', 'EFECTIVO')->sum('monto'))</td>
                    <td align="right">@money($i_ventas->where('tipo', 'ABONO')->where('forma_pago', 'TARJETA')->sum('monto'))</td>
                    <td align="right">@money($i_ventas->where('tipo', 'ABONO')->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</td>
                    <td align="right">@money($i_ventas->where('tipo', 'ABONO')->where('forma_pago', 'CHEQUE')->sum('monto'))</td>
                </tr>

                <tr>
                    <td><b>TOTAL</b></td>
                    <td align="right"><b>@money($ingresos->where('forma_pago', 'EFECTIVO')->where('tipo', '!=', 'FONDO')->sum('monto'))</b></td>
                    <td align="right"><b>@money($ingresos->where('forma_pago', 'TARJETA')->where('tipo', '!=', 'FONDO')->sum('monto'))</b></td>
                    <td align="right"><b>@money($ingresos->where('forma_pago', 'TRANSFERENCIA')->where('tipo', '!=', 'FONDO')->sum('monto'))</b></td>
                    <td align="right"><b>@money($ingresos->where('forma_pago', 'CHEQUE')->where('tipo', '!=', 'FONDO')->sum('monto'))</b></td>
                </tr>

            </tbody>
        </table>
    </section>


    <br><br>
    <div class="d-flex justify-content-between mt-3">
        @php
            $fondo = $ingresos->where('tipo', 'FONDO')->sum('monto');
            $efectivoCaja = $ingresos->where('forma_pago', 'EFECTIVO')->sum('monto');
            $sumEgresosEfectivo = $egresos->where('forma_pago', 'EFECTIVO')->sum('monto');
            $puntos = $ingresos->where('forma_pago', 'PUNTOS')->sum('monto');

            $efectivoCaja = $efectivoCaja - $sumEgresosEfectivo;

            $efectivoSinFondo = $efectivoCaja - $fondo;
        @endphp
        <h4 class="m-1">FONDO: @money($fondo)</h4>
        <h4 class="m-1">Efectivo en CAJA: @money($efectivoCaja)</h4>
        <h4 class="m-1">Ventas Efectivo: @money($efectivoSinFondo)</h4>
        <h4 class="m-1">Ventas con PUNTOS: @money($puntos)</h4>
        <h4 class="m-1">Egresos: @money($sumEgresosEfectivo)</h4>
    </div>


    <table width="100%">
        <thead>
            <tr>
                <th></th>
                <th>EFECTIVO</th>
                <th>TARJETAS</th>
                <th>TRANSFERENCIAS</th>
                <th>CHEQUES</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>CONTEO FISICO</td>
                <td align="right">@money($conteoFisico->sum('efectivo'))</td>
                <td align="right">@money($conteoFisico->sum('tarjeta'))</td>
                <td align="right">@money($conteoFisico->sum('transferencia'))</td>
                <td align="right">@money($conteoFisico->sum('cheque'))</td>
                <td align="right">@money($conteoFisico->sum('total'))</td>
                
            </tr>
        </tbody>
    </table>

    <section>
        @php
            $frase = "Faltante:";
            $faltante = $ingresos->where('forma_pago', '!=', 'PUNTOS')->sum('monto') - $egresos->sum('monto') - $conteoFisico->sum('total');
            if ($faltante < 0) {
                $frase = "Sobrante:";
                $faltante = $faltante * -1;
            }

            if($faltante == 0){
                $frase = "¡Corte Correcto Felicidades!";
            }
        @endphp
        <center>
            <br>
            <h2>{{$frase}} @if($faltante != 0) @money($faltante) @endif</h2>
        </center>
    </section>



    @if ($egresos->count() > 0)
        <table width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>EFECTIVO</th>
                    <th>TARJETAS</th>
                    <th>TRANSFERENCIAS</th>
                    <th>CHEQUES</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Egresos</td>
                    <td align="right">@money($egresos->where('forma_pago', 'EFECTIVO')->sum('monto'))</td>
                    <td align="right">@money($egresos->where('forma_pago', 'TARJETA')->sum('monto'))</td>
                    <td align="right">@money($egresos->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</td>
                    <td align="right">@money($egresos->where('forma_pago', 'CHEQUE')->sum('monto'))</td>
                </tr>
            </tbody>
        </table>
    @endif


    <br><br>
    @if ($egresos->count() > 0)
        <table class="table table-striped projects" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    {{-- <th>Tipo</th> --}}
                    <th>Concepto</th>
                    <th>Forma de Pago</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($egresos as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at->format('M/d/Y h:i A') }}</td>
                        <td>{{ $item->usuario->name }}</td>
                        {{-- <td>{{ $item->tipo }}</td> --}}
                        <td>{{ $item->concepto }}</td>
                        <td>{{ $item->forma_pago }}</td>
                        <td align="right">@money($item->monto)</td>
                @endforeach
            </tbody>
        </table>
    @endif

    <br><br>
    <center>
        <h2>Total: @money($ingresos->where('forma_pago', '!=', 'PUNTOS')->sum('monto') - $egresos->sum('monto'))</h2>
    </center>
@endsection
