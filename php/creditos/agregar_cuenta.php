<?php
    include("../conexion/conexion.php");
    include("clase_creditos.php");
    include("../saldos/clase_saldo.php");
    $data = array(
        "nombre"   => $_POST['nom'],
        "apellido" => $_POST['ape'],
        "cedula"   => $_POST['ced'],
        "monto"    => $_POST['cuenta'],
        "anio"     => $_POST['anio'],
        "diaLetra" => $_POST['dia'],
        "mes"      => $_POST['mes'],
        "dia"      => $_POST['diaN'],
        "fecha"    => $_POST['fecha'],
        "coment"   => $_POST['comentario']
    );
    $conexion = new conexion();

    $ob = new clase_creditos();
    echo($ob -> abrir_cuenta($data));
?>
