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
let tbl_clientes: MyTable;

// Elementos DOM del modal
const modalNewCliente = document.getElementById(
  "mdl_new_cliente"
) as HTMLElement;
const modalTitle = document.getElementById("modalTitle")!;
const btnRegistrar = document.getElementById("btnRegistrarCliente")!;
let frmRegistrarCliente = document.getElementById(
  "frmRegistrarCliente"
) as HTMLFormElement;
const nombre = document.getElementById("nombre") as HTMLInputElement;
const documentoid = document.getElementById("documentoid") as HTMLInputElement;
const complementoid = document.getElementById(
  "complementoid"
) as HTMLInputElement;
const correo = document.getElementById("correo") as HTMLInputElement;

// botón para abrir el modal
const btnNewCliente = document.getElementById("btnNewCliente")!;

async function main() {
  tbl_clientes = new MyTable(base_url, "Clientes/listar", "tblClientes", [
    "id_cliente",
    "razon_social",
    "documentoid",
    "complementoid",
    "cliente_email",
    "estado",
    "acciones",
  ]);

  myModal = new MyModal(
    modalNewCliente,
    modalTitle,
    btnRegistrar,
    frmRegistrarCliente
  );
  btnNewCliente?.addEventListener("click", () => {
    myModal.setSelectedID(null);
    myModal.show();
  });

  myModal.setSubmitAction(() => registerCliente(myModal.getSelectedID()));

  // enlazar eventos a los botones de acciones
  actionsEvents(editCliente, deleteCliente, restoreCliente, (id: string) => {
    myModal.setSelectedID(id);
  });
}

function restoreCliente(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea restaurar esta cliente?",
    "",
    "Sí, restaurar",
    () => {
      apiClient
        .restore("Clientes/restaurar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Cliente restaurada con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function deleteCliente(id: string) {
  MyAlert.alertWarningDialog(
    "¿Está seguro de que desea eliminar esta cliente?",
    "No podrá revertir esta acción",
    "Sí, eliminar",
    () => {
      apiClient
        .delete("Clientes/eliminar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Cliente eliminada con éxito");
            reloadLayout();
          }
        })
        .catch((error) => {
          MyAlert.alertError(getErrorMessage(error));
        });
    }
  );
}

function editCliente(id: string) {
  myModal.setTitle("Editar Cliente");
  myModal.setBtnDone("Actualizar Cliente");

  apiClient
    .getById("Clientes/editar/", id)
    .then((resp) => {
      nombre.value = resp.razon_social;
      documentoid.value = resp.documentoid;
      complementoid.value = resp.complementoid;
      correo.value = resp.cliente_email;
    })
    .catch((error) => {
      MyAlert.alertError(getErrorMessage(error));
    });
  myModal.show();
}

async function registerCliente(id: string | null) {
  if (id) {
    updateCliente(id);
    return;
  }

  if (!validateFields([nombre])) {
    MyAlert.alertWarning("Todos los campos son obligatorios");
    return;
  }

  try {
    const resp = await apiClient.create("Clientes/registrar", {
      razon_social: nombre.value,
      documentoid: documentoid.value,
      complementoid: complementoid.value,
      cliente_email: correo.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Cliente registrado con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

async function updateCliente(id: string): Promise<void> {
  if (!validateFields([nombre])) {
    MyAlert.alertWarning("Todos los campos son obligatorios");
    return;
  }
  try {
    const resp = await apiClient.update("Clientes/actualizar/", id, {
      razon_social: nombre.value,
      documentoid: documentoid.value,
      complementoid: complementoid.value,
      cliente_email: correo.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Cliente actualizado con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

function reloadLayout() {
  tbl_clientes.reload();
  myModal.reset();
  myModal.hide();
  // simula redireccion
  history.pushState(null, "", `${base_url}Clientes`);
}

document.addEventListener("DOMContentLoaded", () => {
  main();
});
