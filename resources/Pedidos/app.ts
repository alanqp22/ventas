import ApiClient from "../services/ApiClient";
import MyAlert from "../services/MyAlert";
import { getErrorMessage } from "../services/functions";
import "bootstrap";
declare const base_url: string;

const inptDocumentoId = document.getElementById(
  "documentoid"
) as HTMLInputElement;

const btnDocumentoId = document.getElementById(
  "btnDocumentoId"
) as HTMLButtonElement;

const btnCodigo = document.getElementById("btnCodigo") as HTMLButtonElement;

const razon_social = document.getElementById(
  "razon_social"
) as HTMLInputElement;
const cliente_email = document.getElementById(
  "cliente_email"
) as HTMLInputElement;

const id_cliente = document.getElementById("id_cliente") as HTMLInputElement;

async function main() {
  const apiClient = new ApiClient(base_url);
  btnDocumentoId.addEventListener("click", () => buscarCliente(apiClient));
  btnCodigo.addEventListener("click", () => buscarProducto(apiClient));
}

async function buscarCliente(apiClient: ApiClient) {
  apiClient
    .getByIdPost("Pedidos/buscarCliente/", {
      documentoid: inptDocumentoId.value,
    })
    .then((resp) => {
      id_cliente.value = resp.id_cliente;
      razon_social.value = resp.razon_social;
      cliente_email.value = resp.cliente_email;
    })
    .catch((error) => {
      MyAlert.alertWarning(getErrorMessage(error));
    });
}

async function buscarProducto(apiClient: ApiClient) {
  apiClient
    .getByIdPost("Pedidos/buscarProducto/", {
      documentoid: inptDocumentoId.value,
    })
    .then((resp) => {
      id_cliente.value = resp.id_cliente;
      razon_social.value = resp.razon_social;
      cliente_email.value = resp.cliente_email;
    })
    .catch((error) => {
      MyAlert.alertWarning(getErrorMessage(error));
    });
}

document.addEventListener("DOMContentLoaded", () => {
  main();
});
