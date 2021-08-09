<?php
  include("../conexion/conexion.php");
  $obj = new conexion();
  $tabla = "SELECT * FROM clientes";
  $r1 = mysqli_query($obj -> conectar(),$tabla);
 ?>
<div class="">
  <div class="float-left">
    <button class="btn btn-light btn-sm" id="btn crear_cuenta" data-toggle="modal" data-target="#modalCuentaNueva">
      Crear cuenta
    </button>
  </div>
  <table class="table table-bordered table-striped table-dark" id="cuenta_saldo" style="width: 100%;">
    <thead>
      <tr style="background-color: rgb(75 0 130);">
        <td><center>Nombre</center></td>
        <td><center>Apellido</center></td>
        <td><center>Cedula</center></td>
        <td><center>Cuenta</center></td>
        <td><center>Escoger</center></td>
      </tr>
    </thead>
    <tfoot>
      <tr style="background-color: rgb(75 0 130);">
        <td><center>Nombre<center></td>
        <td><center>Apellido</center></td>
        <td><center>Cedula</center></td>
        <td><center>Cuenta</center></td>
        <td><center>Escoger</center></td>
      </tr>
    </tfoot>
    <tbody id="table_agregarAcredito">
      <?php while($i = mysqli_fetch_array($r1)){ ?>
        <tr id="<?php echo($i[0]); ?>">
          <td><?php echo($i['nombre']); ?></td>
          <td><?php echo($i['apellido']); ?></td>
          <td><?php echo($i['cedula']); ?> </td>

          <!-- Para buscar la cuenta del cliente en la tabla cuentas -->
          <?php $sentencia2 = "SELECT * FROM cuentas_p_cobrar WHERE id_cli = '$i[0]'";
            $resul2 = mysqli_query($obj -> conectar(),$sentencia2);
            $v = mysqli_fetch_row($resul2);
          ?>

          <td><center><?php echo($v[1]); ?> </center></td>
          <td><center><input type="radio"  name="RadioCuenta" id="<?php echo($i[0]); ?>" ></center></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<script>
    $(document).ready(function(){
        $('#cuenta_saldo').DataTable({
            'language':{
                'lengthMenu': 'Mostrar _MENU_ registros',
                'info': 'Mostrando p&aacute;gina _PAGE_ de _PAGES_'
            },
            responsive: 'true',
            dom: 'Bfrtilp',
            buttons:[

            ]
        });
    });
</script>
