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
let tbl_cajas: MyTable;

// Elementos DOM del modal
const modalNewCaja = document.getElementById("mdl_new_caja") as HTMLElement;
const modalTitle = document.getElementById("modalTitle")!;
const btnRegistrar = document.getElementById("btnRegistrarCaja")!;
let frmRegistrarCaja = document.getElementById(
  "frmRegistrarCaja"
) as HTMLFormElement;
const name = document.getElementById("nombre") as HTMLInputElement;

// botón para abrir el modal
const btnNewCaja = document.getElementById("btnNewCaja")!;

async function main() {
  tbl_cajas = new MyTable(base_url, "Cajas/listar", "tblCajas", [
    "id_caja",
    "nombre",
    "estado",
    "acciones",
  ]);

  myModal = new MyModal(
    modalNewCaja,
    modalTitle,
    btnRegistrar,
    frmRegistrarCaja
  );
  btnNewCaja?.addEventListener("click", () => {
    myModal.setSelectedID(null);
    myModal.show();
  });

  myModal.setSubmitAction(() => registerCaja(myModal.getSelectedID()));

  // enlazar eventos a los botones de acciones
  actionsEvents(editCaja, deleteCaja, restoreCaja, (id: string) => {
    myModal.setSelectedID(id);
  });
}

function restoreCaja(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea restaurar esta caja?",
    "",
    "Sí, restaurar",
    () => {
      apiClient
        .restore("Cajas/restaurar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Caja restaurada con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function deleteCaja(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea eliminar esta caja?",
    "No podrá revertir esta acción",
    "Sí, eliminar",
    () => {
      apiClient
        .delete("Cajas/eliminar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Caja eliminada con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function editCaja(id: string) {
  myModal.setTitle("Editar Caja");
  myModal.setBtnDone("Actualizar Caja");

  apiClient
    .getById("Cajas/editar/", id)
    .then((resp) => {
      name.value = resp.nombre;
    })
    .catch((error) => {
      MyAlert.alertError(getErrorMessage(error));
    });
  myModal.show();
}

async function registerCaja(id: string | null) {
  if (id) {
    updateCaja(id);
    return;
  }

  if (!validateFields([name])) {
    MyAlert.alertWarning("Todos los campos son obligatorios");
    return;
  }

  try {
    const resp = await apiClient.create("Cajas/registrar", {
      nombre: name.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Caja registrada con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

async function updateCaja(id: string): Promise<void> {
  if (!validateFields([name])) {
    MyAlert.alertWarning("Todos los campos son obligatorios");
    return;
  }
  try {
    const resp = await apiClient.update("Cajas/actualizar/", id, {
      nombre: name.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Caja actualizada con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

function reloadLayout() {
  tbl_cajas.reload();
  myModal.reset();
  myModal.hide();
  // simula redireccion
  history.pushState(null, "", `${base_url}Cajas`);
}

document.addEventListener("DOMContentLoaded", () => {
  main();
});
