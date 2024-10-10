document.addEventListener('DOMContentLoaded', function(){
  Livewire.on('closeModal', function(target = '.modal'){
    $(target).modal('hide');
  });

  Livewire.on('showModal', function(target = '.modal'){
    $(target).modal('show');
  });

  Livewire.on('sidebarCollapse', function(){
    $('body').addClass('sidebar-collapse')
  });

  Livewire.on('sidebarCollapseToggle', function(){
    $('body').toggleClass('sidebar-collapse')
  });

  Livewire.on('focus', function(target){
    $(target).focus();
  });

  Livewire.on('selectText', function(target){
    $(target).select();
  });

  Livewire.on('click', function(target){
    $(target).click();
  });

  Livewire.on('ok', function(text, title = null){
    title = title == null ? '¡Hecho!' : title;
    Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        showConfirmButton: false,
        timer: 2000
      });
  });

  Livewire.on('warning', function(text){
    Swal.fire({
        title: '¡Alerta!',
        text: text,
        icon: 'warning',
        showConfirmButton: false,
        timer: 1700
      });
  });

  Livewire.on('error', function(text, title = 'Error'){
    Swal.fire({
        title: title,
        text: text,
        icon: 'error',
        showConfirmButton: false,
        // timer: 1700
      });
  });

  Livewire.on('info', function(text, title){
    Swal.fire({
        title: title,
        text: text,
        icon: 'info',
        showConfirmButton: false,
        timer: 2500
      });
  });

  livewire.on('scan-notfound', action => {
    Swal.fire({
      title: 'Código no registrado',
      icon: 'warning',
      showConfirmButton: false,
      timer: 1000
    });
  });

  Livewire.on('alert', function(message = 'HI THERE!'){
    alert(message);
  });

  Livewire.on('console', function(ob = 'Is there anybody out there?'){
    console.log(ob);
  });

  Livewire.on('redirect', function(url){
    window.open(url);
  });

  function getBrowser(agent) {
    var agent = window.navigator.userAgent.toLowerCase()
    switch (true) {
      case agent.indexOf("edge") > -1: return "edge";
      case agent.indexOf("edg") > -1: return "chromium based edge (dev or canary)";
      case agent.indexOf("opr") > -1 && !!window.opr: return "opera";
      case agent.indexOf("chrome") > -1 && !!window.chrome: return "chrome";
      case agent.indexOf("trident") > -1: return "ie";
      case agent.indexOf("firefox") > -1: return "firefox";
      case agent.indexOf("safari") > -1: return "safari";
      default: return "other";
    }
  }

  Livewire.on('redirect_post', function(url, data, token = ''){

    var f = document.createElement('form');
    f.action= url;
    f.method='POST';
    f.target='_blank';

    var t = document.createElement('input');
    t.type ='hidden';
    t.name = '_token';
    t.value = token;
    f.appendChild(t);

    Object.keys(data).forEach(key => {
      var i = document.createElement('input');
      i.type ='hidden';
      i.name = key;
      i.value = data[key];
      f.appendChild(i);
    });

    document.body.appendChild(f);
    f.submit();
  });

  Livewire.on('print',function(url){
    url = `AOSPrint:${url}`;
    var anchor = document.createElement('a');
    anchor.href = url
    anchor.click();
    anchor = null;
  });

  Livewire.on('fetch',function(url, successAction){
    fetch(url)
    .then(x => console.log(x));
  });
  
  Livewire.on('post-complemento', function(data, token, successAction){
    Swal.fire({
      title: data['title'],
      text: `¿Desea generar complemento de pago para factura ${data['serie']}${data['folio']}?`,
      icon: 'question',
      reverseButtons: true,
      showCancelButton: true,
      cancelButtonText: '<i class="fas fa-window-close"></i> Cancelar',
      confirmButtonText: '<i class="fa fa-check"></i> Crear',
      confirmButtonColor: '#28a745',
      showLoaderOnConfirm: true,
      preConfirm: () => {

        return fetch('/facturacion/timbrar_complemento', {
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
          },
          method: 'POST',
          body: JSON.stringify(data),
        }).then(response => {
            if (response.ok) {
              return response.json()
            }
            throw new Error(response.statusText)
        }).catch(error => {
          Swal.showValidationMessage(error)
        })
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then(result => {
      if (result.isConfirmed) {
        if(result.value.success){
          // window.livewire.emit('ok', result.value.message);
          window.livewire.emit('closeModal');
          Swal.fire({
            title: `Se ha generado Complemento ${result.value.serie}${result.value.folio}`,
            html: `<a target="_blank" href="/complementos/ver_pdf/${result.value.id}">Ver PDF de Pago</a>`,
            icon: 'success',
            showConfirmButton: true,
            confirmButtonText: '<i class="fa fa-check"></i> OK',
            confirmButtonColor: '#28a745',
            timer: 15000
          });
          window.livewire.emit(successAction, result.value.id);
        }
        else{
          window.livewire.emit('error', result.value.message);
        }
      }
    })
  });

  Livewire.on('post-factura', function(id_fact_temp, title, token, successAction){
    Swal.fire({
      title: title,
      text: '¿Desea generar factura?',
      icon: 'question',
      reverseButtons: true,
      showCancelButton: true,
      cancelButtonText: '<i class="fas fa-window-close"></i> Cancelar',
      confirmButtonText: '<i class="fa fa-check"></i> Crear',
      confirmButtonColor: '#28a745',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        return fetch('/facturacion/timbrar_factura', {
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
          },
          method: 'POST',
          body: JSON.stringify({
            id_factura: id_fact_temp,
          }),
        }).then(response => {
            if (response.ok) {
              return response.json()
            }
            throw new Error(response.statusText)
        }).catch(error => {
          Swal.showValidationMessage(error)
        })
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then(result => {
      if (result.isConfirmed) {
        if(result.value.success){
          Swal.fire({
            title: `Se ha generado Factura ${result.value.serie}${result.value.folio}`,
            html: `<a target="_blank" href="/facturacion/ver_pdf/${result.value.id}">Ver PDF de Factura</a>`,
            icon: 'success',
            showConfirmButton: true,
            confirmButtonText: '<i class="fa fa-check"></i> OK',
            confirmButtonColor: '#28a745',
            timer: 15000
          });
          window.livewire.emit(successAction, result.value.id);
        }
        else{
          window.livewire.emit('error', result.value.message);
        }
      }
    })
  });

  Livewire.on('post-cancelar-factura', function(data, title, token, successAction){
    
    Swal.fire({
      title: title,
      text: '¿Desea cancelar factura?',
      icon: 'warning',
      reverseButtons: true,
      showCancelButton: true,
      cancelButtonText: '<i class="fas fa-window-close"></i> Cancelar',
      confirmButtonText: '<i class="fa fa-check"></i> Continuar',
      confirmButtonColor: '#28a745',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        return fetch('/facturacion/cancelar_factura', {
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
          },
          method: 'POST',
          body: JSON.stringify({
            factura_id: data.factura_id,
            folio_sustitucion: data.folio_sustitucion,
            motivo: data.motivo,
          }),
        }).then(response => {
            if (response.ok) {
              return response.json()
            }
            throw new Error(response.statusText)
        }).catch(error => {
          Swal.showValidationMessage(error)
        })
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then(result => {
      if (result.isConfirmed) {
        if(result.value.success){
          Swal.fire({
            title: `Se ha cancelado Factura`,
            icon: 'success',
            showConfirmButton: true,
            confirmButtonText: '<i class="fa fa-check"></i> OK',
            confirmButtonColor: '#28a745',
            timer: 15000
          });
          // window.livewire.emit(successAction, result.value.id);
        }
        else{
          window.livewire.emit('error', result.value.message);
        }
      }
    })
  });
  
  Livewire.on('confirm', function(text, title, emit_confirm, id){
    new Swal({
      title: title,
      text: text,
      icon: 'question',
      showCancelButton: true,
      cancelButtonText: 'NO',
      confirmButtonText: 'SI',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#d33',
      reverseButtons: true,
    }).then(function(result){
      if(result.value){
        window.livewire.emit(emit_confirm, id);
      }
    });
  });

  Livewire.on('warning-confirm', function(text, title, emit_confirm, id){
    new Swal({
      title: title,
      text: text,
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'NO',
      confirmButtonText: 'SI',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#d33',
      reverseButtons: true,
    }).then(function(result){
      if(result.value){
        window.livewire.emit(emit_confirm, id);
      }
    });
  });

  destroy = (id, text, emit = 'destroy') => {
    new Swal({
      title: 'Eliminar ' + text,
      text: '¿Desea eliminar ' + text + '?',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Eliminar',
      confirmButtonColor: '#d33',
    }).then(function(result){
      if(result.value){
        window.livewire.emit(emit, id);
      }
    });
  }
});