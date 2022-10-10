<?php

    include("../conexion/conexion.php");
    include("../creditos/clase_creditos.php");

    
    //$cred = new clase_creditos();
    //$cuenta['cuenta'] = $cred-> getCuenta($idCliente); 

?>
<div>
    <!--
    <button onclick="cargaF();" class="btn btn-success" style="float: right;">
        Abrir cuenta
        <span class="fas fa-plus"></span>
    </button>-->
    <button onclick="abrePDF();" class="btn btn-primary" style="float: right;">PDF</button>

    <table class="table table-dark table-striped table-bordered border border-warning" id="datatable" style="width: 100%;color:white;">

        <thead style="background:   rgb(108, 67, 255); color:white;" id="thead">
            <tr>
                <td><center>FECHA</center></td>
                <td><center>DIA</center>
                <td><center>MES</center></td>
                <td><center>AÑO</center></td>
                <td><center>MONTO</center></td>
            </tr>
        </thead>
        <tfoot style="background-color: rgb(111, 111, 112); color: white;">
            <tr>
                <td><center>FECHA</center></td>
                <td><center>DIA</center></td>
                <td><center>MES</center></td>
                <td><center>AÑO</center></td>
                <td><center>MONTO</center></td>
            </tr>
        </tfoot>
        <tbody id="cuerpo_tabla">
            <!--Aquí van las filas creadas con javascript mediante la funcion carga_cuerpo_tabla_-->
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function(){
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
                    className: 'btn btn-success'
                },
            ]
        });
    });
</script>