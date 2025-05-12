<?php
include "Views/Templates/header.php";
?>
<h1 class="mt-4">Cajas</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Cajas</li>
</ol>
<div class="div">
  <button class="btn btn-primary" type="button" id="btnNewUser">Nueva Caja</button>
</div>
<table class="table" id="tblCajas">
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
</table>

<!-- Modal -->
<div class="modal fade" id="mdl_new_user" tabindex="-1" aria-labelledby="Modal de creación de usuarios" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalTitle">Nueva Caja</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="frmRegistrarUser" method="POST">
        <div class="modal-body">

          <div class="row mb-3">
            <div class="col-8">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control" maxlength="50" required>
            </div>
            <div class="col-4">
              <label for="nick" class="form-label">Usuario</label>
              <input type="text" name="nick" id="nick" placeholder="Usuario" class="form-control" maxlength="20" required>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="btnRegistrarUser">Registrar caja</button>
        </div>
      </form>
    </div>
  </div>
</div><?php
      include "Views/Templates/footer.php";
      ?>