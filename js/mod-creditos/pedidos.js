//PARA CARGAR EL FORMULARIO DE NUEVO PEDIDO PARA 'X' CLIENTE
const nuevoPedido=(id_cliente,id_cuenta)=>{
  if(($('#formuPedidoNuevo').css('display')) != 'block'){//si el formulario no está visible
    $('<div>').load('../php/formulario/pedido_nuevo.php',function()
    {
      //OCULTA LA IMAGENLOGO
      $('#maryIMG').hide('normal');
      //SI HAY OTROS FORMULARIO EN EL DIV, ENTONCES LO REMUEVE
      if(($('#formuAbono').css('display')) == 'block'){
        document.getElementById('formuAbono').remove();
        //$('#imagen2').preppend($(this).html());
      }
      if(($('#formuNuevoCliente').css('display')) == 'block'){
        document.getElementById('formuNuevoCliente').remove();
      }
      
      //CARGA LOS INPUTS
      $('#imagen2').append($(this).html());
      carga_nuevoP(id_cliente,id_cuenta);
    }).show('normal');
  }else{
    carga_nuevoP(id_cliente,id_cuenta);
  }
  
}

//PARA LA OPCIÓN DE NUEVOS PEDIDOS DE CRÉDITOS
band = false;
contP = 0;//Cuenta las veces que se carga el formulario de pedido nuevo
const carga_nuevoP=(id_cliente)=>{
  //carga el formulario de nuevo pedido de crédito
  if(contP > 0){
    document.getElementById('formNPC').reset();
    $('#bo tr').each(function(index,item){
      $(this).remove();
    });
    arregloObjeto.splice(arregloObjeto.forEach(function(v,i){return i;}));
    $('#ped_nuevo').val(0);
    $('#totalPP').html(0);
  }
  
  let v = clientes.filter(x => x.id_cli == id_cliente);
  //El arreglo 'clientes' se carga en el modulo "creditos.js"
      $('#idCuenta').val(v[0].id_cli);
      $('#nombreCliP').val(v[0].nombre);
      $('#apellidoCliP').val(v[0].apellido);
      $('#cedulaCliP').val(v[0].cedula);
      carga_formPP();
  contP++;
}


VmontoPP = 0;//Va sumando el costo de cada producto que se pide
arregloObjeto = [];//Va almacenando los productos que se van pidiendo
contPP = 0;//Va contando cuantos productos se van pidiendo
const carga_input=(datt)=>
{//Carga los campos de la ventana con los datos del producto que se encontró
	$('#FcodigoPP').val(datt['codigo']);
	$('#FnombrePP').val(datt['nombre'])
	$('#FcantidadPP').val('1');
	$('#FprecioPP').val(datt['precio']);
	$('#FcostoPP').val(calcularPP());

  document.getElementById("guardarPP").style.display = "block";
}

const camp_cod_NPP=()=>{
  //funcion para detectar cuando se ha puesto el cursor del mouse sobre el campo de insertar codigo de producto
	band = true;
	console.log("Estas dentro ");
	if(band == true){
		setInterval(product_pedido,1000);
	}
	this.addEventListener('keypress',function(event){
    //En caso de que se presione la tecla ENTER
		if((event.keyCode == 13) && (band == true)){
			validaPP();
		}
	});
  //
}

const fuera_codigo=()=>{
  //Detecta cuando el cursor del mouse sale del campo de insertar el código de producto
	console.log("Estas fuera ");
	band = false;
  $('#codigoPTP').val('');
	this.addEventListener('keypress',function(event){
		if((event.keyCode == 13) && (band == false)){
			console.log("nada");
		}
	});
}

//CARGA EN UN DIV LOS INPUT PARA CUANDO SE DESEE AGREGAR PRODUCTOS PEDIDOS DURANTE EL NUEVO PEDIDO
const carga_formPP=()=>{
  $('#tbo').load('../php/formulario/formPP.php');

    $('#FcostoPP').val(calcularPP());
    document.getElementById("agregarPP").style.display = "none";
}

//RECOGE PRECIO Y CANTIDAD DE PRODUCTO Y PONE EL RESULTADO EN TOTAL, PERO REDONDEADO
//SE LLAMA DESDE EL INPUT DE COSTO TOTAL EN EL FORMULARIO "formPP"
function calcularPP(){
  try{
      var x = parseFloat($('#FcantidadPP').val()) || 0;
      var y = parseFloat($('#FprecioPP').val()) || 0;
      //document.getElementById(txt_id).value = ((x*1000) * ((y/1000)*1000)/1000);
      $("#FcostoPP").val((((x * 1000) * (y * 1000)) / 1000) / 1000);
      //$(txt_id).val(calcularPP());
     return (((x * 1000) * ( y * 1000)) / 1000) / 1000;
  }catch(e){}
}

//BUSCA UN CODIGO Y RETORNA EL PRODUCTO QUE ENCONTRÓ
//LUEGO LLAMA A LA FUNCION DE CARGAR EL PRODUCTO EN EL FORMULARIO DE 'formPP'
var c = 0;
const product_pedido=()=>{
  let pp = $('#codigoPTP').val();
  if(pp != ""){
    $.ajax({
      type: 'POST',
      url: '../php/creditos/busca_producto.php',
      data: 'codigo=' + pp,
      success:function(r){
        datt = jQuery.parseJSON(r);
        if(datt != ""){
          carga_input(datt);
          $('#codigoPTP').val('');
        }
      }
    });
  }
}

