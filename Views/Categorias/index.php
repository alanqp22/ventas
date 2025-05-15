<?php
include "Views/Templates/header.php";
?>
<h1 class="mt-4">Categorias</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Categorias</li>
</ol>
<div class="div">
    <button class="btn btn-primary" type="button" id="btnNewCategoria">Nueva Categoria</button>
</div>
<table class="table" id="tblCategorias">
    <thead>
        <tr>
            <th></th>
            <th>Categoría</th>
            <th>Codigo Producto</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
</table>

<!-- Modal -->
<div class="modal fade" id="mdl_new_categoria" tabindex="-1" aria-labelledby="Modal de creación de categorias" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTitle">Nuevo Categoria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmRegistrarCategoria" method="POST">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="nombre_categoria" class="form-label">Nombre de Categoría</label>
                            <input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control" maxlength="50" required>
                        </div>
                        <div class="col-6">
                            <label for="codigoProducto" class="form-label">Codigo de Producto</label>
                            <input type="text" name="codigoProducto" id="codigoProducto" class="form-control" maxlength="50">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnRegistrarCategoria">Registrar categoria</button>
                </div>
            </form>
        </div>
    </div>
</div><?php
        include "Views/Templates/footer.php";
        ?>