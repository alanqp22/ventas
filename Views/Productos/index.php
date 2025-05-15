<?php
include "Views/Templates/header.php";
?>
<h1 class="mt-4">Productos</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Productos</li>
</ol>
<div class="div">
    <button class="btn btn-primary" type="button" id="btnNewProducto">Nuevo Producto</button>
</div>
<table class="table" id="tblProductos">
    <thead>
        <tr>
            <th></th>
            <th>Código</th>
            <th>Producto</th>
            <th>Costo</th>
            <th>Precio venta</th>
            <th>Cantidad</th>
            <th>Unidad de medida</th>
            <th>Categoría</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
</table>

<!-- Modal -->
<div class="modal fade" id="mdl_new_producto" tabindex="-1" aria-labelledby="Modal de creación de productos" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTitle">Nuevo Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmRegistrarProducto" method="POST">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" maxlength="50" required>
                        </div>
                        <div class="col-8">
                            <label for="nombre_producto" class="form-label">Nombre del producto</label>
                            <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" maxlength="50" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="costo_compra" class="form-label">Costo de compra</label>
                            <input type="number" step="0.1" name="costo_compra" id="costo_compra" class="form-control" maxlength="50">
                        </div>
                        <div class="col-4">
                            <label for="precio_venta" class="form-label">Precio de venta</label>
                            <input type="number" step="0.1" name="precio_venta" id="precio_venta" class="form-control" maxlength="50">
                        </div>
                        <div class="col-4">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" step="1" min="0" name="cantidad" id="cantidad" class="form-control" maxlength="50">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="id_categoria">Categoría</label>
                            <select id="id_categoria" name="id_categoria" class="form-select" aria-label="Selección de caja">
                                <option value="" selected>Selecciona una categoria</option>
                                <?php
                                foreach ($params['categorias'] as $categoria) {
                                ?>
                                    <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['nombre_categoria'] ?></option>
                                <?php
                                };
                                ?>

                            </select>
                        </div>
                        <div class="col-6">
                            <label for="id_medida">Medida</label>
                            <select id="id_medida" name="id_medida" class="form-select" aria-label="Selección de caja">
                                <option value="" selected>Selecciona una medida</option>
                                <?php
                                foreach ($params['medidas'] as $medida) {
                                ?>
                                    <option value="<?= $medida['id_medida'] ?>"><?= $medida['descripcion_medida'] ?></option>
                                <?php
                                };
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnRegistrarProducto">Registrar producto</button>
                </div>
            </form>
        </div>
    </div>
</div><?php
        include "Views/Templates/footer.php";
        ?>