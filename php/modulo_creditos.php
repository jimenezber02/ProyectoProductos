<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../librerias/icons-1.8.3/font/bootstrap-icons.css">
    <?php include("dependencias.php") ?>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>-->

    <script src="../librerias/alertifyjs/alertify.min.js"></script>
    <script src="../js/mod-creditos/creditos.js?v=91283645" type="text/javascript"></script>
    <script src="../js/mod-creditos/pedidos.js?v=7612534" type="text/javascript"></script>
    <script src="../js/mod-creditos/abonos.js?9182736" type="text/javascript"></script>
    <title>Cuentas por cobrar </title>
</head>
<body>

    <div class="content">
        <header class="menu">
            <div class="logo"><img src="../img/vender.png" alt="" class="logo"><a href="#">Kiosko</a></div>
            <nav class="nav">
                <a href="../index.html">Inicio <i class="bi bi-house-door-fill"></i></a>
                <a href="modulo_productos.php">Datos de productos <i class="bi bi-cart-fill"></i></a>
                <a href="#">Cuentas por cobrar <i class="bi bi-cash-coin"></i></a>
                <a href="modulo_saldos.php">Bonos/Saldos <i class="bi bi-wallet-fill"></i></a>
            </nav>
        </header>

        <section class="section">
            <article>
                <center><h3>CUENTA DE CREDITOS</h3></center>
                <div id ="data" class="data">
                  Cargando datos...
                </div>
            </article>

        </section>

        <aside id="aside" class="aside">
            <div class="asideH">
                <div class="imagen" id="imagen">
                    <h2><center>Kiosko</center></h2>
                </div>
            </div>
            <div class="asideH">
                <div class="imagen2" id="aside-form-space">
                    <img src="../img/vender.png" id="IMG" alt="">
                </div>
            </div>
        </aside>

        <footer class="footer"><p><i class="">Santiago, Veraguas</i><i class=""></i></p></footer>
    </div>
</body>


</html>

<!--Aqui van los modals-->
<!--Modal de editar-->

<div class="container">
    <div class="row">
        <div class="col">
            <div class="modal" id="modalEdicion" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div id="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                <center><h3 class="modal-tittle">Datoss personales</h3></center>
                                <div class="modal-body">
                                  <form method="POST" action="#" id="form-ed">
                                      <input type="text" hidden="" name="idCliente" id="idCliente">
                                      <label style="color: blue;">Nombre Cliente</label>
                                      <input type="text" id="inputNombreC" class="form-control input-sm" placeholder="Nombre de cliente"
                                             name="inputNombreC" autofocus>

                                      <label style="color: blue;">Apellido</label>
                                      <input type="text" id="inputApeC" class="form-control input-sm" placeholder="Apellido" name="inputApe">

                                      <label style="color: blue;">C&eacute;dula</label>
                                      <input type="tex" id="inputCedC" class="form-control input-sm" placeholder="C&eacute;dula" name="inputCed">

                                  </form><!--cierra form-->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button id="guardaCliEdit" onclick="update_cliente();" class="btn btn-warning" type="button">Actualizar Datos</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal productos / en formulario de nuevo pedido -->
<div class="container">
    <div class="row">
        <div class="col">
            <div class="modal modal-fullscreen-lg" id="modalP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-creditos" role="document">
                    <div class="modal-content">
                        <div id="modal-header">
                            <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h3 class="modal-tittle" style="color: red;">A&ntilde;adir productos</h3></center>
                            <div class="modal-body d-flex flex-column">
                                <input type="text" name="idPP" id="idPP" hidden value="-1">
                                <div>
                                    <label for="codigoPP">
                                        C&oacute;digo producto
                                    </label></br>
                                    <div class="float-left mb-2">
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" name="focus_codigo" class="form-control sm" id="focus_codigo"
                                                       placeholder="Ingresa codigo" data-action="loadFocus">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <form action="#" id="form_product_modal_pedido_nuevo">
                                    <div class="row">
                                        <input type="text" name="idTr" id="idTr" hidden value="-1">
                                        <input type="text" name="idProdForm" id="idProdForm" hidden value="-1">
                                        <div class="col" id="codigoPP" style="display:none;">
                                            <div class="form-outline">
                                                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1">Código</label>
                                                <input type="text" name="FcodigoPP" id="FcodigoPP" class="form-control" data-validation="alphanumeric" value="none"/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1" style="display:none;">
                                                    Producto
                                                </label>
                                                <input type="text" class="form-control" id="FnombrePP" name="FnombrePP"
                                                   placeholder="Producto" data-validation="alphanumeric"/>
                                                <label id="FnombrePP-error" style="color: red; display: none;"
                                                   class="error fv-plugins-message-container invalid-feedback"
                                                   for="FnombrePP"></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1" style="display:none;">
                                                    Cantidad
                                                </label>
                                                <input type="number" class="form-control" id="FcantidadPP" step="0.001"
                                                   oninput="calcula_precio();" placeholder="Cantidad" name="FcantidadPP"
                                                   data-validation="num"/>
                                                <label id="FcantidadPP-error" style="color: red; display: none;"
                                                   class="error fv-plugins-message-container invalid-feedback"
                                                   for="FcantidadPP"></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1" style="display:none;">
                                                    Precio
                                                </label>
                                                <input type="number" class="form-control" aria-label="Small" id="FprecioPP"
                                                   step="0.001" oninput="calcula_precio();" placeholder="Precio" name="FprecioPP"/>
                                                <label id="FprecioPP-error" style="color: red; display: none;"
                                                   class="error fv-plugins-message-container invalid-feedback"
                                                   for="FprecioPP"></label>
                                            </div>
                                        </div>
                                        <div class="col pr-1">
                                            <div class="form-outline">
                                                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1" style="display:none;">
                                                    Costo
                                                </label>
                                                <input type="number" class="form-control" id="FcostoPP" name="FcostoPP"
                                                   step="0.001" placeholder="Total"/>
                                                <label id="FcostoPP-error" style="color: red;display: none;"
                                                class="error fv-plugins-message-container invalid-feedback"
                                                for="FcostoPP"></label>
                                            </div>
                                        </div>
                                        <div class="col d-flex align-items-start p-0">
                                            <button type="button" data-action="addProductOrder" data-trId="-1" id="btn_agregarPP" class="btn btn-success">
                                                Agregar
                                            </button>
                                            <button type="reset" class="btn btn-primary ml-2" name="button" onclick="reseFormNewOrder()">
                                              Limpiar
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="d-flex mt-2">
                                    <table class="table table-striped table-responsive-md" id="tablePP">
                                      <thead class="thead-dark">
                                        <tr>
                                          <th scope="col">Codigo</th>
                                          <th scope="col">Producto</th>
                                          <th scope="col">Cantidad</th>
                                          <th scope="col">Precio Unitario</th>
                                          <th scope="col">Costo</th>
                                          <th scope="col">
                                            <button class="btn btn-sm btn-danger" id="delete_prod_tabla" data-action="delete_prod_tabla">
                                                Eliminar
                                            </button>
                                          </th>
                                        </tr>
                                      </thead>
                                      <tbody id="body-tabla"></tbody>
                                        <tfoot class="">
                                          <tr>
                                            <td></td>
                                            <td>N° Productos</td>
                                            <td id="nProd">0</td>
                                            <td><strong>Total</strong></td>
                                            <td id="total"></td>
                                            <td></td>
                                          </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <div id="totalPP"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
