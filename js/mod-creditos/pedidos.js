var swFocus = false;//vigila cuando se activa el evento focus en el modal de nuevo producto
var contFilas = 0;//cuenta las filas/productos que se van añadiendo
var productosPedidos = [];//Guarda los productos que se piden
var total = 0;//Suma cada costo de producto

/******* FUNCIÓN PRINCIPAL *******/
//script para pedidos nuevos
$(document).ready(function(){
  var onfocus = false;
  $('[data-action="loadFocus"]').off('focus').on('focus', function () {
		onfocus = true;
		loadFocus($(this),onfocus);
  });

  $('[data-action="loadFocus"]').off('blur').on('blur', function () {
		onfocus = false;
		loadFocus($(this),onfocus);
  });

  $('[data-action="addProductOrder"]').off('click').on('click', function () {
    let formData = new FormData(document.getElementById("form_product_modal_pedido_nuevo"));
    let id = formData.get("idTr");
    if(id == -1){
      saveNewProductOrder(formData);
    }else{
      editNewProductOrder(formData,id);
    }
  });

  $('[data-action="delete_prod_tabla"]').off('click').on('click', function () {
		eliminar_producto_tabla();
  });
});

/** ///SECCION PEDIDOS NUEVOS /// **/
/* ****************************  */
const pedidoNuevo=(id,idCuenta)=>{
    let mi_cliente = clientes.find(x => x.id_cli == id);
    //Carga en el aside a el formulario de nuevo pedido
    $('#aside-form-space').load('../php/formulario/pedido_nuevo.php',function (){
        eliminar_todos_tabla();
        productosPedidos.splice(0);
        actualiza_total();
        $('#idCuentaP').val(idCuenta);
        $('#nombreCliP').val(mi_cliente.nombre);
        $('#apellidoCliP').val(mi_cliente.apellido);
        $('#cedulaCliP').val(mi_cliente.cedula);

        $("#fechaPN").datepicker({showButtonPanel: true,changeMonth: true,changeYear: true,maxDate: "+0M +30D +0Y"});
        $('#btn_nuevoPedido').click(function(){
            recogeFormularioNuevoPedido();
        });
        $('#cancelarPedido').click(function (){
            cancelar();
        });
    });
}

const recogeFormularioNuevoPedido=()=>{
  var fecha = $('input[name=fechaPN]').val();
  var fechaObject = retornaObjetoFecha(fecha);

  var formData = new FormData(document.getElementById("formNPC"));
  formData.append('fecha',fechaObject.fecha_completa);
  formData.append('anio',fechaObject.anio);
  formData.append('dia',fechaObject.dia);
  formData.append('diaLetra',fechaObject.diaEnLetra);
  formData.append('mes',fechaObject.mes);

  actualiza_array_producto();
  let form = $('#formNPC');

  validacion(form);
  if(form.valid()){
    formData.append("productos", JSON.stringify(productosPedidos));
    $.ajax({
      type: 'POST',
      url: '../php/peticiones/nuevo_pedido.php',
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      withFile: false,
      success: function (response) {
        console.log(response);
        let resp = jQuery.parseJSON(response);
        if(response != -1){
            alertify.success("Nuevo pedido añadido correctamente");
            if(response==0){
              alertify.error("Error al actualizar la cuenta");
            }
            //Eliminar todos*
            eliminar_todos_tabla();
            productosPedidos.splice(0);
            actualiza_total();
            recarga_tabla();
        }else{alertify.error("Error al almacenar el pedido");}
      }
    });
  }else{alertify.error("Verifica los campos");}
}


/** Acción de ingresar producto/modal en nuevo pedido */
const loadFocus=(input_focus,onFocus)=>{
  if(onFocus==true){
    swFocus = setInterval(()=>{
        let valFocus = $(input_focus).val();

        if(valFocus != ""){
            let datos = findProduct(valFocus);
            if(datos != ""){
                datos.idtr = agrega_fila_a_tabla(datos);
                productosPedidos.push(datos);

                total = parseFloat(total) + parseFloat(datos.costo);
                $('#total').html(total.toFixed(2));
                $('input[name=ped_nuevo]').val(total.toFixed(2));
            }
            $(input_focus).val('');
        }
    },500);
	}else{
		clearInterval(swFocus);
	}
}

//busca producto por codigo, devuelve el objeto
const findProduct=(productCodigo)=>{
    let data = "";
    $.ajax({
       type: 'post',
       url: '../php/peticiones/findProduct.php',
       data: 'productoCodigo='+productCodigo,
        async: false,
       success: function (response) {
         if(response != ""){
          data = jQuery.parseJSON(response);
         }
       },
    });

    return data;
}

//formulario que está en el modal
const saveNewProductOrder=(formData)=>{
  let form = $('#form_product_modal_pedido_nuevo');
  validacion(form);
  if(form.valid()){
    let objetoP = {
        pos: formData.get("idProdForm"),
        codigo: formData.get("FcodigoPP"),
        nombre: formData.get("FnombrePP"),
        cantidad: formData.get("FcantidadPP"),
        precio: formData.get("FprecioPP"),
        costo: formData.get("FcostoPP"),
    }
    objetoP.idtr = agrega_fila_a_tabla(objetoP);
    productosPedidos.push(objetoP);
    actualiza_total();
  }else{
    alertify.error("Verifica los campos");
  }
}

