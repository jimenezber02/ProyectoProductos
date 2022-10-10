fech = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
mess = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
var swFocus, cont = 0, suma = 0;
const arregloPV = [];
$(document).ready(()=>{//Función principal
	carga_form_vacio();

	var onfocus = false;
	$('[data-action="findCodigo"]').off('focus').on('focus', function () {
		onfocus = true;
		loadFocus($(this),onfocus);
  });

	$('[data-action="findCodigo"]').off('blur').on('blur', function () {
		onfocus = false;
		loadFocus($(this),onfocus);
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
});//Fín de función principal


function carga_form_vacio(){
	$('<div>').load('../php/formulario/formPV.php',function(){
		$('#venta-form').append($(this).html());

		$('[data-action="saveProduct"]').off('click').on('click', function () {
			saveProduct();
	  });

		$('[data-action="reset"]').off('click').on('click', function () {
			resetForm();
	  });
	});
}

const resetForm=()=>{
	$('.form-label').attr('style','display: none !important');
	$('fv-plugins-message-container').attr('style','display: none !important');
}

function loadFocus(input_focus,onFocus){
	if(onFocus==true){
		swFocus = setInterval(()=>{
			let valFocus = $(input_focus).val();

			if(valFocus != ""){
				let datos = find_product(valFocus);
				if(datos != ""){
					datos.id_tr = carga_tabla(datos);
					arregloPV.push(datos);
					document.getElementById("venta").style.display = "block";
					actualizarSuma();
					cont++;
					$('#n-prod').html(cont);
				}
				$(input_focus).val('');
			}
		},500);
	}else{
		clearInterval(swFocus);
	}
}

function find_product(codigo){
	let datos = "";
	$.ajax({
		type: 'POST',
		url: '../php/peticiones/findProduct.php',
		data: 'productoCodigo=' + codigo,
		async: false,
		success:function(response){
			if(response != ""){
				datos = jQuery.parseJSON(response);
			}
		}
	});

	return datos;
}

function numero_aleatorio(){
	return Math.random() * (20 - 1) + 1;
}

function carga_tabla(datos){
	let id_fila = datos.codigo.concat(numero_aleatorio().toFixed(2).toString());

	let tabla = document.getElementById('bo');//Selecciona la tabla en la que vamos a trabajar
	let fila = document.createElement('tr');//Crea una fila
		fila = tabla.insertRow(0);//La inserta en la posición cero, o sea, va de primerito siempre
		fila.id = id_fila;//Añade un identificador a esa fila
	for (let i in datos) {
		//Crea 5 celdas por cada fila
		let celda = document.createElement("td");//Creando una celda
		let newText = document.createTextNode(datos[i]);//crea un texto para la celda
			celda.appendChild(newText);//Añade el texto a la celda
		fila.appendChild(celda);
	}
	let celda = fila.insertCell(5);//Crea otra celda
		celda.className = 'd-flex justify-content-around';

	let btn1 = document.createElement('BUTTON');//Crea un boton
		btn1.innerHTML = "Quitar";
		btn1.className = 'btn btn-danger btn-sm';
		btn1.addEventListener('click',(event)=>{
			quitar_item(id_fila);
		});
	celda.appendChild(btn1);

	let btn2 = document.createElement('BUTTON');
	btn2.innerHTML = 'Editar';
	btn2.className = 'btn btn-warning btn-sm';
	btn2.addEventListener('click',(event)=>{
		edita_un_item(id_fila);
	});
	celda.appendChild(btn2);

	return id_fila;
}

function actualizarSuma(){
	let costo = arregloPV.map(x => x.costo);
	suma = costo.reduce((sum,cost)=>{ return ((sum*1000) + (cost*1000))/1000},0);
    if(suma>0){
        document.getElementById("agregarCred").style.display = 'block';
    }else{
        document.getElementById("agregarCred").style.display = 'none';
    }
	$('#suma').val(suma);
	calculaPago();
}

function busca_producto_arreglo(id_tr){
	let posicion = arregloPV.findIndex(x => x.id_tr == id_tr.toString());

	return posicion;
}

function quitar_item(idT){//Recibe id de tabla
	document.getElementById(idT.toString()).remove();
	let pos = busca_producto_arreglo(idT);
	arregloPV.splice(pos,1);
	actualizarSuma();
	cont--;
	$('#n-prod').html(cont);
}

const edita_un_item=(idT)=>{
	//carga en el form los datos del producto
	let pos = busca_producto_arreglo(idT);

	$('.form-label').attr('style','display: block !important');
	$('input[name=idProdForm]').val(pos);
	$('input[name=idTr]').val(idT);
	$('input[name=FcodigoPV]').val(arregloPV[pos].codigo);
	$('input[name=FnombrePv]').val(arregloPV[pos].nombre);
	$('input[name=FcantidadPV]').val(arregloPV[pos].cantidad);
	$('input[name=FprecioPV]').val(arregloPV[pos].precio);
	$('input[name=FcostoPV]').val(arregloPV[pos].costo);
}
const edita_objeto_tabla=(form)=>{
    let pos = form.get("idProdForm");
    arregloPV[parseInt(pos)].cantidad = form.get("FcantidadPV");
    arregloPV[parseInt(pos)].precio = form.get("FprecioPV");
    arregloPV[parseInt(pos)].costo = form.get("FcostoPV");
}

const editar_fila_tabla=(id,formData)=>{
  $('#bo').each(function (){
      $('tr',this).each(function (index,item){
          if(this.id == id){
            var filita = `<tr id='${id}'>` +
                `<td>${formData.get("FcodigoPV")}</td>`+
                `<td>${formData.get("FnombrePv")}</td>`+
                `<td>${formData.get("FcantidadPV")}</td>`+
                `<td>${formData.get("FprecioPV")}</td>`+
                `<td>${formData.get("FcostoPV")}</td>`+
                `<td style="display: flex; justify-content: space-around;">`+
                    `<button class="btn btn-sm btn-danger" onclick="quitar_item('${id}');">
                        Quitar
                    </button>`+
										`<button class="btn btn-sm btn-warning" onclick="edita_un_item('${id}');">
                        Editar
                    </button>`+
                `</td>`+
            "</tr>";
            this.innerHTML = filita;
          }
      });
   });
}

const saveProduct=()=>{
	let formDatos = new FormData(document.getElementById("form_product_venta"));
	let id = formDatos.get("idTr");
	let form = $('#form_product_venta');
	valida(form);
	if(form.valid()){
		if(formDatos.get("idProdForm") == "-1"){
			let datos = creaObjetoFormToSave(formDatos);
			datos.id_tr = carga_tabla(datos);
			arregloPV.push(datos);
			document.getElementById("venta").style.display = "block";
			actualizarSuma();
			form[0].reset();
			cont++;
			$('#n-prod').html(cont);
		}else{
			editar_fila_tabla(id,formDatos);
			edita_objeto_tabla(formDatos);
			form[0].reset();
			actualizarSuma();
			resetForm();
		}
	}else{
		alertify.error("Formulario invalido");
	}
}

const creaObjetoFormToSave=(formData)=>{
	let objetoForm = {
		codigo: formData.get("FcodigoPV"),
		nombre: formData.get("FnombrePv"),
		cantidad: formData.get("FcantidadPV"),
		precio: formData.get("FprecioPV"),
		costo: formData.get("FcostoPV"),
	}
	return objetoForm
}

const valida=(form)=>{
	form.validate({
		rules:{
			FnombrePv:{
				required: true
			},
			FcantidadPV:{
				required: true,
				min: 1
			},
			FprecioPV:{
				required: true,
				min: 0.05
			},
			FcostoPV:{
				required: true,
				min: 0.05
			}
		},
		messages: {
			FnombrePv:{
				required: "Este campo requiere valor"
			},
			FcantidadPV:{
				required: "Este campo requiere valor",
				min: "Debe ingresar un valor"
			},
			FprecioPV:{
				required: "Este campo requiere valor",
				min: "Precio inválido"
			},
			FcostoPV:{
				required: "Este campo requiere valor",
				min: "costo inválido"
			}
		}
	});
}

function sumaDecimales(x,y){
	return ((x * 1000) + (y * 1000)) / 1000;
}

function calculaPago(){
	//Calcula para el pago y el saldo de la venta
	let x = $('#pago').val();
	let y = $('#suma').val();
	let resta = ((x * 1000 ) - (y * 1000)) / 1000;

	if(resta > 0){
		$('#cambio').val(resta);
		document.getElementById("agreSald").style.display = "block";
	}else{
		$('#cambio').val('');
		document.getElementById("agreSald").style.display = "none";
	}
	//return ((x*1000)/1000) - ((y * 1000)/1000);
}

function calculaPV(){
	//Para los campos que estan vacios al principio
	try{
		let x = $('#FcantidadPV').val() || 0;
		let y = $('#FprecioPV').val() || 0;

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
//const valida=(datos)=>{
  //Validación de los datos obtenidos del formulario
  /*if(datos.nom != ""){
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
}*/

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
