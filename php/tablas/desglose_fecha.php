<?php
    $idCliente = $_REQUEST['id'];

    require_once("../controller/desglose_pedidosController.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/desglose_fecha.css?v=7165342">

    <?php include("../dependencias/dependencias.php"); ?>

    <script src="../../js/desglose_fecha.js?716265" type="text/javascript"></script>

    <script type="text/javascript" src="../../librerias/alertifyjs/alertify.min.js"></script>
    <title>DESGLOSE DE FECHAS</title>
</head>
<body>
    <div class="content">
        <header class="menu">
            <div class="logo"><img src="../../img/vender.png" alt="logo" class="logo"><a href="#">Kiosko</a></div>
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

                    <!--<button onclick="abrePDF();" class="btn btn-primary" style="float: right;">PDF</button>-->
                    <div class="dropdown">
                        <button id="dropdownMenu" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-pdf"></i>
                            Generar PDF
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <button class="dropdown-item" data-val="0" data-action="loadPdf">
                                Todos
                            </button>
                            <button class="dropdown-item" data-val="1" data-action="loadPdf">
                                Pedidos recientes
                            </button>
                            <button class="dropdown-item" data-val="2" data-action="loadPdf">
                                Pedidos anteriores
                            </button>
                        </div>
                    </div>
                    <!--Tabla fechas-->
                    <table class="table table-dark table-striped" id="datatableDF" style="width: 100%;">
                      <thead  id="thead">
                        <tr id="titulo">
                          <th><center>DIA</center></th>
                          <th><center>FECHA</center>
                          <th><center>MES</center></th>
                          <th><center>AÑO</center></th>
                          <th><center>ESTADO</center></th>
                          <th><center>MONTO</center></th>
                          <th><center>COMENTARIO</center></th>
                          <th><center>Acci&oacute;n</center></th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <td><center>DIA</center></td>
                          <td><center>FECHA</center></td>
                          <td><center>MES</center></td>
                          <td><center>AÑO</center></td>
                          <td><center>ESTADO</center></td>
                          <td><center>MONTO</center></td>
                          <td><center>COMENTARIO</center></td>
                          <td><center>Acci&oacute;n</center></td>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                          if(count($fechas)){
                            foreach ($fechas["fechas"] as $key => $value) {
                              // code...
                              echo "<tr id='$value[id_ped]'>";
                              echo "<td>".$value['dia']."</td>";
                              echo "<td>".$value['fecha']."</td>";
                              echo "<td>".$value['mes']."</td>";
                              echo "<td>".$value['anio']."</td>";
                              echo "<td>".$value['estado']."</td>";
                              echo "<td>".$value['valor']."</td>";
                              echo "<td>".$value['comentario']."</td>";
                              echo "<td>".
                                    "<button class='btn btn-warning btn-sm' data-cliente='$value[id_cuentxcobrar]' data-val='$value[valor]' data-id='$value[id_ped]' data-action='payOrder'>
                                      Pagar
                                    </button>".
                                "</td>";
                              echo "</tr>";
                            }
                          }
                        ?>
                      </tbody>
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
                    <img src="../../img/vender.png" alt="">
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
