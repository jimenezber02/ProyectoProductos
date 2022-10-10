//FUNCION PRINCIPAL
$(document).ready(function(){
	buscaSaldo();
	busca_clientes();
	dataTable();
	//PARA CARGAR EL FORMULARIO DE NUEVO CLIENTE
	$('#newClienteSaldo').click(function(){
		//$('#cajaform').load('../php/formulario/nuevo_cliente_saldo.php');
		if(($('#div-nuevoCliente').css('display')) != 'block'){
			$('<div>').load('../php/formulario/nuevo_cliente_saldo.php',function(){
				if(($('#maryIMG').css('display')) == 'inline'){
					$('#maryIMG').hide('normal');
				}
				$('#cajaform').append($(this).html());
			});
		}else{
			$('#formNCS')[0].reset();
		}
	});
	
});//FIN DE FUNCIÓN PRINCIPAL



const cargaFormuCliente=(idCliente)=>{
	if(($('#div-nuevoCliente').css('display')) != 'block'){
		$('<div>').load('../php/formulario/nuevo_cliente_saldo.php',function(){
			if(($('#maryIMG').css('display')) == 'inline'){
				$('#maryIMG').hide('normal');
			}
			$('#cajaform').append($(this).html());
			editaCuentaSaldo(idCliente);
		}).show('normal');
	}else{
		editaCuentaSaldo(idCliente);
	}
}

const dataTable=()=>{
	$('#datatableSA').DataTable({
        'language':{
            'lengthMenu': 'Mostrar _MENU_ registros',
            'info': 'Mostrando p&aacute;gina _PAGE_ de _PAGES_',
            'search': 'Buscar',
            'zeroRecords': 'NO HAY DATOS',
            'paginate':{
                'first': 'Primero',
                'last': 'Anterior',
                'next': 'Siguiente',
                'previous': 'Anterior',
            }
        },
        responsive: 'true',
        dom: 'Bfrtilp',
        buttons:[
            {
                extend: 'excelHtml5',
                titleAttr: 'Exportar a excel',
                className: 'far fa-file-excel btn btn-success btn-lg',
                exportOptions:{ columns: [0,1,2,3]}
            },
        ]
    });
}
var clientes;
const busca_clientes=()=>{
	//CARGA EN UN ARREGLO TODOS LOS CLIENTES REGISTRADOS
	$.ajax({
		type: 'POST',
		url: '../php/creditos/retorna_cuentas.php',
		date: null,
		success:function(r){
			clientes = jQuery.parseJSON(r);
			console.log(clientes);
			cargaTabla();
		}
	});
}
var saldos = [];
const buscaSaldo=()=>{
	$.ajax({
		type: 'POST',
		url: '../php/saldos/obtieneSaldos.php',
		data: null,
		success:function(r){
			dat = jQuery.parseJSON(r);
			for(let i in dat){
				saldos.push(dat[i]);
			}
			console.log(saldos);
		}
	});
	//return saldo;
}

const verificaDatos=(objeto)=>{
	//PARA VERIFICAR DE QUE EL NUEVO CLIENTE NO ESTÉ REGISTRADO
	let busNom = clientes.findIndex(x => (x.nombre).toUpperCase() == (objeto.nombre).toUpperCase());
	let busApe = clientes.findIndex(x => (x.apellido).toUpperCase() == (objeto.apellido).toUpperCase());
	if((busNom != -1) && (busApe != -1)){
		return true;
	}else{
		return false;
	}
}

const obtienFormNewCliente=()=>{
	//OBTIENE LOS DATOS DEL FORMULARIO DE NUEVO CLIENTE
	//let fech = procesoFecha();
	let objeto = {
		id_cli: $('#idCuentaS').val(),
		nombre: $('#nombreCliS').val(),
		apellido: $('#apellidoCliS').val(),
		cedula: $('#cedulaCliS').val(),
		montoSaldo: $('#monto_saldo').val(),
		//fecha: fech.getFullYear() + "/" + (fech.getMonth() + 1) + "/" + fech.getDate()	
	}
	validaFormNewCli(objeto);
}

const validaFormNewCli=(objeto)=>{
	//VALIDA LOS CAMPOS DEL FORMULARIO DE NUEVO CLIENTE
	if(objeto.nombre != ""){
		if(objeto.apellido != ""){
			if(objeto.id_cli == -1){
				let verifica = verificaDatos(objeto);
				if(verifica == true){
					alertify.error('Ya está registrado el cliente');
				}else{
					registraDatos(objeto);
				}
			}else{
				editaDatos(objeto);
			}
		}else{
			alertify.error('Falta apellido');
			return false;
		}
	}else{
		alertify.error('Falta nombre');
		return false;
	}
}

const registraDatos=(objeto)=>{
	$.ajax({
		type: 'POST',
		url: '../php/saldos/agregaCuentaSaldo.php',
		data: objeto,
		success:function(r){
			if(r > 0){
				$('#formNCS')[0].reset();
				objeto.id_cli = r;
				clientes.push(objeto);
				let nuevoObjeto = {
					id: clientes.length + 1, saldo: objeto.montoSaldo, idCliente: r
				}
				saldos.push(nuevoObjeto);
		
				actualizaTabla(objeto);
				alertify.success("SE HA REGISTRADO");
			}
			else{
				alertify.error("ERROR");
				return false;
			}
		}
	});
}

const cargaTabla=()=>{
	let x = 0;
	for(let j in clientes){
		actualizaTabla(clientes[x]);
		x++;
	}
	
}

const eliminaFila=(i)=>{
	let tabla = $('#datatableSA').DataTable();
	$('#datatableSA tr').each(function(index,item){
		if($(this).attr('id') == i){
			tabla.row(item).remove().draw();
		}
	});
}

