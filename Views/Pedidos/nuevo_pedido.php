<?php
include "Views/Templates/header.php";
?>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Nueva Venta</h4>
  </div>
  <div class="card-body">
    <form id="formulario">
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
          <div class="row">
            <div class="col-md-9">
              <input type="text" class="form-control" name="documentoid" id="documentoid" placeholder="Ingrese Carnet o NIT" />
            </div>
            <div class="col-md-3">
              <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-6">
          <label for="razon_social">Razón social</label>
          <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Nombre de cliente o empresa">
        </div>
        <div class="col-md-6">
          <label for="cliente_email">Correo electrónico</label>
          <input type="number" class="form-control" id="cliente_email" name="cliente_email" placeholder="ej. hans@gmail.com">
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Registrar Venta</button>
    </form>
  </div>
</div>

<?php
include "Views/Templates/footer.php";
?>