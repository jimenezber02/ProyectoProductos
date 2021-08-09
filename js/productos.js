//SCRIPT para el módulo de productos

$(document).ready(function(){
    carg_pag();//carga la tabla con los productos
    //cargaF();
});

const carg_pag=()=>{
    $('#data').load('../php/tablas/tabla_productos.php');
}

const formEdit=(idPro)=>{//carga el formulario para nuevo producto
    if(($('#formD').css('display')) != 'block'){
        $('<div>').load('../php/formulario/ingresa_datos.php',function(){
            $('#maryIMG').css('display','none');
            $('#imagen2').append($(this).html());
            buscaPro(idPro);
        });
    }else{
        buscaPro(idPro);
    }
}
const formAgregarPro=()=>{//carga el formulario para nuevo producto
    if(($('#formD').css('display')) != 'block'){
        $('<div>').load('../php/formulario/ingresa_datos.php',function(){
            $('#maryIMG').css('display','none');
            $('#imagen2').append($(this).html());
        });
    }else{
        $('#formD')[0].reset();
    }
}
//Recoge los datos que están en el formulario
const recoge_formu=()=>{
    /*Esta funcion es llamado directamente desde el boton "guardaPro" en el formulario "ingresa_datos.php" en la carpeta
    formulario en php*/
    //objetos con todos los datos del formulario
    const datos = {
        id: $('#idP').val(),
        codigo: $('#codigo').val(),
        nombre: $('#inputNombreP').val(),
        desc: $("#descP option:selected").html(),
        categoria: $("#cate option:selected").val(),
        precio: $("#dolar").val()
    }
    valida_form(datos);//se llama al método de validar el formulario
}

//VALIDACION DE FORMULARIO
const valida_form=(datos)=>{
    //valida los campos del formulario de producto
    if(datos.codigo != ""){
        if(datos.nombre != ""){
            if(datos.desc != "Seleccione"){
                if(datos.categoria != ""){
                    if(datos.id != '-1'){
                        edita_datos(datos);
                    }else{
                        envia_datos(datos);
                    }
                }else{alertify.error("SELECCIONE UNA CATEGORÍA");return false;}
            }else{alertify.error("SELECCIONE UNA DESCRIPCION");return false;}
        }else{
            alertify.error("INGRESE NOMBRE DE PRODUCTO");return false;
        }
    }else{
        alertify.error("INGRESE EL CODIGO");return false;
    }
}
const envia_datos=(cadena)=>{//Agrega un nuevo producto a la base de datos
    //alertify.confirm('ALMACENAR DATO','Desea Continuar?',function(){
        //Envia los datos mediante ajax a php 
        $.ajax({
            type: 'POST', url:'../php/productos/agregar/ingresa_datos.php',data:cadena,
            success:function(r){
                if(r == 1){
                    carg_pag(); 
                    alertify.success("DATOS ENVIADOS"); 
                    $('#formD')[0].reset();}
                else{alertify.error("ERROR AL ENVIAR DATOS");}
            }
        });

    //},function(){alertify.error('Cancel');}).set({transition:'zoom'}).show();
}

const abrepdf=()=>{
    let fecha = new Date();
    let date = (fecha.getDate())+'/'+(fecha.getMonth()+1)+'/'+fecha.getFullYear();
    window.open('../php/pdf/productos.php?date='+date,'_blank');
}

//PARA EDITAR
const buscaPro=(idProducto)=>{
//recibe un id de productoy busca en la base de datos a ese producto y lo carga en el formulario
//Esta función es llamada desde el boton "editar" en la tabla_productos en la carpeta tablas
    //formEdit();
    let datos;
    $.ajax({
        type: 'POST', url: '../php/productos/busca_product.php', data: 'idPro=' + idProducto,
        success:function(r){
            datos = jQuery.parseJSON(r);
            cargaProductos(datos);
        }
    });
}

const cargaProductos=(datos)=>{
    $('#idP').val(datos.id);
    $('#codigo').val(datos['codigo']);
    $('#inputNombreP').val(datos['nombre']);
    $('#descP').val(datos['descripcion']);
    $('#dolar').val(datos['precio']);
    $('#cate').val(datos['id_categoria']);
}

const edita_datos=(datos)=>{
//Esta función es llamada desde el boton guardaPro del formulario "ingresa_datos" en la carpeta "formulario" de php
    alertify.confirm('EDITAR DATO','Desea Continuar?',function(){
        //Envia los nuevos datos al archivo "edita datos.php" para guardar estos datos
        $.ajax({
            type: 'POST', url:'../php/productos/editar/edita_datos.php',data: datos,
            success:function(r){
                if(r == 1){
                    carg_pag();//Recarga la tabla 
                    $('#formD')[0].reset(); 
                    buscaPro(datos.id); 
                    alertify.success("DATOS EDITADOS");
                }
                else{alertify.error("ERROR AL EDITAR DATOS");}
            }
        });
    },function(){alertify.error('Cancel');}).set({transition:'zoom'}).show();
}


//ELIMINAR LOS DATOS
const eliminaDatos=(id)=>{
//Esta función es llamada desde el boton "eliminar" en la tabla_productos en la carpeta tablas
    //alertify.dialog('confirm').set({transition:'zoom',message:'Desea eliminar el dato ?'}).show();
    if(id > 0){
        alertify.confirm('ELIMINAR DATO','Desea eliminar?',function(){
            //Peticion mediante ajax para eliminar un producto mediante su id
            $.ajax({
                type: 'POST', url: '../php/productos/eliminar/EliminaDatos.php', data: 'idP='+id,
                success:function(r){
                    if(r==1){carg_pag();alertify.success("ELIMINADO CON EXITO");
                    }else{alertify.error("NO SE PUDO ELIMINAR");}
                }
            });
        },function(){alertify.error('Cancel');}).set({transition:'zoom'}).show();
    }else{
        alertify.confirm('ELIMINAR TODOS LOS PRODUCTOS','Desea Continuar?',function(){
            $.ajax({
                type: 'POST', url: '../php/productos/eliminar/EliminaDatos.php', data: 'idP='+id,
                success:function(r){
                    if(r==1){carg_pag();alertify.success("ELIMINADO CON EXITO");
                    }else{alertify.error("NO SE PUDO ELIMINAR");}
                }
            });
        },function(){alertify.error('Cancel');}).set({transition:'zoom'}).show();
    }
}