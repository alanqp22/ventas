import ApiClient from "../services/ApiClient";

class Usuario {
  private apiClient: ApiClient;
  private resource: string = "Usuarios";
  constructor(apiClient: ApiClient) {
    this.apiClient = apiClient;
  }

  getTodos() {
    return this.apiClient.getAll("listar");
  }

  getPorId(id: string) {
    return this.apiClient.getById(this.resource, id);
  }

  crear(data: any) {
    return this.apiClient.create(this.resource, data);
  }

  actualizar(id: string, data: any) {
    return this.apiClient.update(this.resource, id, data);
  }

  eliminar(id: any) {
    return this.apiClient.delete(this.resource, id);
  }
}

export default Usuario;
