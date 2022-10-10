
<div id="formuAbono">
    <form action="#" id="formABONO">
        <h3>Abonar a la cuenta</h3>
        <input type="text" name="idCuenta" hidden>
        <input type="text" name="idCliente" hidden>
        <input type="number" name="cuenta" hidden>
        <div class="row">
            <div class="col">
                <div class="form-outline">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" disabled>
                </div>
            </div>
            <div class="col">
                <div class="form-outline">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" name="apellido" id="apellido" disabled>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-5">
                <div class="form-outline">
                    <label for="cedula">C&eacute;dula</label>
                    <input type="text" class="form-control" name="cedula" id="cedula" disabled>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <div class="form-outline">
                    <label for="cuenta" class="cuenta">Cuenta por pagar</label>
                    <input type="number" name="cuenta" id="cuenta" class="form-control" disabled>
                </div>
            </div>
            <div class="col">
                <div class="form-outline">
                    <label for="abono">Abonar (?)</label>
                    <input type="number" name="elabono" id="elabono" class="form-control">
                    <label id="abono" class="error fv-plugins-message-container invalid-feedback" for="abono"></label>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-5">
                <div class="form-outline">
                    <label for="fecha">Fecha</label>
                    <input type="text" name="fecha" id="fecha" class="form-control">
                </div>
            </div>
        </div>
        <hr>
        <div class="row d-flex justify-content-center">
            <div class="col d-flex justify-content-center">
                <button class="btn btn-success" id="abonar" type="button" onsubmit="return false;">Abonar</button>
            </div>
            <div class="col d-flex justify-content-center">
                <button class="btn btn-primary" id="pagar_todo" type="button" onsubmit="return false;">Pagar todo</button>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-4">
            <div class="col d-flex justify-content-center">
                <button class="btn btn-danger" onclick="cancelarAbono();">Cancelar</button>
            </div>
        </div>
    </form>
</div>
