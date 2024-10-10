@extends('adminlte::page')

@section('content')
@include('shared.system.loader')


<div class="row mt-3">
    <div class="col">
        <div class="card card-primary card-outline card-outline-tabs" style="min-height: 500px;">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true"><i class="fa fa-user-shield"></i> Roles</a>
                    </li>
                    <li class="nav-item m-0">
                        <a class="m-0 nav-link" data-toggle="pill" href="#tab2" role="tab" aria-selected="false"><i class="fa fa-key"></i> Permisos</a>
                    </li>

                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                        <livewire:user.roles.admin-roles />
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                        <livewire:user.roles.admin-permissions />
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>
@endsection
