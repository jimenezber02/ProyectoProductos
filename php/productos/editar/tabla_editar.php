<?php
    include("conexion.php");
    $datos = "SELECT * FROM productos";
    $obj = new conexion();

    $conn = $obj -> conectar();
    $result = mysqli_query($conn,$datos);
?>
<div>
    <button onclick="cargaF();" class="btn btn-warning" style="float: right;">
        Agregar
        <span class="fas fa-plus"></span>
    </button>
    <table class="table table-hover table-condensed table-bordered" id="datatable" style="width: 100%;">
        <thead style="background:   rgb(108, 67, 255); color:white;"> 
            <tr >
            <td>PRODUCTO</td>
            <td>DESCRIPCION</td>
            <td>PRECIO</td>
            <th>EDITAR</th>
            <th>ELIMINAR</th>
            </tr>
        </thead>
        <tfoot style="background-color: rgb(111, 111, 112); color: white;">
            <tr>
            <td>PRODUCTO</td>
            <td>DESCRIPCION</td>
            <td>PRECIO</td>
            <th>EDITAR</th>
            <th>ELIMINAR</th>
            </tr>
        </tfoot>
        <tbody>
            <?php while($i = mysqli_fetch_array($result)){ ?>
            <tr>
                <td><?php echo($i['nombre']); ?></td>
                <td><?php echo($i['descripcion']); ?></td>
                <td><?php echo($i['precio']); ?></td>
                <th> <button onclick="buscaPro('<?php echo($i[0]); ?>');" class="btn btn-warning" ><!---->
                        <i class="fa fa-pencil-alt"></i>
                    </button></td>
                <th><button class="btn btn-danger" onclick="eliminaDatos('<?php echo($i[0]); ?>');">
                        <i class="fa fa-trash"></i>
                    </button></th>
            </tr>
            <?php }//cierra_while ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function(){
        $('#datatable').DataTable({
            'language':{
                'lengthMenu': 'Mostrar _MENU_ registros',
                'info': 'Mostrando p&aacute;gina _PAGE_ de _PAGES_'
            },
            responsive: 'true',
            dom: 'Bfrtilp',
            buttons:[{extend: 'excelHtml5',titleAttr: 'Exportar a excel',className: 'btn btn-success'},
                {extend: 'pdfHtml5',titleAttr: 'Exportar a pdf',className: 'btn btn-primary'},
            ]
        });     
    });
</script>