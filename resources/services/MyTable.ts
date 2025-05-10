import "datatables.net";
import $ from "jquery";
import "datatables.net-dt/css/dataTables.dataTables.min.css";

class MyTable {
  private myDataTable: DataTables.Api;

  constructor(
    base_url: string,
    endpoint: string,
    idTable: string,
    campos: string[]
  ) {
    this.myDataTable = $(`#${idTable}`).DataTable({
      language: {
        infoEmpty: "Ningún registro disponible",
        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
        lengthMenu: "_MENU_ &nbsp;&nbsp;registros por página",
        search: "Buscar:&nbsp;",
        zeroRecords: "No se encontraron resultados",
        infoFiltered: "(filtrado de _MAX_ registros totales)",
      },
      ajax: {
        url: `${base_url}${endpoint}`,
        dataSrc: "",
      },
      columns: this.getCols(campos),
    });
  }

  private getCols(campos: string[]) {
    let cols = campos.map((col) => {
      return {
        data: col,
      };
    });
    return cols;
  }

  public reload() {
    this.myDataTable.ajax.reload();
  }

  public getTable() {
    return this.myDataTable;
  }

  public reset() {
    this.myDataTable.clear().draw();
  }
  public destroy() {
    this.myDataTable.destroy();
  }
}

export default MyTable;
