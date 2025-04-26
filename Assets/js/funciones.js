let tblUsuarios;
document.addEventListener("DOMContentLoaded", function () {
  
});

$(document).ready(function () {
  $("#tblUsuarios").DataTable({
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


function btnEditUser(id_user){
  console.log(id_user);
  
}

function btnDeleteUser(id_user){
  console.log(id_user);
}

function btnRestoreUser(id_user){
  console.log(id_user);
  
}