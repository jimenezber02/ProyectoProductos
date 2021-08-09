<div id="div-nuevoCliente">
    <form action="#" id="formNCS" class="formD">
        <fieldset style="border: 1px dashed white;">
        <legend id="titleForm"><center>CLIENTE Y SALDO</center></legend>

        <input type="text" name="" id="idCuentaS" hidden="hidden" value="-1"><!--id de cuenta-->

        <label for="">Nombre</label>
            <input type="text" id="nombreCliS" class="form-control input-sm" required>

        <label for="">Apellido</label>
        <input type="text" id="apellidoCliS" class="form-control input-sm" required>

        <label for="">C&eacute;dula</label>
        <input type="text" id="cedulaCliS" class="form-control input-sm" required>

        <!--cuenta-->
        <div class="" id="Cmonto">
            <label>El monto del saldo</label></br>
                <input type="number" class="form-control input-sm" id="monto_saldo" maxlength="6" size="6" placeholder="0" value="0" required>
            </br>
            <!--
            <label for="fecha">
                Puedes escoger una fecha de registro diferente al de hoy
            </label>
                <input type="date" name="fechaSaldo" id="fechaSaldo">-->
        </div>
        </br>

        <!--<button class="btn btn-danger" class="close" data-dismiss="modal" id="cerrarAD">Cerrar</button>-->
        </fieldset>
    </form>
    <center>
            <button onclick="obtienFormNewCliente();" id="guardaNCS" class="btn btn-success">Guardar</button>
            <button onclick="cancelarForm();" id="cancelarNCS" class="btn btn-primary">Cancelar</button>
    </center>
</div>
