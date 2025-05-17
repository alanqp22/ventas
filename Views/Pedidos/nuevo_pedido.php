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
      <form id="" class="row">
        <div class="col-md-2">
          <label for="codigo">Código</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="codigo" id="codigo">
            <button class="btn btn-outline-secondary" type="button" id="btnCodigo"><i class="fas fa-search"></i></button>
          </div>
        </div>
        <div class="col-md-3">
          <label for="nombre_producto">Producto</label>
          <input type="text" class="form-control" id="nombre_producto" name="nombre_producto">
        </div>
        <div class="col-md-1">
          <label for="descripcion_corta">U. Med.</label>
          <input type="text" class="form-control" id="descripcion_corta" name="descripcion_corta">
        </div>
        <div class="col-md-1">
          <label for="cantidad">Cantidad</label>
          <input type="number" class="form-control" id="cantidad" name="cantidad" value="1" min="1">
        </div>
        <div class="col-md-1">
          <label for="precio_venta">Precio</label>
          <input type="number" class="form-control" id="precio_venta" name="precio_venta" step="0.01">
        </div>
        <div class="col-md-1">
          <label for="descuento">Descuento</label>
          <input type="number" class="form-control" id="descuento" name="descuento" value="0" step="0.01" min="0">
        </div>
        <div class="col-md-1">
          <label for="sTotal">S. Total</label>
          <input type="number" class="form-control" id="sTotal" name="sTotal" value="0" step="0.01" min="0">
        </div>
      </form>
    </div>
  </div>
</section>
<?php
include "Views/Templates/footer.php";
?>