//PARA EL MODAL DE AÑADIR PRODUCTOS PEDIDOS
const validaPP=()=>{
  //Valida de que los datos de producto se han insertado y añade este producto a la tabla de pedido
	//codigo = $('#FcodigoPP').val();
	nom = $('#FnombrePP').val();
	cant = $('#FcantidadPP').val();
	pre = $('#FprecioPP').val();
	cost = $('#FcostoPP').val();
	//if(codigo != undefined){
		if((nom != "") && (nom != undefined) && (nom != NaN)){
			if((cant != "") && (cant != undefined) && (cant != NaN)){
				if((pre != "") && (pre != undefined) && (pre != NaN)){
					if((cost != "") && (cost != undefined) && (cost != NaN)){
						var obj = { 
              nombre:nom, 
              cantidad: cant, 
              precio: parseFloat(pre), 
              costo: parseFloat(cost), 
              id_tr: contPP
						}
						arregloObjeto.push(obj);

            //Crea una nueva fila con los datos del producto
						var cadena ="<tr id='" + contPP + "'>" +
                          "<td></td>" +
                          "<td>" + obj.nombre + "</td>" +
                          "<td>" + obj.cantidad + "</td>" +
                          "<td>" + obj.precio + "</td>" +
                          "<td>" +obj.costo + "</td>" +
                          "<td><input type='checkbox' id='" + contPP + "'></td>" +
                        "</tr>";
						contPP++;
						//console.log(cost+ " "+VmontoPP);
						if(contPP > 0){
							VmontoPP = ((VmontoPP * 1000) + (obj.costo * 1000)) / 1000;
						}
            //Actualiza las cajitas donde se escribe los totales de pedido
						$('#ped_nuevo').val(VmontoPP);
            $('#totalPP').html(VmontoPP);
						//console.log(arregloObjeto);
						document.getElementById("agregarPP").style.display = "none";

            //Agrega la fila a la tabla
						document.getElementById("bo").innerHTML += cadena;
            //El botón de eliminar seleccionados se hace visible
						document.getElementById("deletePP").style.display = 'block';
            //Esta función actualiza los campos del formulario y los deja vacío
						borra_prodP();
						alertify.success("Correcto");
					}
				}
			}
		}
	//}
}

const borra_prodP=(i)=>{
    //Vacía el formulario donde se carga los datos del producto que se ha encontrado
    $('#FcodigoPP').val('');
    $('#FnombrePP').val('');
    $('#FcantidadPP').val('');
    $('#FprecioPP').val('');
    $('#FcostoPP').val('');
}

//ESTA FUNCIÓN ELIMINA DE LA TABLA-MODAL TODAS AQUELLAS FILAS DONDE ESTE SELECCIONADO EL CHECKBOX
const borra2=(i)=>{
	$('#bo').each(function(index,item){
		jQuery(':checkbox',this).each(function(){
			if($(this).is(':checked')){
        let x = $(this).attr('id');
          document.getElementById(x).remove();
          contPP--;
          arregloObjeto.splice(arregloObjeto.findIndex(y => y.id_tr == x),1);

          let mapa = arregloObjeto.map(y => y.costo);
          VmontoPP = mapa.reduce((sum,cost)=>{ return ((sum*1000) + (cost*1000))/1000},0);
          $('#ped_nuevo').val(VmontoPP);
          $('#totalPP').html(VmontoPP);
			}
		});
  });
}
const elimina=(v)=>{

  //console.log(v);
  arregloObjeto.splice(v,1);
}
const envia_nuevoPP=()=>{
  datosJson = JSON.stringify(arregloObjeto);
  
  //window.open('../practica_objetos.php?datos='+datosJson,'_blank');

	let montopnn = $('#ped_nuevo').val();//monto Pedido nuevo
	let idPN = $('#idCuenta').val();//id cuenta
  let coment = $('#comentario').val();

	if((idPN != -1) && (montopnn > 0)){
		let f = $('#fechaPN').val();
    let d = proceso_fecha(f);
    let fecha = d.getFullYear() + "/" + mess[d.getMonth()] + "/" + d.getDate();
    
    let objeto = {
      monto: montopnn, 
      idCuenta: idPN, 
      fecha: fecha, 
      diaS: fech[d.getDay()],
      mes: mess[d.getMonth()], 
      dia: d.getDate(),
      anio: d.getFullYear(), 
      comentario: coment,
      datos: datosJson
    }
    
    //console.log('id: ' + idPN + ' monto: ' + montopnn + ' fecha: ' + fecha);
    $.ajax({
      type: 'POST',
      url: '../php/creditos/nuevo_credito.php',
      data: objeto,
      success:function(r){
        if(r == 1){
          $('#formNPC')[0].reset();
          $('#bo tr').each(function(index,item){
            $(this).remove();
          });
          arregloObjeto.splice(arregloObjeto.forEach(function(v,i){return i;}));
          $('#ped_nuevo').val(0);
          $('#totalPP').html(0);
          VmontoPP = 0;
          console.log(arregloObjeto);
          carg_pag();
          $('#imagen2').html('<img src="../img/lgo.png" id="maryIMG">');
          alertify.success('Se ha agregado el nuevo credito');
        }else{alertify.error('No se pudo agregar el nuevo pedido');}
      }
    });
	}else{alertify.error("No hay nada para grabar");}
}


const cancelar_pedido=()=>{
  $('#formNPC')[0].reset();
	$('#imagen2').html('<img src="../img/lgo.png" id="maryIMG">');
  //Recorre la tabla y elimina todos los elementos
  $('#bo tr').each(function(index,item){
    $(this).remove();
  });
  //Elimina todos los productos del arreglo
  arregloObjeto.splice(arregloObjeto.forEach(function(i){return i;}));
  //Reinicia todo
  $('#ped_nuevo').val(0);
  $('#totalPP').html(0);
  VmontoPP = 0;
  contP = 0;
  console.log(arregloObjeto);
  //clientes.forEach(x => );
}