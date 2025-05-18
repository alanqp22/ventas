<?php
include "Views/Templates/header.php";
?>
<section class="content">


  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Nueva Venta</h4>
    </div>
    <div class="card-body">
      <form id="formulario" class="row">
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-3">
              <label for="numeroFactura">Nro. Factura</label>
              <input type="number" class="form-control" id="numeroFactura" name="numeroFactura" placeholder="Nombre del cliente" required>
            </div>
            <div class="col-md-3">
              <label for="actEconomica">Actividad económica</label>
              <input type="number" class="form-control" id="actEconomica" name="actEconomica" placeholder="Teléfono del cliente" required>
            </div>
            <div class="col-md-3">
              <label for="tipo_documento">Tipo de documento</label>
              <select name="tipo_documento" id="tipo_documento" class="form-select">
                <option value="" disabled selected>Seleccione</option>
                <option value="1">Cedula de Identidad</option>
                <option value="5">NIT</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="documentoid">NIT/CI</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="documentoid" id="documentoid" placeholder="Carnet o NIT" aria-label="Carnet o NIT" aria-describedby="btnDocumentoId">
                <button class="btn btn-outline-secondary" type="button" id="btnDocumentoId"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <label for="razon_social">Razón social</label>
              <input type="hidden" name="id_cliente" id="id_cliente">
              <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Nombre de cliente o empresa">
            </div>
            <div class="col-md-6">
              <label for="cliente_email">Correo electrónico</label>
              <input type="email" class="form-control" id="cliente_email" name="cliente_email" placeholder="ej. hans@gmail.com">
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Registrar Venta</button>
        </div>
        <div class="col-md-3">

        </div>

      </form>
    </div>
  </div>
  <div class="card mt-3">
    <div class="card-header">
      <h4 class="card-title">Agregar Items</h4>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-2">
          <label for="codigo">Código</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="codigo" id="codigo" required>
            <input type="hidden" name="codigoProducto" id="codigoProducto" class="form-control">
            <button class="btn btn-outline-secondary" type="button" id="btnCodigo"><i class="fas fa-search"></i></button>
          </div>
        </div>
        <div class="col-md-6">
          <label for="nombre_producto">Producto</label>
          <input type="text" class="form-control" id="nombre_producto" name="nombre_producto">
        </div>
        <div class="col-md-2">
          <label for="descripcion_corta">U. Med.</label>
          <input type="text" class="form-control" id="descripcion_corta" name="descripcion_corta" disabled>
        </div>
        <div class="col-md-2">
          <label for="cantidad">Cantidad</label>
          <input type="number" class="form-control" id="cantidad" name="cantidad" value="1" min="1">
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <label for="precio_venta">Precio</label>
          <input type="number" class="form-control" id="precio_venta" name="precio_venta" step="0.01" value="0.00" disabled>
        </div>
        <div class="col-md-3">
          <label for="descuento">Descuento</label>
          <input type="number" class="form-control" id="descuento" name="descuento" step="0.01" min="0" value="0.00">
        </div>
        <div class=" col-md-3">
          <label for="sTotal">S. Total</label>
          <input type="number" class="form-control" id="sTotal" name="sTotal" step="0.01" min="0" value="0.00" disabled>
        </div>
        <div class="col-md-3">
          <label for="">&nbsp;</label>
          <div>
            <button type="button" class="btn btn-info" id="btnAgregarItem"><i class="fas fa-plus"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row  mt-3">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>S. Total</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody id="tblDetalles">

            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="input-group">
            <span class="input-group-text">S. Total</span>
            <input id="resSubTotal" type="number" step="0.01" value="0.00" aria-label="Sub Total" class="form-control" disabled>
          </div>
          <div class="input-group mt-3">
            <span class="input-group-text">Desc. Adic.</span>
            <input id="resDesc" type="number" step="0.01" value="0.00" min="0.00" aria-label="Descuento Adicional" class="form-control">
          </div>
          <div class="input-group mt-3">
            <span class="input-group-text">Total</span>
            <input id="resTotal" type="number" step="0.01" value="0.00" aria-label="Total" class="form-control" disabled>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
include "Views/Templates/footer.php";
?>