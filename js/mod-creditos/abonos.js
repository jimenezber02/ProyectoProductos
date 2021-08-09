//OPERACION CON LOS ABONOS DE X CLIENTE
const formuAbono=(data)=>{
  if(($('#formuAbono').css('display')) != 'block'){
    $('<div>').load('../php/formulario/abono.php',function()
    {
      //Quita la imagen/logo del div
      if(($('#maryIMG').css('display')) == 'inline'){
        $('#maryIMG').hide('normal');
      }
      //Quita el formulario de nuevo cliente del div
      if(($('#formuNuevoCliente').css('display')) == 'block'){
        document.getElementById("formuNuevoCliente").remove();
      }
      //Quita del div al formulario de nuevo pedido
      if(($('#formuPedidoNuevo').css('display')) == 'block'){
        document.getElementById("formuPedidoNuevo").remove();
      }
      //Va añadiendo los input del formulario de abono al div
      $('#imagen2').append($(this).html());
      //Llama a funcion para cargar los input con los datos del cliente
      carga_abono(data);
    }).show('normal');
  }else{
    carga_abono(data);
  }
}

const carga_abono=(data)=>{
  //Carga el formulario de abonar al credito de un cliente
  let dat = data.split('|');
  let v = clientes.filter(x => x.id_cli == dat[0]);
  /*$.ajax({
    type: 'POST',
    url: '../php/creditos/busca_cliente.php',
    data: 'id=' + dat[0],
    success:function(r){
      let elDatoRetornado = jQuery.parseJSON(r);*/
      $('#idFormAbono').val(dat[5]);
      $('#nombreCliA').val(v[0].nombre);
      $('#apellidoCliA').val(v[0].apellido);
      $('#cedulaCliA').val(v[0].cedula);
      $('#cuentaCredito').val(dat[4]);
    //}
  //});
}

const abonar_a_la_cuenta=()=>{
  //Operación con los datos del formulario de abonar
  let objeto = {
    cuentaCredito: parseFloat($('#cuentaCredito').val()),
    elAbono: parseFloat($('#abonoM').val()),
    idCuenta: $('#idFormAbono').val(),
    fecha: $('#fechaAbono').val()
  }
  console.log(objeto);
  if(objeto.cuentaCredito >= objeto.elAbono){
    if(objeto.elAbono > 0){
      $.ajax({
        type: 'POST',
        url: '../php/creditos/abonar.php',
        data: objeto,
        success:function(r){
          if(r == 1){
            carg_pag();
            $('#formAB')[0].reset();
            $('#imagen2').html('<img src="../img/lgo.png" id="maryIMG">').show('normal');
            alertify.success("Operacion realizada con exito");
          }else{alertify.error('Ocurrió un error');}
        }
      });
    }
    else{alertify.error('Debes abonar algo mas'); return false;}
  }else{alertify.error('Excede el monto');return false;}
}

const abonarMonto=()=>{
  alertify.confirm('PAGAR TODO','Esta acción eliminará todos los pedidos',function(){
    let objeto = {
      cuentaCredito: parseFloat($('#cuentaCredito').val()),
      idCuenta: $('#idFormAbono').val()
    }
    if(objeto.cuentaCredito > 0){
      $.ajax({
        type: 'POST',
        url: '../php/creditos/pagaTodaLaCuenta.php',
        data: objeto,
        success:function(r){
          console.log(r);
          if(r > 0){
            carg_pag();
            $('#formAB')[0].reset();
            $('#imagen2').html('<img src="../img/lgo.png" id="maryIMG">').show('normal');
            alertify.success('Correcto');
          }
        }
      });
    }else{
      alertify.error('No tiene cuenta para pagar');
    }
  },function(){alertify.error('Cancelado');}).set({transition: 'zoom'}).show('normal');
}

const cancelarAbono=()=>{
  $('#formAB')[0].reset();
  $('#imagen2').html('<img src="../img/lgo.png" id="maryIMG">').show('normal');
}