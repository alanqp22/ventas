import "bootstrap";
import ApiClient from "../services/ApiClient";
import MyAlert from "../services/MyAlert";
import { getErrorMessage } from "../services/functions";

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

const inptActEconomica = document.getElementById(
  "actEconomica"
) as HTMLInputElement;

const id_cliente = document.getElementById("id_cliente") as HTMLInputElement;

// PRODUCTO
const inptCodigo = document.getElementById("codigo") as HTMLInputElement;
const inptCodigoProducto = document.getElementById(
  "codigoProducto"
) as HTMLInputElement;
const inptNombreProducto = document.getElementById(
  "nombre_producto"
) as HTMLInputElement;
const inptUMedida = document.getElementById(
  "descripcion_corta"
) as HTMLInputElement;
const inptCantidad = document.getElementById("cantidad") as HTMLInputElement;
const inptPrecioVenta = document.getElementById(
  "precio_venta"
) as HTMLInputElement;

const btnAgregarItem = document.getElementById(
  "btnAgregarItem"
) as HTMLButtonElement;

const inptDescuento = document.getElementById("descuento") as HTMLInputElement;
const inptSTotal = document.getElementById("sTotal") as HTMLInputElement;

// DETALLES
type ProductoType = {
  actEconomica: string;
  codigoProducto: string;
  codigo: string;
  nombre_producto: string;
  cantProducto: string;
  unidadMedida: string;
  precio_venta: string;
  descProducto: string;
  sTotal: string;
};
let arrProductos: ProductoType[] = [];
const tblDetalles = document.getElementById(
  "tblDetalles"
) as HTMLTableSectionElement;

// TOTALES RESUMEN
const inptResSubTotal = document.getElementById(
  "resSubTotal"
) as HTMLInputElement;
const inptResDesc = document.getElementById("resDesc") as HTMLInputElement;
const inptResTotal = document.getElementById("resTotal") as HTMLInputElement;

async function main() {
  const apiClient = new ApiClient(base_url);
  btnDocumentoId.addEventListener("click", () => buscarCliente(apiClient));
  btnCodigo.addEventListener("click", () => buscarProducto(apiClient));
  btnAgregarItem.addEventListener("click", addProducto);
  inptResDesc.addEventListener("keyup", calcDescAdd);
  inptResDesc.addEventListener("change", calcDescAdd);
}
/**
 * Carga los detalles segun requerimiento del SIN
 */
function addProducto() {
  if (
    inptCodigo.value == "" ||
    inptNombreProducto.value == "" ||
    inptPrecioVenta.value == ""
  )
    return;

  let detallesObj = {
    actEconomica: inptActEconomica.value,
    codigoProducto: inptCodigoProducto.value,
    codigo: inptCodigo.value,
    nombre_producto: inptNombreProducto.value,
    cantProducto: inptCantidad.value,
    unidadMedida: inptUMedida.value,
    precio_venta: inptPrecioVenta.value,
    descProducto: inptDescuento.value,
    sTotal: inptSTotal.value,
  };
  arrProductos.push(detallesObj);
  armarTblPedidos();
  calcResTotales();
  clearItems();
}

function armarTblPedidos() {
  if (!tblDetalles) return;
  tblDetalles.innerHTML = "";
  arrProductos.forEach((detalle, idx) => {
    const fila = document.createElement("tr");

    // formato de moneda y numeros
    const precio = parseFloat(detalle.precio_venta).toFixed(2);
    const descuento = parseFloat(detalle.descProducto).toFixed(2);
    const subtotal = parseFloat(detalle.sTotal).toFixed(2);

    const btnDeleteRow = document.createElement("button");
    btnDeleteRow.type = "button";
    btnDeleteRow.classList.add("btn", "btn-danger", "btn-sm");
    btnDeleteRow.innerHTML = `<i class="fas fa-minus"></i>`;
    btnDeleteRow.title = "Eliminar producto";
    btnDeleteRow.addEventListener("click", () => {
      arrProductos.splice(idx, 1);
      armarTblPedidos();
    });
    fila.innerHTML = `
        <td>${detalle.nombre_producto}</td>
        <td>${detalle.cantProducto}</td>
        <td>${precio}</td>
        <td>${descuento}</td>
        <td>${subtotal}</td>
        <td></td>
        `;
    (fila.lastElementChild as HTMLTableCellElement).appendChild(btnDeleteRow);
    tblDetalles.appendChild(fila);
  });
}

function calcResTotales() {
  let subTotal: number = 0;
  arrProductos.forEach((item) => {
    subTotal += parseFloat(item.sTotal);
  });
  inptResSubTotal.value = subTotal.toFixed(2);
  calcDescAdd();
}

function calcDescAdd() {
  if (parseFloat(inptResSubTotal.value) == 0) return; // no hay productos seleccionados
  inptResTotal.value = (
    parseFloat(inptResSubTotal.value) - parseFloat(inptResDesc.value)
  ).toFixed(2);
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
      codigo: inptCodigo.value,
    })
    .then((resp) => {
      inptCodigoProducto.value = resp.codigoProducto;
      inptNombreProducto.value = resp.nombre_producto;
      inptUMedida.value = resp.descripcion_corta;
      inptPrecioVenta.value = resp.precio_venta;
      inptSTotal.value = (
        parseFloat(inptCantidad.value) * resp.precio_venta -
        parseFloat(inptDescuento.value)
      )
        .toFixed(2)
        .toString();
      inptCantidad.addEventListener("change", () => {
        inptSTotal.value = (
          parseFloat(inptCantidad.value) * resp.precio_venta -
          parseFloat(inptDescuento.value)
        )
          .toFixed(2)
          .toString();
      });
      inptDescuento.addEventListener("change", () => {
        inptSTotal.value = (
          parseFloat(inptCantidad.value) * resp.precio_venta -
          parseFloat(inptDescuento.value)
        )
          .toFixed(2)
          .toString();
      });
    })
    .catch((error) => {
      MyAlert.alertWarning(getErrorMessage(error));
    });
}

function clearItems() {
  inptCodigoProducto.value = "";
  inptCodigo.value = "";
  inptNombreProducto.value = "";
  inptUMedida.value = "";
  inptCantidad.value = "1";
  inptPrecioVenta.value = "0.00";
  inptDescuento.value = "0.00";
  inptSTotal.value = "0.00";
}

document.addEventListener("DOMContentLoaded", () => {
  main();
});
