<div id="formuNuevoCliente">
    <form action="#" id="formD" class="formD">
        <fieldset style="border: 1px dashed white;">
        <legend id="titleForm"><center>DATOS DE CLIENTE</center></legend>
        
        <input type="text" name="" id="idP" hidden="hidden" value="-1"><!--id de producto, solo cuando se va editar se toma en cuenta este campo-->
        
        <label for="">Nombre</label>
            <input type="text" id="inputNombre" class="form-control input-sm" required>
        
        <label for="">Apellido</label>
        <input type="text" id="inputApellido" class="form-control input-sm" required>

        <label for="">Cedula (opcional)</label>
            <input type="text" id="inputCed" class="form-control input-sm">
        
        <!--cuenta-->
        <div class="" id="Cmonto" style="display:none;">
            <label>Ingrese monto de la deuda(opcional)</label></br>
            <label>Balboas</label>
                <input type="number" name="dolar" id="montoP" maxlength="5" size="5" placeholder="0" required> 
                </br> 
            
            <label for="fecha">Puedes a&ntilde;adir la fecha del pedido (opcional)</label>
                <input type="date" name="fecha" id="fecha"></br>
            <label>AGREGAR UN PEQUE&Ntilde;O COMENTARIO</label></br>
            <textarea id="comentario" cols="20"></textarea>
        </div>
        </br> 
        
        <!--<button class="btn btn-danger" class="close" data-dismiss="modal" id="cerrarAD">Cerrar</button>-->
        </fieldset>
    </form>
    <center>
            <button onclick="formulario();" id="guarda" class="btn btn-success" type="submit">Guardar</button>
            <button id="inpmonto" onclick="carga_inputMonto();" class="btn btn-primary">Ingresar el Monto (opcional)</button>
    </center>
</div>
    

  