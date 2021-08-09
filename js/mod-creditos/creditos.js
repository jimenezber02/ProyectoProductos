
fech = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
mess = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
$(document).ready(function()
{
  cargaClientes();
  carg_pag();//carga la tabla con los creditos
});
//FIN DE FUNCIÓN PRINCIPAL

const carg_pag=()=>{
  //Carga la tabla con los creditos en el modulo_creditos.php
  $('#data').load('tablas/tabla_creditos.php');
}

const cargaF=()=>{//carga el formulario para nuevo cliente
  if(($('#formuNuevoCliente').css('display')) != 'inline'){
    $('#imagen2').load('../php/formulario/nuevo_cliente.php',function(){
      //$('#imagen2').append($(this).html());
      $('#maryIMG').hide('normal');
    });
  }else{
    $('#formD'[0]).reset();
  }
}

//CARGA EN UN ARREGLO A TODOS LOS CLIENTES REGISTRADOS
var clientes;
const cargaClientes=()=>{
  $.ajax({
    type: 'POST',
    url: '../php/creditos/retorna_cuentas.php',
    data: null,
    success:function(r){
      clientes = jQuery.parseJSON(r);
    }
  });
}

/*PARA CUANDO SE DESEE AGREGAR NUEVO PEDIDO DE CREDITO*/
v = ["Ingresar el monto (opcional)","Monto para despues"];
cont = 1;
const carga_inputMonto=()=>{
  $("#inpmonto").html(v[cont]);
  if(cont >= 1){
      cont = 0;
      document.getElementById("Cmonto").style.display = "block";
  }else{
      cont ++;
      document.getElementById("Cmonto").style.display = "none";
  }
}

//RECOGE TODOS LOS DATOS DE FORMULARIO DE UN NUEVO CLIENTE
const formulario=()=>{//obtiene los datos del formulario de abrir cuenta
  let nombre = $('#inputNombre').val();
  let apellido = $('#inputApellido').val();
  let cedula = $('#inputCed').val();
  let cuenta = $("#montoP").val();
  let f = $('#fecha').val();
  if(cedula == ""){
    cedula = "-";
  }
  let coment = $('#comentario').val();
  //Proceso para la fecha
  let d = proceso_fecha(f);
  let fecha_completa =  d.getFullYear() + "/" + mess[d.getMonth()] + "/" + d.getDate();

  let objeto = {
    nom: nombre, 
    ape: apellido, 
    ced: cedula, 
    cuenta: parseFloat(cuenta), 
    anio: d.getFullYear().toString(),
    dia: fech[d.getDay()], 
    mes: mess[d.getMonth()], 
    diaN: d.getDate(), 
    fecha: fecha_completa,
    comentario: coment 
  }
  //console.log(objeto);
  valida(objeto);
}

const diasEnmes=(mes,anio)=>{
    //Retorna cuanto dias tiene un mes
    return new Date(anio,mes,0).getDate();
}

const proceso_fecha=(fecha)=>{
  //Proceso para la fecha
    let d;
    //Si no se ha seleccionado una fecha
    if(fecha == ""){
      //crea un objeto con la fecha de hoy
       d = new Date();
    }else{
        //toma la fecha que se ha seleccionado y lo separa por guion
        let vf = fecha.split('-');
        //Crea nuevo objeto de la clase date
        d = new Date(vf[0],vf[1]-1,vf[2]);
    }
    return d;
}

//VERIFICA LOS NUEVOS DATOS CON LOS QUE YA ESTA EN EL ARREGLO DE DATOS
const verificaDatos=(objeto)=>{
  //PARA VERIFICAR DE QUE EL NUEVO CLIENTE NO ESTÉ REGISTRADO
  let busNom = clientes.findIndex(x => (x.nombre).toUpperCase() == (objeto.nom).toUpperCase());
  let busApe = clientes.findIndex(x => (x.apellido).toUpperCase() == (objeto.ape).toUpperCase());
  if((busNom != -1) && (busApe != -1)){
    return true;
  }else{
    return false;
  }
}

