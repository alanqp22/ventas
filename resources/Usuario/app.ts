// import ApiClient from "../services/ApiClient";
// import Usuario from "./Usuario";
import Swal from "sweetalert2";
import $ from "jquery";
import "datatables.net";
import "datatables.net-dt/css/dataTables.dataTables.min.css";
import "bootstrap";
import { Modal } from "bootstrap";
declare const base_url: string;

let frmRegistrarUser = document.getElementById(
  "frmRegistrarUser"
) as HTMLFormElement;
let btnRegistrar = document.getElementById("btnRegistrarUser");
let btnNewUser = document.getElementById("btnNewUser");

let btnDeleteUser = document.getElementById("btnDeleteUser");
let inputIdUser = document.getElementById("id_usuario") as HTMLInputElement;

const modalNewUser = document.getElementById("mdl_new_user") as HTMLElement;
let modalInstance: Modal;
if (btnNewUser && modalNewUser) {
  modalInstance = new Modal(modalNewUser);
  btnNewUser.addEventListener("click", () => showModalRegister(modalInstance));
}

let modalTitle = document.getElementById("modalTitle");
let divClave = document.getElementById("divClave");
// const apiClient = new ApiClient(`${base_url}Usuarios/`);
// const usuario = new Usuario(apiClient);
let tblUsuarios: DataTables.Api;

async function main() {
  tblUsuarios = await initDataTable();
  btnNewUser?.addEventListener("click", () =>
    showModalRegister(modalInstance, "registrar")
  );
  frmRegistrarUser?.addEventListener("submit", function (e) {
    e.preventDefault();
    submitFrmRegistrarUser();
  });
  window.addEventListener("DOMContentLoaded", () => {
    document.body.addEventListener("click", (e) => {
      // Encontramos el botón que fue clickeado, no importa si es el icono o el botón
      const target = e.target as HTMLElement;

      // Usamos closest para subir hasta el botón que contiene la clase 'btnEditarUser'
      const btn = target.closest(".btnEditarUser");

      if (btn) {
        const id = btn.getAttribute("data-id");
        if (id) {
          editUser(id); // Llamar a la función de edición
        }
      }
    });
  });
}

function editUser(id: string) {
  console.log("hola");

  inputIdUser.value = id;
  modalTitle !== null ? (modalTitle.innerText = "Editar Usuario") : "";
  btnRegistrar !== null ? (btnRegistrar.innerText = "Actualizar Usuario") : "";
  divClave !== null ? divClave.classList.add("d-none") : "";
  showModalRegister(modalInstance, "Editar Usuario");
}

async function submitFrmRegistrarUser() {
  const nick = document.getElementById("nick") as HTMLInputElement;
  const name = document.getElementById("nombre") as HTMLInputElement;
  const clave = document.getElementById("clave") as HTMLInputElement;
  const confirm_clave = document.getElementById(
    "confirm_clave"
  ) as HTMLInputElement;
  const id_caja = document.getElementById("id_caja") as HTMLInputElement;

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

  const respuesta = await fetch(`${base_url}Usuarios/registrar`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      nick: nick.value,
      nombre: name.value,
      clave: clave.value,
      confirm_clave: confirm_clave.value,
      id_caja: id_caja.value,
    }),
  });

  const res = await respuesta.json();
  if (res == "ok") {
    // Mostrar mensaje de éxito
    Swal.fire({
      icon: "success",
      title: "Usuario registrado con éxito",
    });
    if (tblUsuarios) {
      tblUsuarios.ajax.reload();
    } else {
      console.log("no se instancion datatable");
    }

    // Recargar la tabla de usuarios
    // Limpiar el formulario
    frmRegistrarUser?.reset();
    // Cerrar el modal
    hideModalRegister(modalInstance);
    // simula redireccion
    history.pushState(null, "", `${base_url}Usuarios`);
  } else {
    // Mostrar mensaje de error
    Swal.fire({
      icon: "error",
      title: res,
      text: "",
    });
    frmRegistrarUser.reset();
  }
}

function showModalRegister(modalInstance: Modal, title: string) {
  inputIdUser.value = "";
  modalTitle !== null ? (modalTitle.innerText = title) : "";
  btnRegistrar !== null ? (btnRegistrar.innerText = "Registrar Usuario") : "";

  frmRegistrarUser.reset();
  divClave !== null ? divClave.classList.remove("d-none") : "";
  modalInstance.show();
}

function hideModalRegister(modalInstance: Modal) {
  modalInstance.hide();
}

async function initDataTable(): Promise<DataTables.Api> {
  // Espera a que el DOM esté listo
  await new Promise<void>((resolve) => {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => resolve());
    } else {
      resolve();
    }
  });

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

main();
