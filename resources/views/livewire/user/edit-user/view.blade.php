@section('title', __($this->user->name))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $this->user->name }}</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-5">
                    <a href="/usuarios" class="mb-3 btn btn-xs btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input wire:model.lazy="user.name" type="text" class="form-control" />
                        @error('user.name') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Correo</label>
                        <input wire:model.lazy="user.email" type="text" class="form-control" style="text-transform: lowercase;" />
                        @error('user.email') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-7">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Selecc.</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $item)                            
                            <tr>
                                <td><x-input-checkbox model="userRoles.{{$item->id}}" /></td>
                                <td>{{$item->name_format}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>

        <div class="card-footer">
            <button class="btn btn-primary" wire:click="save()"><i class="fas fa-save"></i> Guardar datos</button>
        </div>
    </div>
</div>
