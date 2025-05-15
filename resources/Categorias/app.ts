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
let tbl_categorias: MyTable;

// Elementos DOM del modal
const modalNewCategoria = document.getElementById(
  "mdl_new_categoria"
) as HTMLElement;
const modalTitle = document.getElementById("modalTitle")!;
const btnRegistrar = document.getElementById("btnRegistrarCategoria")!;
let frmRegistrarCategoria = document.getElementById(
  "frmRegistrarCategoria"
) as HTMLFormElement;
const nombre_categoria = document.getElementById(
  "nombre_categoria"
) as HTMLInputElement;
const codigoProducto = document.getElementById(
  "codigoProducto"
) as HTMLInputElement;

// botón para abrir el modal
const btnNewCategoria = document.getElementById("btnNewCategoria")!;

async function main() {
  tbl_categorias = new MyTable(base_url, "Categorias/listar", "tblCategorias", [
    "id_categoria",
    "nombre_categoria",
    "codigoProducto",
    "estado",
    "acciones",
  ]);

  myModal = new MyModal(
    modalNewCategoria,
    modalTitle,
    btnRegistrar,
    frmRegistrarCategoria
  );
  btnNewCategoria?.addEventListener("click", () => {
    myModal.setSelectedID(null);
    myModal.show();
  });

  myModal.setSubmitAction(() => registerCategoria(myModal.getSelectedID()));

  // enlazar eventos a los botones de acciones
  actionsEvents(
    editCategoria,
    deleteCategoria,
    restoreCategoria,
    (id: string) => {
      myModal.setSelectedID(id);
    }
  );
}

function restoreCategoria(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea restaurar esta categoria?",
    "",
    "Sí, restaurar",
    () => {
      apiClient
        .restore("Categorias/restaurar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Categoria restaurada con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function deleteCategoria(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea eliminar esta categoria?",
    "No podrá revertir esta acción",
    "Sí, eliminar",
    () => {
      apiClient
        .delete("Categorias/eliminar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Categoria eliminada con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function editCategoria(id: string) {
  myModal.setTitle("Editar Categoria");
  myModal.setBtnDone("Actualizar Categoria");

  apiClient
    .getById("Categorias/editar/", id)
    .then((resp) => {
      nombre_categoria.value = resp.nombre_categoria;
      codigoProducto.value = resp.codigoProducto;
    })
    .catch((error) => {
      MyAlert.alertError(getErrorMessage(error));
    });
  myModal.show();
}

async function registerCategoria(id: string | null) {
  if (id) {
    updateCategoria(id);
    return;
  }

  if (!validateFields([nombre_categoria])) {
    MyAlert.alertWarning("El campo nombre de categoría obligatorio");
    return;
  }

  try {
    const resp = await apiClient.create("Categorias/registrar", {
      nombre_categoria: nombre_categoria.value,
      codigoProducto: codigoProducto.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Categoria registrada con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

async function updateCategoria(id: string): Promise<void> {
  if (!validateFields([nombre_categoria])) {
    MyAlert.alertWarning("El campo nombre de categoría obligatorio");
    return;
  }
  try {
    const resp = await apiClient.update("Categorias/actualizar/", id, {
      nombre_categoria: nombre_categoria.value,
      codigoProducto: codigoProducto.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Categoria actualizada con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

function reloadLayout() {
  tbl_categorias.reload();
  myModal.reset();
  myModal.hide();
  // simula redireccion
  history.pushState(null, "", `${base_url}Categorias`);
}

document.addEventListener("DOMContentLoaded", () => {
  main();
});
