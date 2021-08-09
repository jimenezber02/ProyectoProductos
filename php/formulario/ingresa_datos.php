<?php 
    include("../conexion/conexion.php");
    $obj = new conexion();
    $conn = $obj -> conectar();

    $datos = "SELECT * FROM categoria_producto";
    $resultado = mysqli_query($conn,$datos);
?>
    <form action="#" id="formD" class="formD">
        <fieldset style="border: 1px dashed white;">
        <legend>DATOS DE PRODUCTO</legend>
        
        <input type="text" name="" id="idP" hidden="hidden" value="-1"><!--id de producto, solo cuando se va editar se toma en cuenta este campo-->
        <label for="">C&Oacute;DIGO</label>
            <input type="text" name="codigo" id="codigo">
        <label for="">Nombre</label>
            <input type="text" id="inputNombreP" class="form-control input-sm" required>
        
        <!--Descripcion-->
        <label style="color: white;">Descripci&oacute;n</label>
        <select class="form-control input-sm" name="descP" id="descP" required>
            <option value="">Seleccione</option>
            <option value="Unidad">Unidad</option>
            <option value="Libra">Libra</option>
        </select>
        
        <!--Categoria (libra,unidad) -->
        <label>Categor&iacute;a</label>
            <select class="form-control" name="cate" id="cate" required>
                <option value="">Seleccione</option>
                <?php 
                    while($j = mysqli_fetch_array($resultado)){
                        echo('<option value="'.$j['id'].'">'.$j['categoria'].'</option>');
                    }?>
            </select>
        
        <!--precio de producto-->
        <label>Ingrese Precio</label></br>
            <label>Balboas</label>
                <input type="number" name="dolar" id="dolar" maxlength="5" size="5" value="0" required>  
        <!--<button class="btn btn-danger" class="close" data-dismiss="modal" id="cerrarAD">Cerrar</button>-->

        <center>
            <button onclick="recoge_formu();" id="guardaPro" class="btn btn-success">Guardar</button>
        </center>
        </fieldset>
    </form>

  