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
  }
}
