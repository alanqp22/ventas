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
const modalNewCaja = document.getElementById("mdl_new_user") as HTMLElement;
const modalTitle = document.getElementById("modalTitle")!;
const btnRegistrar = document.getElementById("btnRegistrarCaja")!;
let frmRegistrarCaja = document.getElementById(
  "frmRegistrarCaja"
) as HTMLFormElement;
const nick = document.getElementById("nick") as HTMLInputElement;
const name = document.getElementById("nombre") as HTMLInputElement;
const clave = document.getElementById("clave") as HTMLInputElement;
const confirm_clave = document.getElementById(
  "confirm_clave"
) as HTMLInputElement;
const divClave = document.getElementById("divClave")!;
const id_caja = document.getElementById("id_caja") as HTMLInputElement;

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
    myModal.showFields(divClave);
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
    "¿Está seguro de que desea restaurar este usuario?",
    "",
    "Sí, restaurar",
    () => {
      apiClient
        .restore("Cajas/restaurar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Usuario restaurado con éxito");
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
    "¿Está seguro de que desea eliminar este usuario?",
    "No podrá revertir esta acción",
    "Sí, eliminar",
    () => {
      apiClient
        .delete("Cajas/eliminar/", id)
        .then((resp) => {
          if (resp.status == "ok") {
            MyAlert.alertSuccess("Usuario eliminado con éxito");
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
  myModal.setTitle("Editar Usuario");
  myModal.setBtnDone("Actualizar Usuario");
  myModal.hideFields(divClave);

  apiClient
    .getById("Cajas/editar/", id)
    .then((resp) => {
      nick.value = resp.nick;
      name.value = resp.nombre;
      id_caja.value = resp.id_caja;
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

  if (!validateFields([nick, name, clave, confirm_clave, id_caja])) {
    MyAlert.alertWarning("Todos los campos son obligatorios");
    return;
  }

  try {
    const resp = await apiClient.create("Cajas/registrar", {
      nick: nick.value,
      nombre: name.value,
      clave: clave.value,
      confirm_clave: confirm_clave.value,
      id_caja: id_caja.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Usuario registrado con éxito");
      reloadLayout();
    }
  } catch (error) {
    MyAlert.alertError(getErrorMessage(error));
  }
}

async function updateCaja(id: string): Promise<void> {
  if (!validateFields([nick, name, id_caja])) {
    MyAlert.alertWarning("Todos los campos son obligatorios");
    return;
  }
  try {
    const resp = await apiClient.update("Cajas/actualizar/", id, {
      nick: nick.value,
      nombre: name.value,
      id_caja: id_caja.value,
    });
    if (resp.status == "ok") {
      MyAlert.alertSuccess("Usuario actualizado con éxito");
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
