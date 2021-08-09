<?php
    include("../conexion/conexion.php");
    include("../productos/productos.php");

    $p = new productos();
    $productos["productos"] = $p->getProductos();
?>
<div>
    <button onclick="formAgregarPro();" class="btn btn-warning" style="float: right;">
        Agregar
        <span class="fas fa-plus"></span>
    </button>
    <button onclick="abrepdf();" class="btn btn-primary" style="float: right;">PDF</button>
    
    <table class="table table-dark table-striped table-bordered border-primary" id="datatable" style="width: 100%;">
        <thead style="background:   rgb(108, 67, 255); color:white;"> 
            <tr>
                <th>C&Oacute;DIGO</th>
                <th>PRODUCTO</th>
                <th>DESCRIPCION</th>
                <th>PRECIO</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tfoot style="background-color: rgb(111, 111, 112); color: white;">
            <tr>
                <td>C&Oacute;DIGO</td>
                <td>PRODUCTO</td>
                <td>DESCRIPCION</td>
                <td>PRECIO</td>
                <td>ACCIONES</td>
            </tr>
        </tfoot>
        <tbody>
            
        <?php 
            $i = 0;
            //while($i < (count($productos))){
                foreach ($productos["productos"] as $key => $value) { ?>
                <tr><!--Crea una fila-->
                    <td><?php echo($value["codigo"]); ?></td>
                    <td><?php echo($value["nombre"]); ?></td>
                    <td><?php echo($value["descripcion"]); ?></td>
                    <td><?php echo($value["precio"]); ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" title="Editar" onclick="formEdit(<?php echo($value["id"]); ?>);">
                            <i class="fa fa-pencil-alt"></i>
                        </button>
                    
                        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminaDatos(<?php echo($value["id"]); ?>);">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr><!-- Cierra la fila -->
                <?php 
                }//Ciera foreach
            //$i++;//Aumenta una posición
            //}//Cierra While  
        ?>    
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
                    className: 'btn btn-success',
                    pageSize: 'Letter',
                    exportOptions: {columns: [0,1,2,3]} 
                },
            ]
        });     
    });
</script>
