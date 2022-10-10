$(document).ready(function(){
	//para cargar el encabezado de la tabla
	let idCli = $('#idCli').val();
	let datos_cliente = busca_datos_id(idCli);
	if(datos_cliente != -1){
		carga_head_tabla(datos_cliente);
	}

	//configuraciones del dataTable
	cargaDataTable();

	//Botones pdf
	$('[data-action="loadPdf"]').off('click').on('click',function(){
		let val = $(this).data("val");
		abrePdf(val,idCli);
	});

	//boton pagar //para pagar una cuenta
	$('[data-action="payOrder"]').off('click').on('click',function(){
		let id = $(this).data("id");//id de fecha de pedido
		let val = $(this).data("val");//monto del pedido
		let id_cliente = $(this).data("cliente");//id de la cuenta

		pagar_pedido(id_cliente,id,val);
	});

});

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
            /*{
                extend: 'excelHtml5',
                titleAttr: 'Exportar a excel',
                className: 'far fa-file-excel btn btn-success btn-lg',
                exportOptions:{ columns: [0,1,2,3]}
            },
            {
                extend: 'pdfHtml5',titleAttr: 'Exportar a pdf',className: 'btn btn-primary',pageSize: 'Letter',
                oriented: 'potrait',
                exportOptions: {columns: [0,1,2,3,4,5,6]}
            },*/
        ]
    });
}

var x;
const busca_datos_id=(id)=>{
	//busca_cuenta_anterior y sus datos personales
	let response = -1;
	$.ajax({
		type: 'POST',
		url: '../peticiones/findCuentaAnterior.php',
		data: 'id=' + parseInt(id),
		async: false,
		cache: false,
		success:function(r){
			if((r != -1) && (r.length>0)){
				response = jQuery.parseJSON(r);
			}
		}
	});
	return response;
}

const carga_head_tabla=(datos)=>{
	let headTabla = document.getElementById('thead');
	let fila = document.createElement('tr');
		fila.id = "cuentaAnterior";
		fila = headTabla.insertRow(0);
		fila.className = 'borderTr'
		//fila.style.borderColor = "teal !important";


	let celda = fila.insertCell(0);
	let newText = document.createTextNode('CLIENTE');
		celda.appendChild(newText)

	for(var i = 1; i < datos.length; i++){
		let celda = fila.insertCell(i);
		let newText = document.createTextNode(datos[i-1]);
		celda.appendChild(newText);
	}

	celda = fila.insertCell(4);
	newText = document.createTextNode('Cuenta anterior');
	celda.appendChild(newText);

	celda = fila.insertCell(5);
	let band = false;
	if(datos[datos.length-1]){
		celda.appendChild(document.createTextNode(datos[datos.length-1]));
		band = true;
	}else{
		celda.appendChild(document.createTextNode("0"));
	}

	let btn = document.createElement('button');
		btn.innerHTML = 'Pagar';
		btn.className = 'btn btn-danger btn-sm';
		btn.addEventListener('click',(event)=>{
			console.log("hola");
		});

	if(!band){
		btn.disabled = true;
	}

	celda = fila.insertCell(6);
	celda.appendChild(btn);
}

const pagaCuentaAnterior=(id,monto,idCuenta)=>{
	alertify.confirm('PAGAR CUENTA ANTERIOR','Esta acción eliminar&aacute; la cuenta anterior',function(){
		/*$.ajax({
			type: 'POST',
			url: 'creditos/paga_cuenta_anterior.php',
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
		});*/
	},function(){alertify.error('Cancelado');}).set({transition:'zoom'}).show();
}

const pagar_pedido=(idCli,id_pedido,val)=>{
	alertify.confirm('Pagar un pedido','Se pagara sólo este pedido',function(){
		$.ajax({
			type: 'POST',
			url: '../peticiones/pagar_pedido.php',
			data: 'idCli='+idCli+'&id='+id_pedido+"&monto="+val,
			success: function(response){
				if(response.tabla_pedido==true){
					if(response.tabla_cuenta > 0){
						alertify.success("Pago correcto, se ha modificado la cuenta");
						$('#'+id).remove();
					}else{
						alertify.error("Pago correcto, NO se ha modificado la cuenta");
						$('#'+id).remove();
					}
				}else{
					alertify.error("Pago incorrecto, NO se ha modificado la cuenta");
				}
				console.log(response);
			},
			error: function(e){
				console.log(e.error);
			}
		});
	},function() {
		alertify.error('Cancelado');
	}).set({transition: 'zoom'}).show();
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
 	window.open('../pdf/desgloseFechasPDF.php?cond='+condicion+'&idC='+idC+'&date='+fecha.toLocaleString(),'_blank');
 }