//Para cuando se está editando los datos de un producto
//cuando se hace click en guardar en el formulario del modal de nuevo pedido
const editNewProductOrder=(form,id_tr)=>{
  let formTemp = $('#form_product_modal_pedido_nuevo');
  validacion(formTemp);
  if(formTemp.valid()){
    editar_fila_tabla_modal(id_tr,form);
    edita_objeto_tabla(form);
    actualiza_total();
    $(formTemp)[0].reset();
    $('.label_form_prod_nuevo').attr('style','margin:0;display: none !important');
  }else{
    alertify.error("Verifica los campos");
  }
}

const calcula_precio=()=>{
    try {
        let x = $('#FcantidadPP').val();
        let y = $('#FprecioPP').val();
        $('#FcostoPP').val((x*y).toFixed(2));

        return x * y;
    }catch (e){}
}

var filas = 0;
const agrega_fila_a_tabla =(data)=>{
    var tabla = document.querySelector("#body-tabla");
    let id_tr = "tr"+filas;
    var tr = document.createElement("tr");
    tr = tabla.insertRow(0);
    tr.id = id_tr;
      var celda = `<td>${data.codigo}</td>`+
          `<td>${data.nombre}</td>`+
          `<td>${data.cantidad}</td>`+
          `<td>${data.precio}</td>`+
          `<td>${data.costo}</td>`+
          `<td style="display: flex; justify-content: space-around;">`+
              `<input type='checkbox'>`+
              `<button data-idtr="tr${contFilas}" class="btn btn-sm btn-warning" onclick="cargaFormTablaModal('${id_tr}');">
                  Editar
                </button>`+
          `</td>`;
    tr.innerHTML += celda;
    filas++;
    contFilas++;
    $('#nProd').html(contFilas);//N° de productos

    return id_tr;
}

const reseFormNewOrder=()=>{
  $('.label_form_prod_nuevo').attr('style','margin:0;display: none !important');
}

const cargaFormTablaModal=(id_tr)=>{
  //para editar un producto que ya está en la tabla
  $('#codigoPP').show();
  $('.label_form_prod_nuevo').attr('style','margin:0;display: block !important');

  let pos = busca_posicion_array_prod_tabla(id_tr);
  $('#idProdForm').val(pos);
  $('#idTr').val(id_tr);
  $('#FcodigoPP').val(productosPedidos[parseInt(pos)].codigo),
  $('#FnombrePP').val(productosPedidos[parseInt(pos)].nombre);
  $('#FcantidadPP').val(productosPedidos[parseInt(pos)].cantidad);
  $('#FprecioPP').val(productosPedidos[parseInt(pos)].precio);
  $('#FcostoPP').val(productosPedidos[parseInt(pos)].precio);
}

const edita_objeto_tabla=(form)=>{
    let pos = form.get("idProdForm");
    productosPedidos[parseInt(pos)].cantidad = form.get("FcantidadPP");
    productosPedidos[parseInt(pos)].precio = form.get("FprecioPP");
    productosPedidos[parseInt(pos)].costo = form.get("FcostoPP");
}

const editar_fila_tabla_modal=(id,formData)=>{
  //TODO
  $('#body-tabla').each(function (){
      $('tr',this).each(function (index,item){
          if(this.id == id){
            var filita = `<tr id='${id}'>` +
                `<td>${formData.get("FcodigoPP")}</td>`+
                `<td>${formData.get("FnombrePP")}</td>`+
                `<td>${formData.get("FcantidadPP")}</td>`+
                `<td>${formData.get("FprecioPP")}</td>`+
                `<td>${formData.get("FcostoPP")}</td>`+
                `<td style="display: flex; justify-content: space-around;">`+
                    `<input type='checkbox'>`+
                    `<button data-idtr="tr${index}" class="btn btn-sm btn-warning" onclick="cargaFormTablaModal('tr${index}');">
                        Editar
                    </button>`+
                `</td>`+
            "</tr>";
            this.innerHTML = filita;
          }
      });
   });
}

const eliminar_producto_tabla=()=>{
  //Eliminar las filas que tengan el check activo
  $('#body-tabla').each(function (indice,elemento){
      $(':checkbox',this).each(function(index,item){
          if($(this).is(':checked')){
              let idFila = this.parentNode.parentNode.id;
              $(`#${idFila}`).remove();
              let pos = busca_posicion_array_prod_tabla(idFila);
              eliminar_elementos_array_productos(pos);
              actualiza_total();
              contFilas--;
          }
      });
  });
  $('#nProd').html(contFilas);
}

const eliminar_todos_tabla=()=>{
    $('#body-tabla').each(function (){
       $('tr',this).each(function (index,item){
         $(this).remove();
         contFilas--;
       });
    });
    $('#nProd').html(contFilas);
}

const eliminar_elementos_array_productos=(pos)=>{
    productosPedidos.splice(pos,1);
}

const busca_posicion_array_prod_tabla=(id_tr)=>{
    let pos = productosPedidos.findIndex(x=> x.idtr === id_tr);
    return pos;
}

const actualiza_total=()=>{
    if(productosPedidos.length > 0){
      let mapa = productosPedidos.map(elemento => elemento.costo);

      total = mapa.reduce((acumulador, monto)=>{
          return ((acumulador*1000) + (monto*1000))/1000;
      },0);
    }else{
      total = 0;
    }

    $('#total').html(total.toFixed(2));
    $('input[name=ped_nuevo]').val(total.toFixed(2));
}

const actualiza_array_producto=()=>{
  //actualiza antes de enviar
    productosPedidos.forEach((item,index)=>{
        delete item.idtr;
    });
}
