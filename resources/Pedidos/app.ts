import MyModal from "../services/MyModal";
import MyTable from "../services/MyTable";
import ApiClient from "../services/ApiClient";
import MyAlert from "../services/MyAlert";
import {
  validateFields,
  getErrorMessage,
  actionsEvents,
} from "../services/functions";
declare const base_url: string;
let myModal: MyModal;
const apiClient = new ApiClient(base_url);
let tbl_productos: MyTable;

// Elementos DOM del modal
const modalNewProducto = document.getElementById(
  "mdl_new_producto"
) as HTMLElement;
const modalTitle = document.getElementById("modalTitle")!;
const btnRegistrar = document.getElementById("btnRegistrarProducto")!;
let frmRegistrarProducto = document.getElementById(
  "frmRegistrarProducto"
) as HTMLFormElement;
const codigo = document.getElementById("codigo") as HTMLInputElement;
const nombre_producto = document.getElementById(
  "nombre_producto"
) as HTMLInputElement;
const costo_compra = document.getElementById(
  "costo_compra"
) as HTMLInputElement;
const precio_venta = document.getElementById(
  "precio_venta"
) as HTMLInputElement;
const cantidad = document.getElementById("cantidad") as HTMLInputElement;
const id_categoria = document.getElementById(
  "id_categoria"
) as HTMLInputElement;
const id_medida = document.getElementById("id_medida") as HTMLInputElement;

// botón para abrir el modal
const btnNewProducto = document.getElementById("btnNewProducto")!;

async function main() {
  tbl_productos = new MyTable(base_url, "Productos/listar", "tblProductos", [
    "id_producto",
    "codigo",
    "nombre_producto",
    "costo_compra",
    "precio_venta",
    "cantidad",
    "descripcion_medida",
    "nombre_categoria",
    "estado",
    "acciones",
  ]);

  myModal = new MyModal(
    modalNewProducto,
    modalTitle,
    btnRegistrar,
    frmRegistrarProducto
  );
  btnNewProducto?.addEventListener("click", () => {
    myModal.setSelectedID(null);
    myModal.show();
  });

  myModal.setSubmitAction(() => registerProducto(myModal.getSelectedID()));

  // enlazar eventos a los botones de acciones
  actionsEvents(editProducto, deleteProducto, restoreProducto, (id: string) => {
    myModal.setSelectedID(id);
  });

  cantidad.addEventListener("input", () => {
    if (!Number.isInteger(Number(cantidad.value))) {
      console.error("Debe ser un número entero");
    }
  });
}

function restoreProducto(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea restaurar esta producto?",
    "",
    "Sí, restaurar",
    () => {
      apiClient
        .restore("Productos/restaurar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Producto restaurado con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function deleteProducto(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea eliminar esta producto?",
    "No podrá revertir esta acción",
    "Sí, eliminar",
    () => {
      apiClient
        .delete("Productos/eliminar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Producto eliminado con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function editProducto(id: string) {
  myModal.setTitle("Editar Producto");
  myModal.setBtnDone("Actualizar Producto");

  apiClient
    .getById("Productos/editar/", id)
    .then((resp) => {
      nombre_producto.value = resp.nombre_producto;
      codigo.value = resp.codigo;
      costo_compra.value = resp.costo_compra;
      precio_venta.value = resp.precio_venta;
      cantidad.value = resp.cantidad;
      id_medida.value = resp.id_medida;
      id_categoria.value = resp.id_categoria;
    })
    .catch((error) => {
      MyAlert.alertError(getErrorMessage(error));
    });
  myModal.show();
}

async function registerProducto(id: string | null) {
  if (id) {
    updateProducto(id);
    return;
  }

  if (!validateFields([nombre_producto, codigo])) {
    MyAlert.alertWarning(
      "Los campos Nombre de producto y código son obligatorios"
    );
    return;
  }

  try {
    const resp = await apiClient.create("Productos/registrar", {
      codigo: codigo.value,
      nombre_producto: nombre_producto.value,
      costo_compra: costo_compra.value,
      precio_venta: precio_venta.value,
      cantidad: cantidad.value,
      id_categoria: id_categoria.value,
      id_medida: id_medida.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Producto registrado con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

async function updateProducto(id: string): Promise<void> {
  if (!validateFields([nombre_producto, codigo])) {
    MyAlert.alertWarning(
      "Los campos Nombre de producto y código son obligatorios"
    );
    return;
  }
  try {
    const resp = await apiClient.update("Productos/actualizar/", id, {
      nombre_producto: nombre_producto.value,
      codigo: codigo.value,
      costo_compra: costo_compra.value,
      precio_venta: precio_venta.value,
      cantidad: cantidad.value,
      id_categoria: id_categoria.value,
      id_medida: id_medida.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Producto actualizado con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

function reloadLayout() {
  tbl_productos.reload();
  myModal.reset();
  myModal.hide();
  // simula redireccion
  history.pushState(null, "", `${base_url}Productos`);
}

document.addEventListener("DOMContentLoaded", () => {
  main();
});
