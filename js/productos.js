//SCRIPT para el módulo de productos

$(document).ready(function(){
    carg_pag();//carga la tabla con los productos
    $('[data-action="saveProduct"]').off('click').on('click', function () {
        let form = $('#formD');
        recoge_formu(form);
    });
    $('[data-action="editProduct"]').off('click').on('click', function () {
        let form = $('#form_editar_product');
        recoge_formu(form);
        $('#modalEditarProduct').modal('hide');
    });
});

const carg_pag=()=>{
    $('#data').load('../php/tablas/tabla_productos.php');
}


//Recoge los datos que están en el formulario
const recoge_formu=(form)=>{
    valida(form);
    if(form.valid()){
        envia_datos(form);
    }else {
      alertify.error('error de formulario');
    }
}

const envia_datos=(form)=>{//Agrega un nuevo producto a la base de datos
    //Envia los datos mediante ajax a php
    $.ajax({
        type: 'POST', url:'../php/peticiones/save_product.php',data:form.serialize(),
        success:function(r){
            if(r == 1){
                carg_pag();
                alertify.success("DATOS ENVIADOS");
                $(form)[0].reset();}
            else{alertify.error("ERROR AL ENVIAR DATOS");}
        }
    });
}

const abrepdf=()=>{
    let fecha = new Date();   
     window.open('../php/pdf/productosPDF.php?date='+fecha.toLocaleString('en-US'),'_blank');
}

//PARA EDITAR
const formEdit=(idPro)=>{//carga el formulario para modal de editar producto
    //recibe un id de productoy busca en la base de datos a ese producto y lo carga en el formulario
    //Esta función es llamada desde el boton "editar" en la tabla_productos en la carpeta tablas
    //formEdit();
    let datos;
    $.ajax({
        type: 'POST', url: '../php/peticiones/findProductById.php', data: 'idPro=' + idPro,
        success:function(r){
            datos = jQuery.parseJSON(r);
            cargaProductos(datos);
        }
    });
}

const cargaProductos=(datos)=>{
    $('#idP').val(datos['id']);
    $('#codigoPE').val(datos['codigo']);
    $('#inputNombrePE').val(datos['nombre']);
    $('#descPE').val(datos['descripcion']);
    $('#precioPE').val(datos['precio']);
    $('#itbmsPE').val(datos['itbms']);
    $('#catePE').val(datos['id_categoria']);
}



//ELIMINAR LOS DATOS
const eliminaDatos=(id)=>{
    //Esta función es llamada desde el boton "eliminar" en la tabla_productos en la carpeta tablas
    alertify.confirm('ELIMINAR DATO','Desea eliminar?',function(){
        //Peticion mediante ajax para eliminar un producto mediante su id
        $.ajax({
            type: 'POST', url: '../php/peticiones/delete_product.php', data: 'idP='+id,
            success:function(r){
                if(r==1){carg_pag();alertify.success("ELIMINADO CON EXITO");
                }else{alertify.error("NO SE PUDO ELIMINAR");}
            }
        });
    },function(){alertify.error('Cancel');}).set({transition:'zoom'}).show();
}


/** Accion cancelar **/
const cancelar = () => {
    $('#formD')[0].reset();
}


const valida=(form)=>{
  form.validate({
    rules:{
        nombre:{
            required: true
        },
      codigo:{
        required: true
      },
      descP:{
        required: true
      },
      precio:{
        required: true,
        min: 0.05
      },
      cate:{
        required: true
      }
      ,
      itbms:{
        required: true
      }
    },
    messages: {
        nombre:{
            required: "Ingrese el nombre"
        },
      codigo:{
        required: "Ingrese código"
      },
      descP:{
        required: 'Falta descripcion'
      },
      precio:{
        required: 'Falta el precio',
        min: 'Precio inválido'
      },
      cate:{
        required: 'Seleccione categoría'
      },
      itbms:{
        required: 'Seleccione ITBMS'
      }
    }
  });
}
