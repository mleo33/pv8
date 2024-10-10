<div class="pt-4">

    <div class="row justify-content-center">
        <div class="card" style="width: 350px;">
            <div class="card-header">
              <h3 class="card-title">Fondo de Caja</h3>
            </div>
            <div class="card-body">
                <center>
                    <form autocomplete="off" action="capturar-fondo" method="POST" id="form">
                        @csrf
                        <label>Usuario: {{$this->user->name ?? 'N/A'}}</label>
                        <br>
                        <br>
                        <div class="form-group mb-4">
                            <p>Ingrese fondo:</p>
                            <input id="iptMonto" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" value="0" onclick="this.select()" style="text-align: center" class="form-control" name="monto">
                            <input type="hidden" value="{{$this->user->id}}" class="form-control" name="user_id">
                        </div>
                        <div class="row">

                            <div class="col">
                                <button type="submit" class="btn btn-md btn-primary btn-block"><i class="fa fa-check"></i> Aceptar</button>
                            </div>

                        </div>
                    </form>

                </center>


            </div>
        </div>
    </div>
  
  
</div>
  