//SI TODO ESTA OKEY, ENVIA EL NUEVO CLIENTE A LA BASE DE DATOS
const valida=(datos)=>{
  //Validación de los datos obtenidos del formulario
  if(datos.nom != ""){
    if(datos.ape != ""){
      if(verificaDatos(datos) == false){
        $.ajax({
          type: 'POST',
          url: '../php/creditos/agregar_cuenta.php',
          data: datos,
          success:function(r){
            console.log(r);
            if(r > 0){
              let newObjeto = {id_cli: r, nombre: datos.nom, apellido: datos.ape, cedula: datos.ced};
              clientes.push(newObjeto);
              carg_pag();
              alertify.success("Datos enviados");
              $('#formD')[0].reset();
            }else{
              alertify.error("Error al enviar datos");
            }
          }
        });
      }
      else{alertify.error('Cliente ya registrado');return false;}
    }else{
        alertify.error("Ingrese el apellido");return false;
    }
  }else{
      alertify.error("Ingrese el nombre");return false;
  }
}

const delete_cliente=(datos)=>{
  //Para eliminar un cliente
  let x = datos.split('|');
  let objeto = {
    id: x[0],
    nombre: x[1],
    apellido: x[2]
  }

  alertify.confirm('Eliminar','Va a eliminar a ' + x[1] + " " + x[2] +'</br></br>Desea Continuar?',function(){
    
    $.ajax({
      type: 'POST',
      url: '../php/creditos/eliminar_cliente.php',
      data: 'id=' + x[0],
      success:function(r){
        if(r > 0){
          carg_pag();
          alertify.success("Eliminado el cliente");
          clientes.splice(clientes.findIndex(x => x.id_cli == objeto.id),1);
          console.log(clientes);
        }else{alertify.error("No se pudo eliminar");}
      }
    });

  },function(){alertify.error('Cancelado');}).set({transition:'zoom'}).show();
}

const modalEdit=(data)=>{
  //Carga la ventana de editar datos de un cliente
  dat = data.split('|');
  $('#idCliEdit').val(dat[0]);
  $('#inputNombreC').val(dat[1]);
  $('#inputApeC').val(dat[2]);
  $('#inputCedC').val(dat[3]);
}

//RECOGE DESDE EL FORMULARIO DE EDITAR CLIENTE Y ENVIA A PHP PARA EDITAR
const update_cliente=()=>{
  //Edita los datos de un cliente
  objeto = {
    id_cli: $('#idCliEdit').val(),
    nombre: $('#inputNombreC').val(),
    apellido:  $('#inputApeC').val(),
    cedula: $('#inputCedC').val()
  };

  $.ajax({
    type: 'POST',
    url: '../php/creditos/edita_cliente.php',
    data: objeto,
    success:function(r){
      if(r == 1){
        clientes.splice(clientes.findIndex(x => x.id_cli == objeto.id_cli),1);
        clientes.push(objeto);
        $('#form-ed')[0].reset();
        $('#modalEdicion').modal('hide')
        carg_pag();
        alertify.success("Correcto");
      }else{alertify.error("Error al editar");}
    }
  });
}

const abrePDF=()=>{
  let band = 1;
  let fecha = new Date();
  let date = (fecha.getDate())+'-'+(fecha.getMonth()+1)+'-'+fecha.getFullYear();
  window.open('../php/pdf/creditosPDF.php?cond='+band+'&date='+date,'_blank');
}

const abrePDF2=()=>{
  let fecha = new Date();
  console.log(fecha.getHours() + ':' + fecha.getMinutes());
  let hora;
  let minute; 
  if(fecha.getHours() < 10){
    hora = "0" + fecha.getHours() + ':';
    if(fecha.getMinutes() < 10){
      minute = "0" + fecha.getMinutes();
    }else{
      minute = fecha.getMinutes();
    }
  }
  else{
    hora = fecha.getHours() + ':';
    if(fecha.getMinutes() < 10){
      minute = "0" + fecha.getMinutes();
    }else{
      minute = fecha.getMinutes();
    }
    hora += minute;
  }
  let band = 0;
  let date = (fecha.getDate())+'/'+(fecha.getMonth()+1)+'/'+fecha.getFullYear() + '    Hora: ' + hora;
  window.open('../php/pdf/creditosPDF.php?cond='+band+'&date='+date,'_blank');
}

const desglose_fecha=(id_cliente)=>{
  $(location).attr('href','../php/creditos/desglose_fecha.php?id='+id_cliente);
}