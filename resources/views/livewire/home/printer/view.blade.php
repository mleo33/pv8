@section('title', __('Inicio'))
@extends('adminlte::page')

@section('content')

<div class="card mt-3">
    <div class="card-header">
      <h3 class="card-title">AOSPrint</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
        <center>
            <br><br>
            <img width="20%" src="{{ asset('images/logo.png') }}">
            <h1>{{env('APP_FULL_NAME')}}</h1>
            <h2>{{env('BUSSINESS_DESCRIPTION')}}</h2>
            <br>
        
            <div class="mt-3" style="width: 95%">
                <h3>Versión 1.4</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Aplicación Completo</th>
                            <th>Solo Ejecutable</th>
                            <th>Manual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a class="btn btn-sm btn-primary" href="https://www.dropbox.com/s/v07m6dbwhuv09vh/AOSPrint.zip?dl=0" target="_blank"><i class="fa fa-print"></i> Aplicación Completa</a></td>
                            <td><a class="btn btn-sm btn-primary" href="https://www.dropbox.com/scl/fi/io0wwooct98b4hiy8bvha/AOSPrint_exe.zip?rlkey=svchm9mx5rbguxckvfhz27bk4&dl=0" target="_blank"><i class="fa fa-print"></i> Solo Ejecutable</a></td>
                            <td><a class="btn btn-sm btn-primary" href="https://www.dropbox.com/s/9gy6nlf1to65jlh/Manual%20AOSPrint.pdf?dl=0" target="_blank"><i class="fa fa-book"></i> Manual de Instalación</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </center>
    </div>
</div>



@endsection