import ApiClient from "../services/ApiClient";

import Swal from "sweetalert2";
import $ from "jquery";
import "datatables.net";
import "datatables.net-dt/css/dataTables.dataTables.min.css";
import "bootstrap";
import { Modal } from "bootstrap";
import MyModal from "../services/MyModal";

declare const base_url: string;

let id_usuario = "";
let tblUsuarios: DataTables.Api;
let myModal: MyModal;
const apiClient = new ApiClient(base_url);

// Elementos DOM del modal
const modalNewUser = document.getElementById("mdl_new_user") as HTMLElement;
let modalTitle = document.getElementById("modalTitle");
let btnRegistrar = document.getElementById("btnRegistrarUser");
let frmRegistrarUser = document.getElementById(
  "frmRegistrarUser"
) as HTMLFormElement;
const nick = document.getElementById("nick") as HTMLInputElement;
const name = document.getElementById("nombre") as HTMLInputElement;
const clave = document.getElementById("clave") as HTMLInputElement;
const confirm_clave = document.getElementById(
  "confirm_clave"
) as HTMLInputElement;
let divClave = document.getElementById("divClave");
const id_caja = document.getElementById("id_caja") as HTMLInputElement;

// botón para abrir el modal
let btnNewUser = document.getElementById("btnNewUser");

async function main() {
  const modalInstance = new Modal(modalNewUser);
  myModal = new MyModal(
    modalInstance,
    modalTitle!,
    btnRegistrar!,
    frmRegistrarUser
  );
  btnNewUser?.addEventListener("click", () => {
    id_usuario = "";
    myModal.showFields(divClave!);
    myModal.show();
  });

  myModal.setSubmitAction(submitFrmRegistrarUser);
  frmRegistrarUser?.addEventListener("submit", function (e) {
    e.preventDefault();
  });

  tblUsuarios = await initDataTable();

  // Editar y eliminar usuario
  document.body.addEventListener("click", (e) => {
    // Encontramos el botón que fue clickeado, no importa si es el icono o el botón
    const target = e.target as HTMLElement;

    // Usamos closest para subir hasta el botón que contiene la clase 'btnEditarUser'
    const btn = target.closest(".btnEditarUser");
    const btnDelete = target.closest(".btnDeleteUser");
    const btnRestore = target.closest(".btnRestoreUser");

    if (btn) {
      const id = btn.getAttribute("data-id");
      if (id) {
        id_usuario = id;
        editUser();
      }
    } else if (btnDelete) {
      const id = btnDelete.getAttribute("data-id");
      if (id) {
        id_usuario = id;
        deleteUser();
      }
    } else if (btnRestore) {
      const id = btnRestore.getAttribute("data-id");
      if (id) {
        id_usuario = id;
        restoreUser();
      }
    }
  });
}

function restoreUser() {
  Swal.fire({
    title: "¿Está seguro de que desea restaurar este usuario?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, restaurar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      apiClient
        .restore("Usuarios/restaurar/", id_usuario)
        .then((resp) => {
          if (resp.status == "ok") {
            Swal.fire({
              icon: "success",
              title: "Usuario restaurado con éxito",
            });
            reloadLayout();
          }
        })
        .catch((error) => {
          Swal.fire({
            icon: "error",
            title: (error as any).message || "Error",
          });
        });
    }
  });
}

function deleteUser() {
  Swal.fire({
    title: "¿Está seguro de que desea eliminar este usuario?",
    text: "No podrá revertir esta acción",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      apiClient
        .delete("Usuarios/eliminar/", id_usuario)
        .then((resp) => {
          if (resp.status == "ok") {
            Swal.fire({
              icon: "success",
              title: "Usuario eliminado con éxito",
            });
            reloadLayout();
          }
        })
        .catch((error) => {
          Swal.fire({
            icon: "error",
            title: (error as any).message || "Error",
          });
        });
    }
  });
}

function editUser() {
  myModal.setTitle("Editar Usuario");
  myModal.setBtnDone("Actualizar Usuario");
  myModal.hideFields(divClave!);

  apiClient
    .getById("Usuarios/editar/", id_usuario)
    .then((resp) => {
      nick.value = resp.nick;
      name.value = resp.nombre;
      id_caja.value = resp.id_caja;
    })
    .catch((error) => {
      Swal.fire({
        icon: "error",
        title: (error as any).message || "Error",
      });
    });
  myModal.show();
}

async function submitFrmRegistrarUser(e: Event) {
  if (id_usuario) {
    updateUser(e);
    return;
  }

  e.preventDefault();

  if (
    nick.value == "" ||
    name.value == "" ||
    clave.value == "" ||
    confirm_clave.value == "" ||
    id_caja.value == ""
  ) {
    Swal.fire({
      icon: "error",
      title: "Todos los campos son obligatorios",
    });
    return;
  }

  try {
    const resp = await apiClient.create("Usuarios/registrar", {
      nick: nick.value,
      nombre: name.value,
      clave: clave.value,
      confirm_clave: confirm_clave.value,
      id_caja: id_caja.value,
    });
    if (resp.status == "ok") {
      Swal.fire({
        icon: "success",
        title: "Usuario registrado con éxito",
      });
      reloadLayout();
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: (error as any).message || "Error",
      text: "Por favor, inténtelo de nuevo más tarde.",
    });
  }
}

async function updateUser(e: Event): Promise<void> {
  e.preventDefault();

  try {
    const resp = await apiClient.update("Usuarios/actualizar/", id_usuario, {
      nick: nick.value,
      nombre: name.value,
      id_caja: id_caja.value,
    });
    if (resp.status == "ok") {
      Swal.fire({
        icon: "success",
        title: "Usuario actualizado con éxito",
      });
      reloadLayout();
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: (error as any).message || "Error",
      text: "Por favor, inténtelo de nuevo más tarde.",
    });
  }
}

function reloadLayout() {
  if (tblUsuarios) {
    tblUsuarios.ajax.reload();
  } else {
    console.log("No se pudo recargar la tabla de usuarios");
  }

  // Limpiar el formulario y ocultar el modal
  myModal.reset();
  myModal.hide();
  // simula redireccion
  history.pushState(null, "", `${base_url}Usuarios`);
}

async function initDataTable(): Promise<DataTables.Api> {
  // Inicializa DataTable
  const tblUsuarios = $("#tblUsuarios").DataTable({
    language: {
      infoEmpty: "Ningún registro disponible",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      lengthMenu: "_MENU_ &nbsp;&nbsp;registros por página",
      search: "Buscar:&nbsp;",
      zeroRecords: "No se encontraron resultados",
      infoFiltered: "(filtrado de _MAX_ registros totales)",
    },
    ajax: {
      url: `${base_url}Usuarios/listar`,
      dataSrc: "",
    },
    columns: [
      { data: "id_usuario" },
      { data: "nick" },
      { data: "nombre" },
      { data: "caja" },
      { data: "estado" },
      { data: "acciones" },
    ],
  });

  return tblUsuarios;
}

document.addEventListener("DOMContentLoaded", () => {
  main();
});
