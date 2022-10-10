<?php
  include("../php/conexion/conexion.php");
  include("../php/creditos/clase_creditos.php");

  $obj = new conexion();
  if(!$obj->conectar()){
  	echo("Error de conexion a la base de datos");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../php/dependencias.php"); ?>

    <script type="text/javascript" src="../js/venta.js?8172635"></script>
    <script type="text/javascript" src="../librerias/alertifyjs/alertify.min.js"></script>
    <title>VENTAS</title>
</head>
<body>
    <div class="content">
        <header class="menu">
            <div class="logo"><img src="../img/vender.png" alt="" class="logo"><a href="#">Kiosko</a></div>
            <nav class="nav">
                <a href="../index.html"><i class="bi bi-house-fill"></i> INICIO</a>
                <a href="../php/modulo_productos.php"><i class="bi bi-cart4"></i> Datos de productos</a>
                <a href="../php/saldos_bonos.php"><i class="bi bi-wallet-fill"></i> Saldos/Bonos</a>
                <a href="../php/modulo_creditos.php"><i class="bi bi-cash-coin"></i> Cuentas por cobrar</a>
            </nav>
        </header>

        <section class="section ventas">
            <article class="art-v"><!-- seccion para la calculadora  -->
                <div id="blur-codigo" class="">
                  <div class="row">
                    <div class="col-4">
                      <div class="form-outline">
                        <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1">
                          C&oacute;digo producto
                        </label>
                        <input type="text" name="codigoPV" class="form-control sm" id="codigoPV"
                        placeholder="Codigo" data-validation="alphanumeric" data-action="findCodigo"/>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="venta-form">
                  <!--Aqui se carga unas cajas vacias para ingresar producto que no esten registrados -->
                </div>

                <!-- tabla donde se van añadiendo los productos que se pasan por el scanner -->
                <table class="table table-dark table-bordered table-striped" id="tablePP">
                    <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Costo</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="bo"></tbody>
                  <tfoot>
                    <tr>
                      <td>N° Productos</td>
                      <td id="n-prod">0</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
            </article>
        </section><!-- Fin de seccion de calculadora -->

        <aside class="aside">
            <div class="asideH">
              <div class="venta" id="venta">
                <div class="row">
                  <div class="col">
                    <div class="form-outline">
                        <label class="form-label-sm mb-0" for="form8Example1">
                            Total
                        </label>
                        <input type="number" class="form-control" id="suma" step="0.001">
                        <button id="agregarCred"  name="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                style="display: none" data-bs-target="#modalAC">
                          Agregar a credito
                        </button>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-outline">
                        <label class="form-label-sm mb-0" for="form8Example1">
                            Pago
                        </label>
                        <input type="number" class="form-control" id="pago" oninput="calculaPago();" step="0.001">
                    </div>
                  </div>
                </div>
                <div class="row d-flex justify-content-center">
                  <div class="col-5">
                    <div class="form-outline">
                        <label class="form-label-sm mb-0" for="form8Example1">
                            Cambio
                        </label>
                        <input type="number" class="form-control" id="cambio" step="0.001">
                        <button id="agreSald" class="btn btn-success btn-sm" data-toggle="modal" data-bs-target="#modalAS" style="display: none" >
                          Agregar a saldo
                        </button>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="asideH">
              <div class="imagen2"><img src="../img/vender.png"></div>
          </div>
        </aside>
      <footer class="footer"><p><i class="">Santiago, Veraguas</i><i class=""></i></p></footer>
    </div>
</body>
</html>

<!--Modal agregar a crédito -->
<div class="container">
    <div class="row">
        <div class="col">
            <div class="modal fade" id="modalAC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="background-color: rgb(95 168 160);">
                        <div id="modal-header">
                            <button class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h3 class="modal-tittle">Agregar a cr&eacute;dito</h3></center>
                            <div class="modal-body">
                              <div id="div-modalAC">
                                <!-- Aquí se carga la tabla con las cuentas -->
                              </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button class="btn btn-dark" id="selectCuentaCred">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal agregar a saldo -->
<div class="container">
    <div class="row">
        <div class="col">
            <div class="modal fade" id="modalAS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="background-color: rgb(95 168 160);">
                        <div id="modal-header">
                            <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h3 class="modal-tittle">Agregar a saldo</h3></center>
                            <div class="modal-body">
                              <div id="div-modalAS">
                                <!-- Aquí se carga la tabla con las cuentas de saldo-->
                              </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button class="btn btn-dark" id="selectCuentaSaldo">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal de crear cuenta nueva-->
<div class="container" >
    <div class="row">
        <div class="col">
            <div class="modal fade" id="modalCuentaNueva" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                <div class="modal-dialog modal-sm" role="document" >
                    <div class="modal-content" style="background-color: rgb(128 0 128); color: white;">
                        <div id="modal-header">
                            <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <center><h3 class="modal-tittle">CREAR CUENTA NUEVA</h3></center>
                                <div class="modal-body">
                                <form method="POST" action="#" id="form-ACN">

                                    <label>Nombre Cliente</label>
                                    <input type="text" id="inputNombreCN" class="form-control input-sm" placeholder="Nombre de cliente" name="inputNombreC" autofocus>

                                    <label>Apellido</label>
                                    <input type="text" id="inputApeCN" class="form-control input-sm" placeholder="Apellido" name="inputApe">

                                    <label>C&eacute;dula</label>
                                    <input type="tex" id="inputCedCN" class="form-control input-sm" placeholder="C&eacute;dula" name="inputCed">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button id="guardaClienteNuevo" class="btn btn-warning" type="button">Guardar</button>
                                </div>
                                </form><!--cierra form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
