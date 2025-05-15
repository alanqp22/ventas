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
let tbl_medidas: MyTable;

// Elementos DOM del modal
const modalNewMedida = document.getElementById("mdl_new_medida") as HTMLElement;
const modalTitle = document.getElementById("modalTitle")!;
const btnRegistrar = document.getElementById("btnRegistrarMedida")!;
let frmRegistrarMedida = document.getElementById(
  "frmRegistrarMedida"
) as HTMLFormElement;
const descripcion_medida = document.getElementById(
  "descripcion_medida"
) as HTMLInputElement;
const descripcion_corta = document.getElementById(
  "descripcion_corta"
) as HTMLInputElement;

// botón para abrir el modal
const btnNewMedida = document.getElementById("btnNewMedida")!;

async function main() {
  tbl_medidas = new MyTable(base_url, "Medidas/listar", "tblMedidas", [
    "id_medida",
    "descripcion_medida",
    "descripcion_corta",
    "estado",
    "acciones",
  ]);

  myModal = new MyModal(
    modalNewMedida,
    modalTitle,
    btnRegistrar,
    frmRegistrarMedida
  );
  btnNewMedida?.addEventListener("click", () => {
    myModal.setSelectedID(null);
    myModal.show();
  });

  myModal.setSubmitAction(() => registerMedida(myModal.getSelectedID()));

  // enlazar eventos a los botones de acciones
  actionsEvents(editMedida, deleteMedida, restoreMedida, (id: string) => {
    myModal.setSelectedID(id);
  });
}

function restoreMedida(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea restaurar esta medida?",
    "",
    "Sí, restaurar",
    () => {
      apiClient
        .restore("Medidas/restaurar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Medida restaurada con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function deleteMedida(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea eliminar esta medida?",
    "No podrá revertir esta acción",
    "Sí, eliminar",
    () => {
      apiClient
        .delete("Medidas/eliminar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Medida eliminada con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function editMedida(id: string) {
  myModal.setTitle("Editar Medida");
  myModal.setBtnDone("Actualizar Medida");

  apiClient
    .getById("Medidas/editar/", id)
    .then((resp) => {
      descripcion_medida.value = resp.descripcion_medida;
      descripcion_corta.value = resp.descripcion_corta;
    })
    .catch((error) => {
      MyAlert.alertError(getErrorMessage(error));
    });
  myModal.show();
}

async function registerMedida(id: string | null) {
  if (id) {
    updateMedida(id);
    return;
  }

  if (!validateFields([descripcion_medida])) {
    MyAlert.alertWarning("El campo nombre de medida obligatorio");
    return;
  }

  try {
    const resp = await apiClient.create("Medidas/registrar", {
      descripcion_medida: descripcion_medida.value,
      descripcion_corta: descripcion_corta.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Medida registrada con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

async function updateMedida(id: string): Promise<void> {
  if (!validateFields([descripcion_medida])) {
    MyAlert.alertWarning("El campo nombre de medida obligatorio");
    return;
  }
  try {
    const resp = await apiClient.update("Medidas/actualizar/", id, {
      descripcion_medida: descripcion_medida.value,
      descripcion_corta: descripcion_corta.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Medida actualizada con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

function reloadLayout() {
  tbl_medidas.reload();
  myModal.reset();
  myModal.hide();
  // simula redireccion
  history.pushState(null, "", `${base_url}Medidas`);
}

document.addEventListener("DOMContentLoaded", () => {
  main();
});
