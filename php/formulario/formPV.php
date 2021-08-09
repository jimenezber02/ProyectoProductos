
<div class="proPP float-clear" style="clear: both;">
    <ul class="list-group">
    	<li class="list-group-item" style="background-color: rgb(102, 15, 95);">
    		<div class="float-left" id="lPP">
    			<input type="text" class="form-control ff" size="6" id="FcodigoPV" name="pro_c[]" placeholder="Codigo">
    		</div>
    		<div class="float-left">
    			<input type="text" class="form-control ff" size="11" id="FnombrePv" name="pro_nom[]" placeholder="Nombre">
    		</div>

    		<div class="float-left">
    			<input type="number" class="form-control ff" size="10" id="FcantidadPV" step="0.001" oninput="calculaPV();" name="pro_cant[]" value="1" placeholder="Cantidad">
    		</div>
    		<div class="float-left">
    			<input type="number" class="form-control ff" size="18" id="FprecioPV" step="0.001" oninput="calculaPV();" name="pro_p[]" placeholder="Precio">
        </div>
    		<div class="float-left">
    			<input type="number" class="form-control ff" size="4" id="FcostoPV" step="0.001" name="pro_cost[]" placeholder="Total">
    		</div>
    	</li>
    </ul>
</div>
