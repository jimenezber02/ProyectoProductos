<div id="formuPedidoNuevo">
    <form action="#" id="formNPC" class="formD">
        <fieldset style="border: 1px dashed white;">
        <legend id="titleForm"><center>NUEVO PEDIDO</center></legend>

        <input type="text" name="" id="idCuenta" hidden="hidden" value="-1"><!--id de cuenta-->

        <label for="">Nombre</label>
            <input type="text" id="nombreCliP" class="form-control input-sm" required>

        <label for="">Apellido</label>
        <input type="text" id="apellidoCliP" class="form-control input-sm" required>

        <label for="">C&eacute;dula</label>
        <input type="text" id="cedulaCliP" class="form-control input-sm" required>

        <!--cuenta-->
        <div class="" id="Cmonto">
            <label>El monto del pedido</label></br>
                <input type="number" class="form-control input-sm" id="ped_nuevo" maxlength="6" size="6" placeholder="0" value="0" required>
                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#modalP">
                    A&ntilde;adir los productos (opcional)
                </button>
            </br>

            <label for="fecha">
                Puedes escoger una fecha diferente al de hoy
            </label>
                <input type="date" name="fechaPN" id="fechaPN"></br>
            <label>AGREGAR UN PEQUE&Ntilde;O COMENTARIO</label></br>
            <textarea id="comentario" cols="20"></textarea>
        </div>
        </br>

        <!--<button class="btn btn-danger" class="close" data-dismiss="modal" id="cerrarAD">Cerrar</button>-->
        </fieldset>
    </form>
    <center>
            <button onclick="envia_nuevoPP();" id="guardaNPP" class="btn btn-success" type="submit">Grabar</button>
            <button onclick="cancelar_pedido();" id="cancelarNPP" class="btn btn-primary">Cancelar</button>
    </center>
</div>

