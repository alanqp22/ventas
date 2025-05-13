<?php
include "Views/Templates/header.php";
?>
<h1 class="mt-4">Clientes</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Clientes</li>
</ol>
<div class="div">
    <button class="btn btn-primary" type="button" id="btnNewCliente">Nueva Cliente</button>
</div>
<table class="table" id="tblClientes">
    <thead>
        <tr>
            <th></th>
            <th>Razon Social</th>
            <th>Documento</th>
            <th>Complemento</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
</table>

<!-- Modal -->
<div class="modal fade" id="mdl_new_cliente" tabindex="-1" aria-labelledby="Modal de creación de clientes" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTitle">Nuevo Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmRegistrarCliente" method="POST">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nombre" class="form-label">Razon Social</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" maxlength="50" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-8">
                            <label for="documentoid" class="form-label">Documento/NIT</label>
                            <input type="text" name="documentoid" id="documentoid" class="form-control" maxlength="50" required>
                        </div>
                        <div class="col-4">
                            <label for="complementoid" class="form-label">Complemento</label>
                            <input type="text" name="complementoid" id="complementoid" class="form-control" maxlength="50" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" name="correo" id="correo" class="form-control" maxlength="50" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnRegistrarCliente">Registrar cliente</button>
                </div>
            </form>
        </div>
    </div>
</div><?php
        include "Views/Templates/footer.php";
        ?>