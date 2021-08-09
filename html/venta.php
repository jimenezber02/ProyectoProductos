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
    <link rel="stylesheet" href="../css/style.css?f655020">

    <script type="text/javascript" src="../js/venta.js?22cc16562f"></script>
    <script type="text/javascript" src="../librerias/alertifyjs/alertify.min.js"></script>
    <title>VENTAS-ABARROTERIA MARY</title>
</head>
<body>
    <div class="content">
        <header class="menu">
            <div class="logo"><img src="../img/lgo.png" alt="" class="logo"><a href="#">Abarroteria Mary</a></div>
            <nav class="nav">
                <a href="../index.html"><i class="fas fa-home">INICIO</i></a>
                <a href="../php/modulo_productos.php"><i class="fas fa-shopping-cart"></i> Datos de productos</a>
                <a href="../php/saldos_bonos.php"><i class="fas fa-wallet"></i>Saldos/Bonos</a>
                <a href="../php/modulo_creditos.php"><i class="fas fa-money-check-alt"></i>Cuentas por cobrar</a>
            </nav>
        </header>

        <section class="section">
            <article class="art-v"><!-- seccion para la calculadora  -->
            	<div class="modal-body">
      					<h5>Ingresa el c&oacute;digo</h5>

      					<p>
      						<label for="codigoPV">C&oacute;digo producto</label></br>
      						<div class="float-left">
  		              <input type="text" name="codigoPV" class="form-control sm" id="codigoPV"  placeholder="Codigo">
						      </div>
      						<div class="float-left">
      						  <button href="#" id="anadirLista" title="Popover title" class="btn btn-primary" >
      							  A&ntilde;adir a lista
      						  </button>
      						</div>
      						<div class="float-left">
      						  <button id="deletePP" class="btn btn-danger" style="display: none;">
      							Eliminar marcados
      						  </button>
      						</div>
      					</p>

    					<p><!--
      					<div class="float-left">
      						<button id="agregarPP" class="btn btn-success btn-sm" onclick="carga_formPP();">Agregar</button>
      					</div>-->

      					<div id="tbo">
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
      						</table>
      					</p>
      				</div>
            </article>
        </section><!-- Fin de seccion de calculadora -->

        <aside class="aside">
            <div class="asideH">
                <div class="imagen2"><img src="../img/lgo.png"></div>
            </div>
            <div class="asideH">
            	<div class="venta" id="venta" style="display: none;">
      					<div class="float-left">
      						<center>
      							<label>TOTAL</label>
      							<input type="number" class="form-control" size="20" id="suma" step="0.001">
                    <button id="agregarCred"  name="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#modalAC">
                      Agregar a credito
                    </button>
      						</center>
      					</div></br>

      					<div class="float-left">
      						<center>
                        <label>Pago</label>
      					         <input type="number" class="form-control" id="pago" size="20" oninput="calculaPago();" step="0.001">
                  </center>
      					</div>
      					</br>
      					<div class="float-left">
      						<center>
      							<label>Cambio</label>
      							<input type="number" class="form-control" id="cambio" size="20" step="0.001">
                    <button id="agreSald" class="btn btn-success" data-toggle="modal" data-target="#modalAS" style="display: none" >
                      Agregar a saldo
                    </button>
      						<center>
      					</div>
      				</div>
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
                            <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h3 class="modal-tittle">Agregar a cr&eacute;dito</h3></center>
                            <div class="modal-body">
                              <div id="div-modalAC">
                                <!-- Aquí se carga la tabla con las cuentas -->
                              </div>
                            </div>

                            <div class="modal-footer">
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
