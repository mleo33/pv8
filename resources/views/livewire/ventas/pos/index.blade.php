@extends('adminlte::page')



@section('content')

  @include('partials.system.loader')
  @livewire('ventas')

@endsection

@section('js')
<script src="{{asset('js/onscan.min.js')}}"></script>
<script>
  document.addEventListener('keydown', function(e){
    if(!isNaN(e.key)){
      // console.log('Es Numero', e.key);
    }
    if(e.key == "*"){
      // console.log('ingrese cantidad');
    }

  });
    
  // Enable scan events for the entire document
  onScan.attachTo(document);
  // Register event listener
  document.addEventListener('scan', function(scanData) {
    window.livewire.emit('setProductByCode', scanData.detail.scanCode);
  });
  
  function changeQty(id, descripcion, cantidad) {
    new Swal({
      title: 'Modifica la cantidad de ' + descripcion,
      input: 'number',
      inputValue: cantidad,
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Modificar',
      confirmButtonColor: '#007BFF',
    }).then(function(result) {
      if (result.isConfirmed) {
        window.livewire.emit('addQty', id, (result.value - cantidad));          
      }
    });
  }

  mdlDiasApartado = () => {
    const inputValue = 60

    Swal.fire({
      inputLabel: 'Máximo 60 días',
      inputAttributes: {
        min: 1,
        max: 60,
        step: 1
      },
      inputValue,
      title: 'Días de apartado',
      html: `
        <input
          style="text-align: center;"
          type="number"
          value="${inputValue}"
          class="swal2-input"
          id="range-value">`,
      input: 'range',
      showCancelButton: true,
      cancelButtonText: '<i class="fa fa-times"></i> Cancelar',
      confirmButtonText: '<i class="fa fa-check"></i> Aceptar',
      confirmButtonColor: '#28a745',
      reverseButtons: true,
      didOpen: () => {
        const inputRange = Swal.getInput()
        const inputNumber = Swal.getHtmlContainer().querySelector('#range-value')
        inputNumber.select();
        // remove default output
        inputRange.nextElementSibling.style.display = 'none'
        inputRange.style.width = '100%'

        // sync input[type=number] with input[type=range]
        inputRange.addEventListener('input', () => {
          inputNumber.value = inputRange.value
        })

        // sync input[type=range] with input[type=number]
        inputNumber.addEventListener('change', () => {
          inputRange.value = inputNumber.value
        })
      }
    }).then(function(result){
      if(result.isConfirmed){
        window.livewire.emit('mdlAnticipoApartado', result.value);
      }
    });
  };
</script>
@endsection
