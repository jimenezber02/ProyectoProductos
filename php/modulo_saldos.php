<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php include("dependencias.php"); ?>

    <script src="../js/saldos.js?fcf4ff31" type="text/javascript"></script>

    <script type="text/javascript" src="../librerias/alertifyjs/alertify.min.js"></script>
    <title>SALDOS DE CLIENTES</title>
</head>
<body>
    <div class="content">
        <header class="menu">
            <div class="logo"><img src="../img/lgo.png" alt="" class="logo"><a href="#">Kiosko Mary</a></div>
            <nav class="nav">
                <a href="../index.html">Inicio <span class="fas fa-home"> </span> </a>
                <a href="modulo_productos.php">
                    Datos de productos <i class="fas fa-shopping-cart"> </i>
                </a>
                <a href="modulo_creditos.php">
                    Cuentas por cobrar <i class="fas fa-money-check-alt"> </i>
                </a>
                <a href="#">
                    Bonos/Saldos <i class="fas fa-wallet"> </i>
                </a>
            </nav>
        </header>

        <section class="section">
            <article>
                <div class="data" id ="data" >
                    <!--<div class="float-right">
                        <button onclick="abrePDF();" class="btn btn-primary">PDF</button>
                    </div>-->
                    <div class="dropdown float-right">
                        <button class="btn btn-success dropdown-toggle" id="dropdownMenu" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fa fa-file-pdf"></span>
                                Documento PDF
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <button class="dropdown-item" onclick="abrePdf(1);">
                                Todos
                            </button>
                            <button class="dropdown-item" onclick="abrePdf(0);">
                                Mayor a cero
                            </button>
                        </div>
                    </div>

                    <div class="float-right">
                        <button class="btn btn-warning" id="newClienteSaldo">
                            AGREGAR CLIENTE <span class="fas fa-plus"></span>
                        </button>
                    </div>
                    <!--Tabla fechas-->
                    <table class="table table-dark table-striped table-bordered border border-warning" id="datatableSA" style="width: 100%;color:white;">

                        <thead style="background:   rgb(108, 67, 255); color:white;" id="thead">
                            <tr>
                                <th><center>NOMBRE</center></th>
                                <th><center>APELLIDO</center>
                                <th><center>CEDULA</center></th>
                                <th><center>SALDO</center></th>
                                <th><center>ACCIONES</center></th>
                            </tr>
                        </thead>
                        <tfoot style="background-color: rgb(111, 111, 112); color: white;">
                            <tr>
                                <td><center>NOMBRE</center></td>
                                <td><center>APELLIDO</center></td>
                                <td><center>CEDULA</center></td>
                                <td><center>SALDO</center></td>
                                <td><center>ACCIONES</center></td>
                            </tr>
                        </tfoot>
                        
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
                <div class="imagen2" id="cajaform">
                    <img src="../img/lgo.png" id="maryIMG" alt="">
                </div>
            </div>
        </aside>

        <footer class="footer"><p><i class="">Santiago, Veraguas</i><i class=""></i></p></footer>
    </div>
</body>
</html>