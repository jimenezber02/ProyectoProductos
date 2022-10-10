//OPERACION CON LOS ABONOS DE X CLIENTE

$(document).ready(function (){
  console.log("documento script abono trabajando");
});

//Carga el formulario de abono
const loadFormAbono=(datos,idCuenta)=>{
  let data = datos.split('|');

  $('#aside-form-space').load("../php/formulario/abono.php",function (){
    $("#fecha").datepicker({showButtonPanel: true,changeMonth: true,changeYear: true,maxDate: "+0M +30D +0Y"});

    $('input[name=idCuenta]').val(idCuenta);
    $('input[name=idCliente]').val(data[0]);
    $('input[name=nombre]').val(data[1]);
    $('input[name=apellido]').val(data[2]);
    $('input[name=cedula]').val(data[3]);
    $('input[name=cuenta]').val(parseFloat(data[4]));

    let form = $('#formABONO');
    $('#abonar').click(function (){
      abonar_a_la_cuenta(form,parseFloat(data[4]))
    });
    $('#pagar_todo').click(function (){
      if(parseFloat(data[4])>0){
        pagarTodo(form);
      }
      else{
        alertify.error("No tiene deuda");
      }
    });
  });
}

const abonar_a_la_cuenta=(form,maxVal)=>{
    validacionFormAbono(form,maxVal);
    if(form.valid()) {
      console.log(form.serialize());
        //saveAbono(form, 1);
    }else{
        alertify.error("Formulario inválido");
    }
}

//*** Accion 1: para abonar
//*** Acción 2: para pagar toda la cuenta
const saveAbono=(form,accion=2)=>{
    $.ajax({
        type: 'post',
        url: '../php/peticiones/abono.php',
        data: form.serialize() + "&accion=" + accion,
        success: function (response) {
            console.log(response);
            resp = jQuery.parseJSON(response);
            if(resp.tabla_cuenta > 0)
            {
              recarga_tabla();
              cancelarAbono();
              alertify.success("Abonado con éxito");
            }else{
              alertify.error("Error al abonar");
            }
        }, error: function () {
            alertify.error("Ocurrió un error" + this.error);
        }
    });
}

const pagarTodo=(form)=>{
  alertify.confirm('PAGAR TODO','Esta acción eliminará todos los pedidos y establecerá la cuenta a 0.00',function(){
    saveAbono(form);
  },function(){alertify.error('Cancelado');}).set({transition: 'zoom'}).show('normal');
}

const cancelarAbono=()=>{
  $('#formABONO')[0].reset();
  $('#aside-form-space').html('<img src="../img/lgo.png" id="maryIMG">').show('normal');
}

const validacionFormAbono=(form,maxVal)=>{
    form.validate({
       rules: {
           elabono:{
               required: true,
               min: 0.05,
               max: parseFloat(maxVal)
           }
       },
       messages:{
           elabono:{
               required: "Este campo es obligatorio",
               min: "valor muy bajo",
               max: "Sobrepasa el monto de la deuda"
           }
       }
    });
}
