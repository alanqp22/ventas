let tblUsuarios;
document.addEventListener("DOMContentLoaded", function () {});

$(document).ready(function () {
  tblUsuarios = $("#tblUsuarios").DataTable({
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
});
function frmLogin(e) {
  e.preventDefault();
  let nick = document.getElementById("nick");
  let clave = document.getElementById("clave");
  if (nick.value == "") {
    clave.classList.remove("is-invalid");
    nick.classList.add("is-invalid");
  } else if (clave.value == "") {
    nick.classList.remove("is-invalid");
    clave.classList.add("is-invalid");
  } else {
    //Ambos campos llenos
    clave.classList.remove("is-invalid");
    nick.classList.remove("is-invalid");
    const url = `${base_url}Usuarios/validar`;
    const frm = document.getElementById("frmLogin");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "ok") {
          window.location = base_url + "Usuarios";
        } else {
          let alert = document.getElementById("alert");
          alert.classList.remove("d-none");
          alert.innerText = res;
        }
      }
    };
  }
}

function btnEditUser(id_user) {
  let modalTitle = document.getElementById("modalTitle");
  let btnRegistrar = document.getElementById("btnRegistrarUser");
  modalTitle.innerText = "Actualizar Usuario";
  btnRegistrar.innerText = "Actualizar Usuario";
  btnRegistrar.setAttribute("onclick", `actualizarUsuario(${id_user})`);

  const url = `${base_url}Usuarios/editar/${id_user}`;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      const id_usuario = document.getElementById("id_usuario");
      const nick = document.getElementById("nick");
      const name = document.getElementById("nombre");
      const id_caja = document.getElementById("id_caja");
      document.getElementById("divClave").classList.add("d-none");

      id_usuario.value = res.id_usuario;
      nick.value = res.nick;
      name.value = res.nombre;
      id_caja.value = res.id_caja;
    }
  };
  $("#mdl_new_user").modal("show");
}

function actualizarUsuario(id_user) {
  const form = document.getElementById("frmRegistrarUser");
  const nick = document.getElementById("nick");
  const name = document.getElementById("nombre");
  const clave = document.getElementById("clave");
  const confirm_clave = document.getElementById("confirm_clave");
}

function btnDeleteUser(id_user) {
  console.log(id_user);
}

function btnRestoreUser(id_user) {
  console.log(id_user);
}

function showModalUsuario() {
  let modalTitle = document.getElementById("modalTitle");
  let btnRegistrar = document.getElementById("btnRegistrarUser");
  document.getElementById("id_usuario").value = "";
  modalTitle.innerText = "Nuevo Usuario";
  btnRegistrar.innerText = "Registrar Usuario";
  btnRegistrar.setAttribute("onclick", `registrarUsuario(e)`);
  const form = document.getElementById("frmRegistrarUser");
  form.reset();
  document.getElementById("divClave").classList.remove("d-none");
  $("#mdl_new_user").modal("show");
}

async function registrarUsuario(e) {
  e.preventDefault();
  const form = document.getElementById("frmRegistrarUser");
  const nick = document.getElementById("nick");
  const name = document.getElementById("nombre");
  const clave = document.getElementById("clave");
  const confirm_clave = document.getElementById("confirm_clave");
  const id_caja = document.getElementById("id_caja");

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
    // Recargar la tabla de usuarios
    tblUsuarios.ajax.reload();
    // Limpiar el formulario
    form.reset();
    // Cerrar el modal
    $("#mdl_new_user").modal("hide");
  } else {
    // Mostrar mensaje de error
    Swal.fire({
      icon: "error",
      title: res,
      text: "",
    });
    form.reset();
  }
}

// function registrarUsuario(e) {
//   e.preventDefault();
//   const nick = document.getElementById("nick");
//   const name = document.getElementById("name");
//   const clave = document.getElementById("clave");
//   const confirm_clave = document.getElementById("confirm_clave");
//   const id_caja = document.getElementById("id_caja");
//   if (nick.value == "" || name.value == "" || clave.value == "") {
//     $msg = "todos los campos son obligatorios";
//   } else {
//     const url = `${base_url}Usuarios/registrar`;
//     const frm = document.getElementById("frmRegistrarUser");
//     const http = new XMLHttpRequest();
//     http.open("POST", url, true);
//     http.send(new FormData(frm));
//     http.onreadystatechange = function () {
//       if (this.readyState == 4 && this.status == 200) {
//         const res = JSON.parse(this.responseText);
//         if (res == "ok") {
//           $msg = "Usuario registrado con éxito";
//         } else {
//           $msg = "Error al registrar el usuario";
//         }
//       }
//     };
//   }
// }
