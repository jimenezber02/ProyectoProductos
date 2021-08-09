<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php include("dependencias.php"); ?>

    <script src="../js/mod-creditos/creditos.js?2ff5341s5" type="text/javascript"></script>
    <script src="../js/mod-creditos/abonos.js?ef5321ce" type="text/javascript"></script>
    <script src="../js/mod-creditos/pedidos.js?evf4fvgsfc0fc" type="text/javascript"></script>

    <script type="text/javascript" src="../librerias/alertifyjs/alertify.min.js"></script>
    <title>PROYECTO BER</title>
</head>
<body>
    <div class="content">
        <header class="menu">
            <div class="logo"><img src="../img/lgo.png" alt="" class="logo"><a href="#">Kiosko Mary</a></div>
            <nav class="nav">
                <a href="../index.html">Inicio <span class="fas fa-home"></span></a>
                <a href="modulo_productos.php">Datos de productos <i class="fas fa-shopping-cart"></i></a>
                <a href="#">Cuentas por cobrar <i class="fas fa-money-check-alt"></i></a>
                <a href="modulo_saldos.php">Bonos/Saldos <i class="fas fa-wallet"></i></a>
            </nav>
        </header>

        <section class="section">
            
            <article>
                <center><h3>CUENTA DE CREDITOS</h3></center>
                <div id ="data" class="data">...</div>
            </article>

        </section>

        <aside id="aside" class="aside">
            <div class="asideH">
                <div class="imagen" id="imagen">
                    <h2><center>Kiosko</center></h2>
                </div>
            </div>
            <div class="asideH">
                <div class="imagen2" id="imagen2">
                    <img src="../img/lgo.png" id="maryIMG" alt="">
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
            <div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div id="modal-header">
                            <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <center><h3 class="modal-tittle">Datoss personales</h3></center>
                                <div class="modal-body">
                                  <form method="POST" action="#" id="form-ed">
                                      <input type="text" hidden="" name="idCliEdit" id="idCliEdit">
                                      <label style="color: blue;">Nombre Cliente</label>
                                      <input type="text" id="inputNombreC" class="form-control input-sm" placeholder="Nombre de cliente" name="inputNombreC" autofocus>

                                      <label style="color: blue;">Apellido</label>
                                      <input type="text" id="inputApeC" class="form-control input-sm" placeholder="Apellido" name="inputApe">

                                      <label style="color: blue;">C&eacute;dula</label>
                                      <input type="tex" id="inputCedC" class="form-control input-sm" placeholder="C&eacute;dula" name="inputCed">

                                  </form><!--cierra form-->
                                </div>
                                <div class="modal-footer">
                                    <button id="guardaCliEdit" onclick="update_cliente();" class="btn btn-warning" type="button">Actualizar Datos</button>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="modal modal-fullscreen-lg" id="modalP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-creditos" role="document">
                    <div class="modal-content">
                        <div id="modal-header">
                            <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h3 class="modal-tittle" style="color: red;">A&ntilde;adir productos</h3></center>
                            <div class="modal-body">
                                <h5>Ingresa el c&oacute;digo</h5>
                                <p>
                                    <label for="codigoPP">
                                        C&oacute;digo producto (Presione ENTER para buscar)
                                    </label></br>
                                    <div class="float-left">
                                      <input type="text" name="codigoPP" class="form-control sm" id="codigoPTP" placeholder="Codigo" onfocus="camp_cod_NPP();" onblur="fuera_codigo();">
                                    </div>
                                    <div class="float-left">
                                      <button href="#" id="guardarPP" title="Popover title" 
                                        onclick="validaPP();" class="btn btn-primary" >
                                          A&ntilde;adir a lista
                                      </button>
                                    </div>
                                    <div class="float-left">
                                      <button id="deletePP" class="btn btn-danger" onclick="borra2();" 
                                        style="display: none;">
                                            Eliminar marcados
                                      </button>
                                    </div>

                                </p>
                                <hr>
                                <p>
                                <div class="float-left">
                                    <button id="agregarPP" class="btn btn-success btn-sm" 
                                        onclick="carga_formPP();">
                                        Agregar
                                    </button>
                                </div>
                                <div id="tbo"></div>
                                    <table class="table table-bordered" id="tablePP">
                                        <thead>
                                        <tr>
                                            <td>Codigo</td>
                                            <td>Producto</td>
                                            <td>Cantidad</td>
                                            <td>Precio Unitario</td>
                                            <td>Costo</td>
                                            <td></td>
                                        </tr>
                                        </thead>
                                        <tbody id="bo"></tbody>
                                    </table>

                                </p>
                            </div>

                            <div class="modal-footer">
                                <div id="totalPP"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

