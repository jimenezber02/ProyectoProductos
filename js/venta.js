fech = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
mess = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

$(document).ready(()=>{//Función principal
	carga_form_vacio();

	var camp = document.querySelector("#codigoPV");
		//El campo donde se debe capturar el codigo de producto
		camp.addEventListener('focus',()=>{
			focusP();
		});
		camp.addEventListener('blur',()=>{
			console.log('fuera');
			$('codigoPV').val('');
		});

	//boton agregar a credito
	let btnAC = document.querySelector('#agregarCred');
		btnAC.addEventListener('click',()=>{
			agregarAcredito();
		});
	//boton agregar a saldo
	let btnAS = document.querySelector('#agreSald');
		btnAS.addEventListener('click',()=>{
			agregarAsaldo();
		});

	//boton añadir a lista
	let btnAL = document.querySelector('#anadirLista');
		btnAL.addEventListener('click',()=>{
			valida_anadir_A_lista();
		});
});//Fín de función principal

cont = 0, suma = 0;
function focusP(){//Funcion para cuando esta dentro de la caja de lectura de código de producto
	setInterval(auxiliar_de_focusP,2500);
		console.log("dentro");
}

function auxiliar_de_focusP(){
	var codigo = $('#codigoPV').val();
		if(codigo != ""){
			busca_producto(codigo);
		}
}


function busca_producto(codigo){
	$.ajax({
		type: 'POST',
		url: '../php/creditos/busca_producto.php',
		data: 'codigo=' + codigo,
		success:function(r){
			//console.log(r);
			let datos = jQuery.parseJSON(r);
			
			if(datos != ""){
				carga_tabla(datos);
				$('#codigoPV').val('');
			}
		}
	});
}

function numero_aleatorio(){
	return Math.random() * (20 - 1) + 1;
}

const arregloPV = [];
function carga_tabla(datos){
	//Vector temporal -> para añadirlos a la tabla
	let x = [datos.cod,datos.nombre,datos.cantidad,datos.precio,datos.costo];

	let id_fila = numero_aleatorio().toFixed(2).toString();
	//Vector global -> para almacenar todos los productos quese van vendiendo
	obj = {
		cod: datos.cod, 
		nombre: datos.nombre, 
		cantidad: datos.cantidad, 
		precio: parseFloat(datos.precio),
		costo: parseFloat(datos.costo),
		idPV: datos.cod.concat(id_fila)
	};
	//Agrega el objeto al arreglo de objeto
	arregloPV.push(obj);

	//console.log(arregloPV);
	let tabla = document.getElementById('bo');//Selecciona la tabla en la que vamos a trabajar
	let fila = document.createElement('tr');//Crea una fila
		fila = tabla.insertRow(0);//La inserta en la posición cero, osea, va de primerito siempre
		fila.id = datos.cod.concat(id_fila);//Añade un identificador a esa fila
	for(var i = 0; i < 5; i++){//Crea 5 celdas por cada fila
		let celda = fila.insertCell(i);//Creando una celda
		let newText = document.createTextNode(x[i]);//crea un texto para la celda
			celda.appendChild(newText);//Añade el texto a la celda
	}
	let celda = fila.insertCell(5);//Crea otra celda

	let btn1 = document.createElement('BUTTON');//Crea un boton
		btn1.innerHTML = "Quitar";
		btn1.id = cont.toString();
		btn1.className = 'btn btn-danger btn-sm';
		btn1.addEventListener('click',(event)=>{
			let idT = event.target.parentNode.parentElement.id;//id de la fila
			quitar_item(idT);
		});
	celda.appendChild(btn1)

	let btn2 = document.createElement('BUTTON');
	btn2.innerHTML = 'Editar';
	btn2.id = cont.toString();
	btn2.className = 'btn btn-warning btn-sm';
	btn2.addEventListener('click',(event)=>{
		edita_un_item();
	});
	
	let newText = document.createTextNode(" ");
		celda.appendChild(newText);
	celda.appendChild(btn2);

	let costo = arregloPV.map(x => x.costo);
	suma = costo.reduce((sum,cost)=>{ return ((sum*1000) + (cost*1000))/1000},0);
	cont++;
	document.getElementById("venta").style.display = "block";
	$('#suma').val(suma);
	calculaPago();
}

function quitar_item(idT){//Recibe id de tabla
	document.getElementById(idT.toString()).remove();
	arregloPV.splice(arregloPV.findIndex(x => x.idPV == idT.toString()),1);

	let costo = arregloPV.map(x => x.costo);
	let suma = costo.reduce((sum,cost) => { return ((sum*1000) + (cost*1000))/1000 },0);
	$('#suma').val(suma);
	cont--;
	
	calculaPago();
}

