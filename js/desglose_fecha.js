$(document).ready(function(){
	//carga_tabla();
	
	busca_datos_id();//para cargar el encabezado de la tabla
	//carga_datos_tabla();
	busca_id_cuenta();//para buscar las fechas de pedidos asociado a la cuenta
	cargaDataTable();

	//obtiene id de cuenta para hacer el pdf
	var id_cuenta = $('#idCuenta').val();
	//Botones pdf
	$('#pdfTodos').click(function(){
		abrePdf('todos',id_cuenta);
	});
	$('#pdfPedRecientes').click(function(){
		abrePdf('RECIENTE',id_cuenta);
	});
	$('#pdfPedAnteriores').click(function(){
		abrePdf('ANTERIOR',id_cuenta);
	});
});

const carga_tabla=()=>{
	$('#data').load('../tablas/tabla_desglose_fecha.php');
}

const cargaDataTable=()=>{
	$('#datatableDF').DataTable({
        'language':{
            'lengthMenu': 'Mostrar _MENU_ registros',
            'info': 'Mostrando p&aacute;gina _PAGE_ de _PAGES_',
            'search': 'Buscar',
            'zeroRecords': 'NO HAY PEDIDOS RECIENTES',
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
            {
                extend: 'pdfHtml5',titleAttr: 'Exportar a pdf',className: 'btn btn-primary',pageSize: 'Letter',
                oriented: 'potrait',
                exportOptions: {columns: [0,1,2,3,4,5,6]}
            },
        ]
    });
}

var x;
const busca_datos_id=()=>{
	//para cargar el encabezado de la tabla con los datos del cliente
	let idCli = $('#idCli').val();

	$.ajax({
		type: 'POST',
		url: '../creditos/busca_cliente.php',
		data: 'id=' + parseInt(idCli),
		success:function(r){
			let datt = jQuery.parseJSON(r);
			x = [datt['id'],datt['nom'],datt['apellido'],datt['ced']];
			carga_head_tabla(x);
			//console.log(datt.length);
		}
	});
}

const carga_head_tabla=(datos)=>{
	let headTabla = document.getElementById('thead');
	let fila = document.createElement('tr');
		fila = headTabla.insertRow(0);
		fila.style.background = "teal";

	let celda = fila.insertCell(0);
	let newText = document.createTextNode('CLIENTE');
		celda.appendChild(newText);

	for(var i = 1; i < 4; i++){
		celda = fila.insertCell(i);
		newText = document.createTextNode(datos[i]);
		celda.appendChild(newText);
	}
	
	celda = fila.insertCell(4);
	newText = document.createTextNode('Cuenta anterior');
	celda.appendChild(newText);
	busca_cuenta_anterior(fila);
	
}

const busca_cuenta_anterior=(fila)=>{
	let idCuenta = $('#idCuenta').val();
	
	var valor = 0;
	$.ajax({
		type: 'POST',
		url: '../creditos/busca_cuenta_anterior.php',
		data: 'idC=' + idCuenta,
		success:function(r){
			if(r != -1){
				dat = jQuery.parseJSON(r);
				if(dat[0].length > 0){
					valor = dat.monto;
				}
			}
			
			let celda = fila.insertCell(5);
			//console.log("valor"+cuentaAnt);
			let newText = document.createTextNode(valor);
				celda.appendChild(newText);
			if(valor > 0){
				celda = fila.insertCell(6);
				let btn = document.createElement('BUTTON');
					btn.innerHTML = 'Pagar';
 					btn.className = 'btn btn-light btn-sm';
					btn.addEventListener('click',(event)=>{
 						pagaCuentaAnterior(dat.id,valor,idCuenta);
 					});
	 			celda.appendChild(btn);
			}
		}
	});

	return valor;
}
const pagaCuentaAnterior=(id,monto,idCuenta)=>{
	alertify.confirm('PAGAR CUENTA ANTERIOR','Esta acción eliminar&aacute; la cuenta anterior',function(){
		$.ajax({
			type: 'POST',
			url: '../creditos/paga_cuenta_anterior.php',
			data: 'idCuentaAnterior='+id + '&monto='+monto + '&idCuenta='+idCuenta,
			success:function(r){
				if(r > 0){
					$('#datatableDF thead tr').each(function(index,item){
						if(index == 0){
							$(this).remove();
						}
					});
					carga_head_tabla(x);
					alertify.success("Cuenta anterior pagada");
				}else{
					alertify.error('Error');
				}
			}
		});
	},function(){alertify.error('Cancelado');}).set({transition:'zoom'}).show();
}

