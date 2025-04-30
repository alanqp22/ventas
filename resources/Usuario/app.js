import ApiClient from "../services/ApiClient.js";
import Usuario from "./Usuario.js";
const apiClient = new ApiClient(base_url);
const usuario = new Usuario(apiClient);

let tblUsuarios;

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

usuario.getTodos().then((data) => {});
