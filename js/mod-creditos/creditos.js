

$(document).ready(function()
{
  recarga_tabla();//carga la tabla con los creditos
  cargaClientes();
});
//FIN DE FUNCIÓN PRINCIPAL

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

/** Accion cancelar **/
const cancelar = () => {
  $('#aside-form-space').html('<img alt="logo" src="../img/lgo.png">');
}


/** **Carga la tabla con los creditos en el modulo_creditos.php** **/
const recarga_tabla=()=>{
  $('#data').load('tablas/tabla_creditos.php');
}


/** carga el formulario para nuevo cliente **/
const cargaF=()=>{
    $('#aside-form-space').load("../php/formulario/nuevo_cliente.php",function (){
        $("#fecha").datepicker({showButtonPanel: true});
    });
}

/** PARA CUANDO SE DESEE AGREGAR NUEVO CLIENTE/CUENTA **/
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
const retornaObjetoFecha = (fech) => {
    var dias = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
    var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    var date = proceso_fecha(fech);

    let objetoDat = {
      fecha_completa: date.getFullYear() + "/" + meses[date.getMonth()] + "/" + date.getDate(),
      anio: date.getFullYear().toString(),
      mes: meses[date.getMonth()],
      dia: date.getDate(),
      diaEnLetra: dias[date.getDay()],
    }

    return objetoDat;
}

/*** Accion agregar/crear nuevo cliente/cuenta ***/
const formulario=()=>
{
  var formData = new FormData(document.getElementById("formD"));
    var fechaInput = $('#fecha').val();
    var fechaObjeto = retornaObjetoFecha(fechaInput);

    let form = $('#formD');
    validacion(form);
    if(form.valid()){
        $.ajax({
            type: 'POST',
            url: '../php/peticiones/agregar_cuenta.php',
            data: form.serialize() + '&fecha='+ JSON.stringify(fechaObjeto),
            success:function(response){
                let resp = jQuery.parseJSON(response);
                if(resp.tablaCliente >= 0){
                    recarga_tabla();
                    let msg = "Datos enviados";

                    $('#formD')[0].reset();
                    if(resp.tablaPedidos > 0){
                      msg += ", se almacenó en tabla fecha de pedidos";
                    }
                    alertify.alert('Respuesta', msg, function(){ });
                    agrega_nuevo_cliente_array(formData,resp.tablaCliente);
                }else{
                    alertify.alert('Respuesta', "Error al enviar datos", function(){ });
                }
            }
        });
    }else{alertify.error("Verifique los campos");}
}

const agrega_nuevo_cliente_array=(form,idNewCliente)=>{
    clientes.push({
        id_cli: idNewCliente,
        nombre: form.get("inputNombre"),
        apellido: form.get("inputApellido"),
        cedula: form.get("inputCed"),
    });
}

/******************************************** */
//Sección/boton/opción editar cliente
/** Acción editar datos personales de cliente */
const modalEdit=(data)=>{
  dat = data.split('|');
  $('#idCliente').val(dat[0]);
  $('#inputNombreC').val(dat[1]);
  $('#inputApeC').val(dat[2]);
  $('#inputCedC').val(dat[3]);
}

const update_cliente=()=>{
  var form = $('#form-ed');
  $.ajax({
    type: 'post',
    url: '../php/peticiones/edita_cliente.php',
    data: form.serialize(),
    success:function (response){
      $('#modalEdicion').modal('hide');
      if(response > 0){
          recarga_tabla();
          alertify.success("Editado con éxito");
      }else{
          alertify.error("Error al editar");
      }
    }
  });
}


const proceso_fecha=(fecha)=>{
    //Proceso para la fecha //Si no se ha seleccionado una fecha //crea un objeto con la fecha de hoy
    let d;
    if((fecha == "") || (fecha == null) ){
        d = new Date();
    }else{
        let vf = fecha.split('/');
        /*            año    mes           dia  */
        d = new Date(parseInt(vf[2]),parseInt(vf[0]-1),parseInt(vf[1]));

        /* formato de como está en el formulario */
        /*  mes    dia    año  */
    }
    return d;
}


/*
const diasEnmes=(mes,anio)=>{
    //Retorna cuanto dias tiene un mes
    return new Date(anio,mes,0).getDate();
}*/



//VERIFICA LOS NUEVOS DATOS CON LOS QUE YA ESTA EN EL ARREGLO DE DATOS
const verificaDatos=(objeto)=>{
  //PARA VERIFICAR DE QUE EL NUEVO CLIENTE NO ESTÉ REGISTRADO
  let busNom = clientes.findIndex(x => (x.nombre).toUpperCase() === (objeto.nom).toUpperCase());
  let busApe = clientes.findIndex(x => (x.apellido).toUpperCase() === (objeto.ape).toUpperCase());
  if((busNom !== -1) && (busApe !== -1)){
    return true;
  }else{
    return false;
  }
}

const delete_cliente=(datos)=>{
  //Para eliminar un cliente
  let x = datos.split('|');
  alertify.confirm('Eliminar','Va a eliminar a ' + x[1] + " " + x[2] +', se eliminaran todos sus datos </br></br>Desea Continuar?',function(){
    $.ajax({
      type: 'POST',
      url: '../php/creditos/eliminar_cliente.php',
      data: 'id=' + x[0],
      success:function(r){
        if(r > 0){
          recarga_tabla();
          alertify.success("Eliminado el cliente");
          clientes.splice(clientes.findIndex(x => x.id_cli == x[0]),1);
          console.log(clientes);
        }else{alertify.error("No se pudo eliminar");}
      }
    });

  },function(){alertify.error('Cancelado');}).set({transition:'zoom'}).show();
}


const abrePDF=(condicion)=>{
  let fecha = new Date();
  window.open('../php/pdf/creditosPDF.php?cond='+condicion+'&date='+fecha.toLocaleString('en-US'),'_blank');
}

const desglose_fecha=(id_cliente)=>{
  $(location).attr('href','../php/tablas/desglose_fecha.php?id='+id_cliente,'_blank');
}

/** Para validar formularios **/
const validacion=(form)=>{
    form.validate({
        rules:{
            inputNombre:{
                required: true
            },
            inputApellido: {
                required: true
            },
            monto:{
                required: true,
                min: 0
            },
            ped_nuevo: {
                required: true,
                min: 0.05
            },
            FnombrePP:{
                required: true,
            },
            FcantidadPP: {
                required: true,
                min: 1,
            },
            FcostoPP: {
                required: true,
                min: 0.05,
            },
            FprecioPP: {
                required: true,
                min: 0.05,
            },
        },
        messages:{
            inputNombre:{
                required: "Ingrese el nombre"
            },
            inputApellido:{
                required: "Ingrese el apellido"
            },
            monto:{
                required: "Monto inválido, inserte un cero si pretende agregar un monto en otro momento",
                min: "Monto inválido, es negativo"
            },
            ped_nuevo: {
                required: "Este campo necesita valores",
                min: "No hay nada para almacenar, debe ser mayor a cero",
            },
            FnombrePP: {
                required: "Este campo necesita valores"
            },
            FcantidadPP: {
                required: "Este campo necesita valores",
                min: "Debe ser mayor a cero"
            },
            FprecioPP: {
                required: "Este campo necesita valores",
                min: "Valor inválido"
            },
        }
    });
}