const edita_un_item=()=>{
	let idT = event.target.parentNode.parentElement.id;//id de la fila
	let ind = arregloPV.findIndex(x => x.idPV == idT.toString());

	$('#FcodigoPV').val(arregloPV[ind].cod);
	$('#FnombrePv').val(arregloPV[ind].nombre);
	$('#FprecioPV').val(arregloPV[ind].precio);
	$('#FcantidadPV').val(arregloPV[ind].cantidad);
	calculaPV();

	quitar_item(idT);
}

const valida_anadir_A_lista=()=>{
	let objeto = {
		cod: $('#FcodigoPV').val(),
		nombre: $('#FnombrePv').val(),
		cantidad: $('#FcantidadPV').val(),
		precio: $('#FprecioPV').val(),
		costo: $('#FcostoPV').val() 
	}
	if(objeto.nombre != ""){
		if(objeto.cantidad != ""){
			if(objeto.precio != ""){
				if(objeto.costo != ""){
					carga_tabla(objeto);
					$('#FcodigoPV').val('');
					$('#FnombrePv').val('');
					$('#FcantidadPV').val('');
					$('#FprecioPV').val('');
					$('#FcostoPV').val('') ;
				}else{alertify.error("Falta el costo del producto"); return false;}
			}else{alertify.error("Falta el precio del producto"); return false;}
		}else{alertify.error("Falta cantidad de  productos"); return false;}
	}else{alertify.error('Falta nombre de producto');return false;}
}

function carga_form_vacio(){
	$('<div>').load('../php/formulario/formPV.php',function(){
		$('#tbo').append($(this).html());
	});
}

function sumaDecimales(x,y){
	return ((x * 1000) + (y * 1000)) / 1000;
}

function calculaPago(){
	//Calcula para el pago y el saldo de la venta
	let x = parseFloat($('#pago').val());
	let y = parseFloat($('#suma').val());
	let resta = ((x * 1000 ) - (y * 1000)) / 1000;

	$('#cambio').val(resta);
	if(resta > 0){
		document.getElementById("agreSald").style.display = "block";
	}else{
		document.getElementById("agreSald").style.display = "none";
	}
	//return ((x*1000)/1000) - ((y * 1000)/1000);
}

function calculaPV(){
	//Para los campos que estan vacios al princio
	try{
		let x = parseFloat($('#FcantidadPV').val()) || 0;
		let y = parseFloat($('#FprecioPV').val()) || 0;

		$('#FcostoPV').val((((x * 1000 ) * (y * 1000)) / 1000)/1000);

		return ((((x * 1000 ) * (y * 1000)) / 1000)/1000);
	}catch(e){}
}

function agregarAcredito(){
	$('#div-modalAC').load('../php/tablas/agregarAcredito.php');

	let btn = document.querySelector('#selectCuentaCred');//boton guardar el credito a la cuenta seleccionada
	let btn2 = document.querySelector('#guardaClienteNuevo');//boton guardar nuevo cliente

	btn.addEventListener('click',(event)=>{
		let tagCuenta = document.getElementsByName('RadioCuenta');
		console.log("Me pinchaste");

		$('#table_agregarAcredito').each(function(index,item){
			jQuery(':radio',this).each(function(){
				if($(this).is(':checked')){
					console.log($(this).attr('id'));
				}
			});
		});
	});

	btn2.addEventListener('click',()=>{
		formulario();
	});
}

function agregarAsaldo(){
	$('#div-modalAS').load('../php/tablas/agregarAsaldo.php');
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

//RECOGE TODOS LOS DATOS DE FORMULARIO DE UN NUEVO CLIENTE
const formulario=()=>{//obtiene los datos del formulario de abrir cuenta
  let nombre = $('#inputNombreCN').val();
  let apellido = $('#inputApeCN').val();
  let cedula = $('#inputCedCN').val();
  let cuenta = 0;
  //Proceso para la fecha
  let d = new Date();
  let fecha_completa =  d.getFullYear() + "/" + mess[d.getMonth()] + "/" + d.getDate();

  let objeto = {
    nom: nombre, 
    ape: apellido, 
    ced: cedula,
	anio: d.getFullYear().toString(),
    dia: fech[d.getDay()], 
    mes: mess[d.getMonth()], 
    diaN: d.getDate(), 
    fecha: fecha_completa,
    comentario: ''  
	}
  //console.log(objeto);
  valida(objeto);
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
              $('#div-modalAC').load('../php/tablas/agregarAcredito.php');
              alertify.success("Datos enviados");
              $('#form-ACN')[0].reset();
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
