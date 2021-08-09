<?php 
    include("../conexion/conexion.php");
    include("clase_creditos.php");

    $idCliente = $_REQUEST['id'];
    $cred = new clase_creditos();
    $cuenta = $cred-> getCuenta($idCliente);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php include("../dependencias2.php"); ?>

    <script src="../../js/desglose_fecha.js?f5f5f5652" type="text/javascript"></script>

    <script type="text/javascript" src="../../librerias/alertifyjs/alertify.min.js"></script>
    <title>DESGLOSE DE FECHAS</title>
</head>
<body>
    <div class="content">
        <header class="menu">
            <div class="logo"><img src="../../img/lgo.png" alt="" class="logo"><a href="#">Kiosko Mary</a></div>
            <nav class="nav">
                <a href="../../index.html">Inicio <span class="fas fa-home"></span></a>
                <a href="../modulo_productos.php">Datos de productos <i class="fas fa-shopping-cart"></i></a>
                <a href="../modulo_creditos.php">Cuentas por cobrar <i class="fas fa-money-check-alt"></i></a>
                <a href="../modulo_saldos.php">Saldos/Bonos<i class="fas fa-wallet"></i></a>
            </nav>
        </header>

        <section class="section">
            <article>
                <center><h3>FECHAS DE PEDIDOS</h3></center>
                <div id ="data" class="data">
                    <input type="text" id="idCli" hidden="hidden" value="<?php echo($idCliente); ?>">
                    <input type="text" id="idCuenta" hidden="hidden" value="<?php echo($cuenta['id_cuentxcobrar']); ?>">

                    <!--<button onclick="abrePDF();" class="btn btn-primary" style="float: right;">PDF</button>-->
                    <div class="dropdown float-right">
                        <button id="dropdownMenu" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-pdf"></i>
                            Doc PDF
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <button class="dropdown-item" id="pdfTodos">
                                Todos
                            </button>
                            <button class="dropdown-item" id="pdfPedRecientes">
                                Pedidos recientes
                            </button>
                            <button class="dropdown-item" id="pdfPedAnteriores">
                                Pedidos anteriores
                            </button>
                        </div>
                    </div>
                    <!--Tabla fechas-->
                    <table class="table table-dark table-striped table-bordered border border-warning" id="datatableDF" style="width: 100%;color:white;">

                        <thead style="background: rgb(108, 67, 255); color:white;" id="thead">
                            <tr>
                                <th><center>DIA</center></th>
                                <th><center>FECHA</center>
                                <th><center>MES</center></th>
                                <th><center>AÑO</center></th>
                                <th><center>ESTADO</center></th>
                                <th><center>MONTO</center></th>
                                <th><center>COMENTARIO</center></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot style="background-color: rgb(111, 111, 112); color: white;">
                            <tr>
                                <td><center>DIA</center></td>
                                <td><center>FECHA</center></td>
                                <td><center>MES</center></td>
                                <td><center>AÑO</center></td>
                                <td><center>ESTADO</center></td>
                                <td><center>MONTO</center></td>
                                <td><center>COMENTARIO</center></td>
                                <td></td>
                            </tr>
                        </tfoot>
                        
                        <!--Aquí van las filas creadas con javascript mediante la funcion carga_cuerpo_tabla_-->
                        
                    </table>
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
                <div class="imagen2" id="imagen2">
                    <img src="../../img/lgo.png" alt="">
                </div>
            </div>
        </aside>

        <footer class="footer">
            <p><i class="fab fa-twitter">@jimenez_ber</i><i class=""></i></p>
        </footer>
    </div>
</body>
</html>

<!--<script>
    $(document).ready(function(){
        $('#datatableDF').DataTable({
            'language':{
                'lengthMenu': 'Mostrar _MENU_ registros',
                'info': 'Mostrando p&aacute;gina _PAGE_ de _PAGES_',
                'search': 'Buscar',
                'zeroRecords': 'NO HAY DATOS',
                'paginate':{
                    'first': 'Primero',
                    'last': 'Anterior',
                    'next': 'Siguiente',
                    'previous': 'Anterior',
                }
            },
            responsive: 'true',
            dom: 'Bfrtilp',
            buttons:[
                {
                    extend: 'excelHtml5',
                    titleAttr: 'Exportar a excel',
                    className: 'btn btn-success'
                },
            ]
        });
    });
</script>*/-->