<?php
include "Views/Templates/header.php";
?>
<h1 class="mt-4">Medidas</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Medidas</li>
</ol>
<div class="div">
  <button class="btn btn-primary" type="button" id="btnNewMedida">Nueva Medida</button>
</div>
<table class="table" id="tblMedidas">
  <thead>
    <tr>
      <th></th>
      <th>Descripción Medida</th>
      <th>Descripción Corta</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
</table>

<!-- Modal -->
<div class="modal fade" id="mdl_new_medida" tabindex="-1" aria-labelledby="Modal de creación de medidas" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalTitle">Nueva Medida</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="frmRegistrarMedida" method="POST">
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-6">
              <label for="descripcion_medida" class="form-label">Descripción medida</label>
              <input type="text" name="descripcion_medida" id="descripcion_medida" class="form-control" maxlength="50" required>
            </div>
            <div class="col-6">
              <label for="descripcion_corta" class="form-label">Descripción corta</label>
              <input type="text" name="descripcion_corta" id="descripcion_corta" class="form-control" maxlength="50">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="btnRegistrarMedida">Registrar medida</button>
        </div>
      </form>
    </div>
  </div>
</div><?php
      include "Views/Templates/footer.php";
      ?>