<div id="formuNuevoCliente">
    <form action="#" id="formD" class="formD">
        <h3>Nuevo cliente</h3>
        <input type="text" name="" id="idP" hidden="hidden" value="-1">
        <div class="row">
            <div class="col">
                <div class="form-outline">
                    <label class="form-label" for="form8Example1">Nombre</label>
                    <input type="text" name="inputNombre" id="inputNombre" class="form-control" data-validation="alphanumeric"/>
                    <label id="inputNombre-error" class="error fv-plugins-message-container invalid-feedback" for="inputNombre"></label>
                </div>
            </div>
            <div class="col">
                <!-- Apellido input -->
                <div class="form-outline">
                    <label class="form-label" for="form8Example2">Apellido</label>
                    <input type="text" id="inputApellido" name="inputApellido" class="form-control" data-validation="alphanumeric"/>
                    <label id="inputApellido-error" class="error fv-plugins-message-container invalid-feedback" for="inputApellido"></label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <!-- Cedula input -->
                <div class="form-outline">
                    <label class="form-label" for="inputCed">Cedula (Opcional)</label>
                    <input type="text" name="inputCed" id="inputCed" class="form-control" />
                </div>
            </div>
        </div>

        <hr/>
        <div id="Cmonto" style="display:none;">
            <div class="row">
                <div class="col">
                    <!-- Monto input -->
                    <div class="form-outline">
                        <label class="form-label" for="montoP">Monto</label>
                        <input type="number" name="monto" id="montoP" maxlength="5" size="5" placeholder="0" required value="0"
                               class="form-control" />
                        <label id="montoP-error" class="error fv-plugins-message-container invalid-feedback" for="montoP"></label>
                    </div>
                </div>
                <div class="col">
                    <!-- Fecha input -->
                    <div class="form-outline">
                        <label class="form-label" for="fecha">Fecha</label>
                        <input type="text" name="fecha" id="fecha" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <!-- Comentario input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="comentario">Comentario</label>
                        <textarea class="form-control" name="comentario" id="comentario" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col">
                <button onclick="formulario();" id="guarda" class="btn btn-success" type="button">Guardar</button>
            </div>
            <div class="col">
                <button id="inpmonto" onclick="carga_inputMonto();" class="btn btn-primary" type="button" onsubmit="return false;">
                    Ingresar el Monto (opcional)
                </button>
            </div>
        </div>
    </form>
</div>


    

  