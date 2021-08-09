<div id="formuAbono">
    <form action="#" id="formAB" class="formD">
        <fieldset style="border: 1px dashed white;">
        <legend id="titleForm"><center>ABONAR A LA CUENTA</center></legend>
        
        <input type="text" name="" id="idFormAbono" hidden="hidden" value="-1"><!--id de producto, solo cuando se va editar se toma en cuenta este campo-->
        <input type="number" id="cuentaCredito" name="" hidden="hidden">
        
        <label for="">Nombre</label>
            <input type="text" id="nombreCliA" class="form-control input-sm" required>
        
        <label for="">Apellido</label>
        <input type="text" id="apellidoCliA" class="form-control input-sm" required>

        <label for="">C&eacute;dula</label>
        <input type="text" id="cedulaCliA" class="form-control input-sm" required>
        
        <!--cuenta-->
        <div class="" id="Cmonto">
            <label>El monto del abono</label></br>
                <input type="text" name="abonoM" id="abonoM" maxlength="6" size="6" placeholder="0.00" value="0.00" required> 
                </br> 
            
            <label for="fecha">Puedes a&ntilde;adir la fecha del pedido diferente al de hoy (opcional)</label>
                <input type="date" name="fecha" id="fechaAbono">
        </div>
        </br> 
        
        <!--<button class="btn btn-danger" class="close" data-dismiss="modal" id="cerrarAD">Cerrar</button>-->
        </fieldset>
    </form>
    <center>
        <button onclick="abonar_a_la_cuenta();" id="guardaAb" class="btn btn-success" type="submit">Abonar</button>
        <button onclick="abonarMonto();" id="AbonarTodo" class="btn btn-info">Pagar toda la cuenta</button>
        <button class="btn btn-danger" onclick="cancelarAbono();">Cancelar</button>
    </center>
</div>