const buscaSaldoCliente=(idCuenta)=>{
	let miSaldo = 0;
		let aux = saldos.findIndex(x => x.idCliente == idCuenta);
	if(aux != -1){
		miSaldo = saldos[aux].saldo;
	}
	return miSaldo;
}

const actualizaTabla=(objeto)=>{
	let tabla = $('#datatableSA').DataTable();
	let fila = document.createElement('tr');
		fila.id = objeto.id_cli;
	let aux = [objeto.nombre, objeto.apellido, objeto.cedula, buscaSaldoCliente(objeto.id_cli)];
	for(var i = 0; i < 4; i++){
		let celda = fila.insertCell(i);
		let newText = document.createTextNode(aux[i]);
			celda.appendChild(newText);
	}
	let celda = fila.insertCell(aux.length);
		let boton = document.createElement('BUTTON');
			let span = document.createElement('span');
				span.className = 'fa fa-trash';
			boton.innerHTML = 'Eliminar';
			boton.className = 'btn btn-danger btn-sm';
			boton.appendChild(span);
			boton.addEventListener('click',function(event){
				console.log(event.target);
				let idCuenta = event.target.parentNode.parentElement.id;
				eliminaSaldoCliente(idCuenta);

			});
		celda.appendChild(boton);
		let boton2 = document.createElement('BUTTON');
			span = document.createElement('span');
				span.className = 'fa fa-pencil-alt';
			boton2.innerHTML = 'Editar';
			boton2.className = 'btn btn-warning btn-sm';
			boton2.appendChild(span);
			boton2.addEventListener('click',function(event){
				//$('#cajaform').load('../php/formulario/nuevo_cliente_saldo.php');
				let id = event.target.parentNode.parentElement.id;
				cargaFormuCliente(id);
			});
		celda.appendChild(boton2);
	tabla.row.add(fila).draw(true);
}

const editaCuentaSaldo=(idCliente)=>{
	let v = clientes.filter(x => x.id_cli == idCliente);

	$('#idCuentaS').val(v[0].id_cli);
	$('#nombreCliS').val(v[0].nombre);
	$('#apellidoCliS').val(v[0].apellido);
	$('#cedulaCliS').val(v.cedula);
	$('#monto_saldo').val(buscaSaldoCliente(v[0].id_cli));
}

const editaDatos=(objeto)=>{
	//let cliente = clientes.filter(x => x.id_cli == objeto.id);
	$.ajax({
		type: 'POST',
		url: '../php/saldos/editaCuentaSaldo.php',
		data: objeto,
		success:function(r){
			if(r > 0){
				eliminaFila(objeto.id_cli);
				clientes.splice(clientes.findIndex(x => x.id_cli == objeto.id_cli),1);
				clientes.push(objeto);
				let nuevoObjeto = {
					id: clientes.length + 1, saldo: objeto.montoSaldo, idCliente: objeto.id_cli
				}
	
				saldos.splice(saldos.findIndex(x => x.idCliente == objeto.id_cli),1);
				saldos.push(nuevoObjeto);
		
				editaCuentaSaldo(objeto.id_cli);
				actualizaTabla(objeto);
				alertify.success("Editado");
			}else{alertify.error("ERROR");}
		}
	});
}

const eliminaSaldoCliente=(idCliente)=>{
	let cliente = clientes.filter(x => x.id_cli == idCliente);
	let nombre = cliente[0].nombre + ' ' + cliente[0].apellido;

	alertify.confirm('Eliminar','Eliminar a '+ nombre + '</br>Desea Continuar ?',function(){
		$.ajax({
			type: 'POST',
			url: '../php/creditos/eliminar_cliente.php',
			data: 'id=' + idCliente,
			success:function(r){
				console.log(r);
				if(r > 0){
					eliminaFila(idCliente);
					clientes.splice(clientes.findIndex(x => x.id_cli == idCliente),1);
					saldos.splice(saldos.findIndex(x => x.idCliente == idCliente),1);
					alertify.success("Eliminado correctamente");
				}else{alertify.error("ERROR AL ELIMINR");}
			}
		});
	},function(){alertify.error('Cancelado');}).set({transition: 'zoom'}).show();
}

const cancelarForm=()=>{
	//$('#formNCS')[0].reset();
	$('#div-nuevoCliente').hide('normal');
	$('#cajaform').html('<img src="../img/lgo.png" id="maryIMG" />').show('normal');
	
	//$('#cajaform').preppend('#div-nuevoCliente');
	//$('#maryIMG').show('normal');
}

const procesoFecha=()=>{
	let fecha = $('#fechaSaldo').val();
	if(fecha == ""){
		fecha = new Date();
	}else{
		let v = fecha.split('-');
		fecha = new Date(v[0],v[1]-1,v[2]);
	}

	return fecha;
}

const abrePdf=(cond)=>{
	let fecha = new Date();
	console.log(fecha.getHours()+':'+fecha.getMinutes());
	let hora;
	let minute; 
	if(fecha.getHours() < 10){
		hora = "0" + fecha.getHours()+':';
		if(fecha.getMinutes() < 10){
		  minute = "0" + fecha.getMinutes();
		}else{
		  minute = fecha.getMinutes();
		}
		hora += minute;
	}
	else{
		hora = fecha.getHours()+':';
		if(fecha.getMinutes() < 10){
		  minute = "0" + fecha.getMinutes();
		}else{
		  minute = fecha.getMinutes();
		}
		hora += minute;
	}
	let band = 0;
	let date = (fecha.getDate())+'/'+(fecha.getMonth()+1)+'/'+fecha.getFullYear() + '    Hora: ' + hora;
	window.open('../php/pdf/saldosPDF.php?cond='+cond+'&date='+date,'_blank');
}