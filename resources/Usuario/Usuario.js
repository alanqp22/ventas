class Usuario {
  constructor(apiClient) {
    this.apiClient = apiClient;
    this.resource = "Usuarios/listar"; // Este debe coincidir con el nombre del archivo PHP: usuario.php
  }

  getTodos() {
    return this.apiClient.getAll(this.resource);
  }

  getPorId(id) {
    return this.apiClient.getById(this.resource, id);
  }

  crear(data) {
    return this.apiClient.create(this.resource, data);
  }

  actualizar(id, data) {
    return this.apiClient.update(this.resource, id, data);
  }

  eliminar(id) {
    return this.apiClient.delete(this.resource, id);
  }
}

export default Usuario;
