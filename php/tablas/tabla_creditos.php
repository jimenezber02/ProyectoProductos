<?php
    include("../conexion/conexion.php");
    include("../creditos/clase_creditos.php");
    //include("../saldos/clase_saldo.php");
    //$conexion = new conexion();
    $cred = new clase_creditos();
    $creditos['creditos'] = $cred-> getCreditos();
?>
<div>
    <button onclick="cargaF();" class="btn btn-success" style="float: right;">
        Abrir cuenta
        <span class="fas fa-plus"></span>
    </button>
    <!--<button onclick="abrePDF();" class="btn btn-primary" style="float: right;">PDF</button>-->
    <!--Boton PDF -->
    <div class="dropdown" style="float: right;">
        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="fas fa-file-pdf"></span>
            PDF
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu">
            <button class="dropdown-item" type="button" onclick="abrePDF();">
                Todos
            </button>
            <button class="dropdown-item" type="button" onclick="abrePDF2();">
                Mayores a cero
            </button>
        </div>
    </div><!--fIN DE BOTON PDF -->

    <table class="table table-dark table-striped table-bordered border border-warning" id="datatable" 
    style="width: 100%;color:white;">

        <thead style="background:   rgb(108, 67, 255); color:white;">
            <tr>
                <th><center>DATOS PERSONALES</center></th>
                <th><center>CUENTA</center></th>
                <th><center>ACCIONES</center></th>
            </tr>
        </thead>
        <tfoot style="background-color: rgb(111, 111, 112); color: white;">
            <tr>
                <td><center>DATOS PERSONALES</center></td>
                <td>CUENTA</center></td>
                <td><center>ACCIONES</center></td>
            </tr>
        </tfoot>
        <tbody>
        <?php 
            $i = 0;
            if(count($creditos) > 0){
                foreach ($creditos["creditos"] as $key => $value) {
                    //Se busca la cuenta asociada al cliente
                    $cuenta = $cred-> getCuenta($value['id_cli']);
                    //Concatena los datos de un cliente para algunas de las funciones de js que la necesiten
                    $datos = $value['id_cli'].'|'.$value['nombre'].'|'.$value['apellido'].'|'.$value['cedula'].'|'.$cuenta['cuenta'].'|'.$cuenta['id_cuentxcobrar'];
                ?>
                <tr><!-- Abre fila -->
                    <td>
                        <center>
                            <?php echo($value['nombre']); ?>
                            <?php echo($value['apellido']); ?>
                            <?php echo($value['cedula']); ?>
                        </center>
                    </td>
                        
                    <td><center><?php echo($cuenta['cuenta']); ?></center></td>
                       
                    <td>
                        <center>
                        <div class="dropdown"><!--BOTON DE OPCIONES -->
                            <button class="btn btn-outline-warning dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Presione
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                                <button class="dropdown-item" type="button" 
                                    onclick="nuevoPedido(<?php echo($value['id_cli']); ?>);">
                                    Nuevo pedido
                                </button>
                                <button class="dropdown-item" type="button" onclick="formuAbono('<?php echo($datos); ?>');">
                                    Abonar
                                </button>
                                <button class="dropdown-item" type="button" id="desglose_fecha" 
                                    onclick="desglose_fecha(<?php echo($value['id_cli']); ?>);">
                                    Desglose de fecha
                                </button>
                                <button class="dropdown-item" type="button" data-toggle="modal" data-target="#modalEdicion"  onclick="modalEdit('<?php echo($datos); ?>');">
                                    Editar datos personales
                                </button>
                                <button class="dropdown-item"  type="button" 
                                    onclick="delete_cliente('<?php echo($datos); ?>');">
                                    Eliminar Cliente
                                </button>
                            </div>
                        </div>
                        </center>
                    </td>
                </tr><!--Cierra fila -->
                <?php 
                }
            }  
        ?><!--CIERRA PHP -->
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function(){
        let span = document.createElement('span');
            span.className = 'far fa-file-excel';
        $('#datatable').DataTable({
            'language':{
                'lengthMenu': 'Mostrar _MENU_ registros',
                'info': 'Mostrando p&aacute;gina _PAGE_ de _PAGES_',
                'search': 'Buscar',
                'zeroRecords': 'No hay datos',
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
                    className: 'far fa-file-excel btn btn-success btn-lg'
                },
            ]
        });
    });
</script>