var data_fechas = [];
const busca_id_cuenta=()=>{
	//para buscar las fechas de pedidos asociado a la cuenta
	//busca por medio de id_cuenta todas los pedidos asociados
 	let idCuenta = $('#idCuenta').val();
	console.log(idCuenta);
	$.ajax({
		type: 'POST',
		url: '../creditos/busca_todos_fechas_pedidos.php',
		data: 'idCuenta=' + idCuenta,
		success:function(r){
			data_fechas = jQuery.parseJSON(r);
			console.log(data_fechas);
			carga_cuerpo_tabla(data_fechas);
		}
	});
}

const carga_cuerpo_tabla=(datos)=>{
 	let x = 0;
	let tabla = $('#datatableDF').DataTable();
	let idCuenta = $('#idCuenta').val();

	for(const j in datos){
		let fila = document.createElement('tr');
	 		//fila = tabla.insertRow(x);
	 		fila.id = datos[x].id_ped;
	 		let v = [
	 				datos[x].diaS,
	 				datos[x].dia,
	 				datos[x].mes,
	 				datos[x].anio,
	 				datos[x].estado,
	 				datos[x].valor,
	 				datos[x].comentario
	 			];

 		for(let i = 0; i < v.length; i++){
			let celda = fila.insertCell(i);
			let newText = document.createTextNode(v[i]+" ");
				celda.appendChild(newText);
	 	}

	 	let celda = fila.insertCell(v.length);
	 	let btn = document.createElement('BUTTON');
 			btn.innerHTML = 'Pagar';
 			btn.className = 'btn btn-light btn-sm';
 			
 			btn.addEventListener('click',(event)=>{
 				let id_fecha = event.target.parentNode.parentElement.id;
 				valor = datos.filter(x => x.id_ped == id_fecha);

 				pagar_cuenta(id_fecha,valor[0].valor,idCuenta);
 			});
	 		celda.appendChild(btn);
	 	tabla.row.add(fila).draw(true);
	 	x++;
 	}
 }

 const pagar_cuenta=(id_fecha,monto,idCuenta)=>{
 	//recibe id de la fila. el id de fila es el mismo de la fecha de pedido
 	alertify.confirm('CANCELAR PEDIDO','Esta acción eliminará este pedido </br>Desea Continuar?',function(){
        //Envia los datos mediante ajax a php
        $.ajax({
        	type: 'POST',
        	url: '../creditos/pagaUnaCuenta.php',
        	data: 'idFecha=' + id_fecha + '&valor=' + monto + '&idCuenta=' + idCuenta,
        	success:function(r){
        		if(r > 0){
        			data_fechas.splice(data_fechas.findIndex(x => x.id_ped == id_fecha),1); 
        
        			eliminaFila(id_fecha);
        			console.log(data_fechas);
        			alertify.success('ok');
        		}
        	}
        });
    },function(){alertify.error('Cancelado');}).set({transition:'zoom'}).show();
 }

const eliminaFila=(i)=>{
	let tabla = $('#datatableDF').DataTable();
	$('#datatableDF tr').each(function(index,item){
		if($(this).attr('id') == i){
			tabla.row(item).remove().draw();
		}
	});
}
 const abrePdf=(condicion,idC)=>{
 	let fecha = new Date();

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
 	window.open('../pdf/desgloseFechasPDF.php?cond='+condicion+'&idC='+idC+'&date='+date,'_blank');
 }
