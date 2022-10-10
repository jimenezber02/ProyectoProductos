
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Productos</title>
    <?php include("dependencias.php"); ?>

    <script src="../js/productos.js?415263798" type="text/javascript"></script>

    <script type="text/javascript" src="../librerias/alertifyjs/alertify.min.js"></script>



</head>
<?php
    require_once('controller/categoriaProductController.php');
?>
<body>
    <div class="content">
        <header class="menu">
            <div class="logo"><img src="../img/vender.png" alt="" class="logo"><a href="#">Kiosko</a></div>
            <nav class="nav">
                <a href="../index.html" class="productos"><i class="bi bi-house-fill"></i> Inicio</a>
                <a href="#" class="productos"><i class="bi bi-cart4"></i> Productos</a>
                <a href="modulo_creditos.php" class="productos"><i class="bi bi-cash-coin"></i> Cuentas por cobrar</a>
                <a href="modulo_saldos.php" class="productos"><i class="bi bi-wallet-fill"></i> Saldos</a>
            </nav>
        </header>

        <section class="section">
            <article>
                <div id="data" class="data">...</div>
            </article>

        </section>

        <aside class="aside">
            <div class="asideH">
                <div class="imagen"><h2><center>KIOSKO</center></h2></div>
            </div>
            <div class="asideH">
                <div id="aside-form-space" class="imagen2">
                    <!--formulario-->
                    
                    <!--onsubmit="return recoge_formu(this)"-->
                    <form action="#" id="formD" class="formD">
                        <div class="row">
                        <div class="col">
                            <legend class="d-flex justify-content-center">REGISTRAR NUEVO PRODUCTO</legend>
                        </div>
                        </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                        <div class="form-outline">
                            <input type="text" name="id" id="id" hidden="hidden" value="-1">
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
                                <option value="Docena">Docena</option>
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
                                    foreach($categorias["categorias"] as $key => $value){
                                        echo "<option value=".$value[0].">".$value[1]."</option>";
                                    }
                                ?>
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
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                            </select>
                            <label id="itbms-error" class="error fv-plugins-message-container invalid-feedback"
                            for="itbms"></label>
                        </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col d-flex justify-content-around">
                        <button type="button" class="btn btn-success" data-action="saveProduct"
                        name="button" id="guardaPro" onsubmit="return false;">
                            Guardar
                        </button>
                        <button type="button" class="btn btn-danger" name="button" onclick="cancelar();">
                            Cancelar
                        </button>
                        </div>
                    </div>
                    </form>
                </div>

            </div>
        </aside>


        <footer class="footer"><p><i class="">Santiago, Veraguas</i><i class=""></i></p></footer>
    </div>
</body>
</html>
<!--MODAL EDITAR -->
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="modalEditarProduct" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Producto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- ... -->
        <!--onsubmit="return recoge_formu(this)"-->
        <form action="#" id="form_editar_product" class="formD">
          
        <div class="row">
            <div class="col">
            <div class="form-outline">
                <input type="text" name="id" id="idP" hidden>
                <label for="codigo">C&Oacute;DIGO</label>
                <input type="text" class="form-control" name="codigo" id="codigoPE" data-validation="alphanumeric">
                <label id="codigo-error" class="error fv-plugins-message-container invalid-feedback"
                for="codigo"></label>
            </div>
            </div>
            <div class="col">
            <div class="form-outline">
                <label for="inputNombrePE">Nombre</label>
                <input type="text" id="inputNombrePE" class="form-control input-sm" name="nombre">
                <label id="inputNombreP-error" class="error fv-plugins-message-container invalid-feedback"
                for="inputNombreP"></label>
            </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
            <div class="form-outline">
                <label style="color: white;">Descripci&oacute;n</label>
                <select class="form-control input-sm" name="descP" id="descPE">
                    <option value="">Seleccione</option>
                    <option value="Unidad">Unidad</option>
                    <option value="Libra">Libra</option>
                    <option value="Docena">Docena</option>
                </select>
                <label id="descP-error" class="error fv-plugins-message-container invalid-feedback"
                for="descP"></label>
            </div>
            </div>
            <div class="col">
            <div class="form-outline">
                <label>Categor&iacute;a</label>
                <select class="form-control" name="cate" id="catePE">
                    <option value="">Seleccione</option>
                    <?php
                        foreach($categorias["categorias"] as $key => $value){
                            echo "<option value=".$value[0].">".$value[1]."</option>";
                        }
                    ?>
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
                <input type="number" name="precio" id="precioPE" class="form-control" value="0" maxlength="5" step="0.01">
                <label id="precio-error" class="precio fv-plugins-message-container invalid-feedback"
                for="precio"></label>
            </div>
            </div>
            <div class="col">
            <div class="form-outline">
                <label style="color: white;">ITBMS</label>
                <select class="form-control input-sm" name="itbms" id="itbmsPE">
                    <option value="0">Ninguno</option>
                    <option value="7">7%</option>
                    <option value="10">10%</option>
                    <option value="15">15%</option>
                </select>
                <label id="itbms-error" class="error fv-plugins-message-container invalid-feedback"
                for="itbms"></label>
            </div>
            </div>
        </div>
        </form>
        <!--...-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" data-action="editProduct" onsubmit="return false;">Guardar</button>
      </div>
    </div>
  </div>
</div>
