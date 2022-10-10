<div id="formuPedidoNuevo" class="d-flex justify-content-center align-items-center">
    <form action="#" id="formNPC" class="formD">
        <h3>Pedido nuevo</h3>
        <!--id de cuenta-->
        <input type="text" name="idCuentaP" id="idCuentaP" hidden value="-1">
        <div class="row">
            <div class="col">
                <!-- Nombre input -->
                <div class="form-outline">
                    <label class="form-label" for="nombreCliP">Nombre</label>
                    <input type="text" disabled class="form-control" id="nombreCliP" name="nombreCliP" data-validation="alphanumeric"/>
                </div>
            </div>
            <div class="col">
                <!-- Apellido input -->
                <div class="form-outline">
                    <label class="form-label" for="apellidoCliP">Apellido</label>
                    <input type="text" disabled id="apellidoCliP" class="form-control" name="apellidoCliP" data-validation="alphanumeric"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <!-- Cedula input -->
                <div class="form-outline">
                    <label class="form-label" for="cedulaCliP">Cedula (Opcional)</label>
                    <input disabled type="text" class="form-control" id="cedulaCliP" name="cedulaCliP" />
                </div>
            </div>
        </div>

        <hr/>
        <div id="Cmonto">
            <div class="row">
                <div class="col">
                    <!-- Monto input -->
                    <div class="form-outline">
                        <label class="form-label" for="ped_nuevo">Monto</label>
                        <input type="number" data-validation="num" id="ped_nuevo" name="ped_nuevo" maxlength="6" size="6"
                               placeholder="0" value="0" required class="form-control" />
                        <label id="ped_nuevo-error" class="error fv-plugins-message-container invalid-feedback" for="ped_nuevo"></label>
                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalP">
                            A&ntilde;adir los productos (opcional)
                        </button>
                    </div>
                </div>
                <div class="col">
                    <!-- Fecha input -->
                    <div class="form-outline">
                        <label class="form-label" for="fechaPN">Fecha</label>
                        <input type="text" name="fechaPN" id="fechaPN" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <!-- Comentario input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="comentario">Comentario (opcional)</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 d-flex justify-content-center">
                <button id="btn_nuevoPedido" type="button" onsubmit="return false;" class="btn btn-primary" >
                    Enviar
                </button>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <button id="cancelarPedido" class="btn btn-danger" type="button">
                    Cancelar
                </button>
            </div>
        </div>
    </form>
</div>

