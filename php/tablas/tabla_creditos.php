<?php
    require_once("../controller/clienteController.php");
?>
<div class="dataTable-area">
    <div class="header-dataTable-div d-flex justify-content-end">
        <!--Carga formulario de agregar nuevo cliente -->
        <button onclick="cargaF();" class="btn btn-success">
            Abrir cuenta
            <span class="bi bi-plus"></span>
        </button>

        <!--Boton opciones PDF -->
        <div class="dropdown ml-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-pdf"></i>
                PDF
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <button class="dropdown-item" type="button" onclick="abrePDF(1);">
                    Todos
                </button>
                <button class="dropdown-item" type="button" onclick="abrePDF(2);">
                    Los que tienen deudas
                </button>
            </div>
        </div><!--fIN DE BOTON PDF -->
    </div>

    <table class="table table-dark table-striped" id="datatable" style="width: 100%;">
        <thead style="background:   rgb(108, 67, 255) !important; color:white;">
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
            if(count($clientes) > 0){
              foreach ($clientes["clientes"] as $key => $value) {
                //Concatena los datos de un cliente para algunas de las funciones de js que la necesiten
                $datos=json_encode($value['id_cli'].'|'.$value['nombre'].'|'.$value['apellido'].'|'.$value['cedula'].'|'.$value['cuenta']);
                echo "</tr>";
                echo "<td>".$value['nombre']." ".$value['apellido']." ".$value['cedula']."</td>";
                echo "<td>".$value['cuenta']."</td>";
                echo "<td class='d-flex justify-content-around'><center>".
                      "<div class='dropdown'>".
                          "<button class='btn btn-outline-warning dropdown-toggle' type='button' id='dropdownMenu'
                                  data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                  Presione
                          </button>".
                          "<div class='dropdown-menu' aria-labelledby='dropdownMenu'>".
                            "<button class='dropdown-item' onclick='pedidoNuevo($value[id_cli],$value[id_cuentxcobrar])'>
                              Nuevo Pedido
                            </button>".
                            "<button class='dropdown-item' onclick='loadFormAbono($datos,$value[id_cuentxcobrar])'>
                              Abonar
                            </button>".
                            "<button class='dropdown-item' onclick='desglose_fecha($value[id_cuentxcobrar])'>
                              Desglose fechas
                            </button>".
                            "<button class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalEdicion'
                              data-action='editarCliente' data-id='$value[id_cli]' onclick='modalEdit($datos)'>
                              Editar datos personales
                            </button>".
                            "<button class='dropdown-item' onclick='delete_cliente($datos)'>
                              Eliminar Cliente
                            </button>".
                          "</div>".
                      "</div>".
                    "</center></td";

                echo "</tr>";
              }
            }
        ?><!--CIERRA PHP -->

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
                /*{
                    extend: 'excelHtml5',
                    title: 'deuda de clientes',
                    titleAttr: 'Exportar a excel',
                    className: 'far fa-file-excel btn btn-success btn-sm',
                    exportOptions: {columns: [0,1]}
                },
                {
                    extend: 'pdfHtml5',
                    title: 'deuda de clientes',
                    titleAttr: 'Exportar a pdf',
                    width: '100',
                    pageSize: 'letter',
                    orientation: 'landscape',
                    customize: function (doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    },
                    alignment: 'center',
                    className: 'far fa-file-excel ml-5 btn btn-secondary btn-sm',
                    exportOptions: {columns:[0,1]}
                }*/
            ]
        });
    });
</script>
