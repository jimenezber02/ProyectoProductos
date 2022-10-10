
<div class="proPP float-clear" style="clear: both;">
  <form action="#" id="form_product_venta">
      <div class="row">
        <input type="text" name="idProdForm" id="idProdForm" hidden value="-1">
        <input type="text" name="idTr" id="idTr" hidden value="-1">
        <div class="col" id="codigoPP" style="display:none;">
            <div class="form-outline">
                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1">Código</label>
                <input type="text" id="FcodigoPV" name="FcodigoPV" class="form-control" data-validation="alphanumeric"
                value="none"/>
            </div>
        </div>
        <div class="col">
            <div class="form-outline">
                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1" style="display:none;">
                    Producto
                </label>
                <input type="text" class="form-control" id="FnombrePv" name="FnombrePv"
                   placeholder="Producto" data-validation="alphanumeric"/>
                <label id="FnombrePv-error" style="color: gold; display: none;"
                   class="error fv-plugins-message-container invalid-feedback"
                   for="FnombrePv"></label>
            </div>
        </div>
        <div class="col">
            <div class="form-outline">
                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1" style="display:none;">
                    Cantidad
                </label>
                <input type="number" class="form-control" id="FcantidadPV" step="0.001" oninput="calculaPV();" name="FcantidadPV"
                   data-validation="num" placeholder="Cantidad"/>
                <label id="FcantidadPV-error" style="color: gold; display: none;"
                   class="error fv-plugins-message-container invalid-feedback"
                   for="FcantidadPV"></label>
            </div>
        </div>
        <div class="col">
            <div class="form-outline">
                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1" style="display:none;">
                    Precio
                </label>
                <input type="number" class="form-control" aria-label="Small" id="FprecioPV" step="0.001" oninput="calculaPV();" name="FprecioPV" placeholder="Precio"/>
                <label id="FprecioPV-error" style="color: gold; display: none;"
                   class="error fv-plugins-message-container invalid-feedback"
                   for="FprecioPV"></label>
            </div>
        </div>
        <div class="col pr-1">
            <div class="form-outline">
                <label class="form-label label_form_prod_nuevo mb-0" for="form8Example1" style="display:none;">
                    Costo
                </label>
                <input type="number" class="form-control" id="FcostoPV" step="0.001" name="FcostoPV" placeholder="Total"/>
                <label id="FcostoPV-error" style="color: gold;display: none;"
                class="error fv-plugins-message-container invalid-feedback"
                for="FcostoPV"></label>
            </div>
        </div>
        <div class="col d-flex align-items-stretch p-0">
            <button type="button" data-trId="-1" data-action="saveProduct" id="btn_agregarPP" class="btn btn-success mr-2">
                Agregar
            </button>
            <button type="reset" data-action="reset" class="btn btn-primary" name="button">Limpiar</button>
        </div>
      </div>
  </form>
</div>
