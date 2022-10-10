<?php
    include("../conexion/conexion.php");
    $obj = new conexion();
    $conn = $obj -> conectar();

    $datos = "SELECT * FROM categoria_producto";
    $resultado = mysqli_query($conn,$datos);
?>
  <!--onsubmit="return recoge_formu(this)"-->
    <form action="#" id="formD" class="formD">
        <div class="row">
          <div class="col">
            <legend class="d-flex justify-content-center">DATOS DE PRODUCTO</legend>
          </div>
        </div>
      <hr>
      <div class="row">
        <div class="col">
          <div class="form-outline">
            <input type="text" name="" id="idP" hidden="hidden" value="-1">
            <label for="codigo">C&Oacute;DIGO</label>
            <input type="text" class="form-control" name="codigo" id="codigo" data-validation="alphanumeric">
            <label id="codigo-error" class="error fv-plugins-message-container invalid-feedback"
               for="codigo"></label>
          </div>
        </div>
        <div class="col">
          <div class="form-outline">
            <label for="inputNombreP">Nombre</label>
            <input type="text" id="inputNombreP" class="form-control input-sm" name="nombre">
            <label id="inputNombreP-error" class="error fv-plugins-message-container invalid-feedback"
               for="inputNombreP"></label>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col">
          <div class="form-outline">
            <label style="color: white;">Descripci&oacute;n</label>
            <select class="form-control input-sm" name="descP" id="descP">
                <option value="">Seleccione</option>
                <option value="Unidad">Unidad</option>
                <option value="Libra">Libra</option>
            </select>
            <label id="descP-error" class="error fv-plugins-message-container invalid-feedback"
               for="descP"></label>
          </div>
        </div>
        <div class="col">
          <div class="form-outline">
            <label>Categor&iacute;a</label>
            <select class="form-control" name="cate" id="cate">
                <option value="">Seleccione</option>
                <?php
                  while($j = mysqli_fetch_array($resultado)){
                    echo('<option value="'.$j['id'].'">'.$j['categoria'].'</option>');
                }?>
            </select>
            <label id="cate-error" class="error fv-plugins-message-container invalid-feedback"
               for="cate"></label>
          </div>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col d-flex justify-content-center">
          <div class="form-outline">
            <label>Precio</label>
            <input type="number" name="precio" id="precio" class="form-control" value="0" maxlength="5" step="0.01">
            <label id="precio-error" class="precio fv-plugins-message-container invalid-feedback"
               for="precio"></label>
          </div>
        </div>
        <div class="col">
          <div class="form-outline">
            <label style="color: white;">ITBMS</label>
            <select class="form-control input-sm" name="itbms" id="itbms">
                <option value="0">Ninguno</option>
                <option value="7">7%</option>
                <option value="15">15%</option>
            </select>
            <label id="itbms-error" class="error fv-plugins-message-container invalid-feedback"
               for="itbms"></label>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col d-flex justify-content-around">
          <button type="button" onclick="recoge_formu(this);" class="btn btn-success" data-option="-1"
          name="button" id="guardaPro" onsubmit="return false;">
            Guardar
          </button>
          <button type="button" class="btn btn-danger" name="button" onclick="cancelar();">
            Cancelar
          </button>
        </div>
      </div>
    </form>
