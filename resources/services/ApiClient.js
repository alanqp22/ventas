class ApiClient {
  constructor(baseURL = "") {
    this.baseURL = baseURL;
  }

  async request(endpoint, method = "GET", data = null, headers = {}) {
    const config = {
      method,
      headers: {
        "Content-Type": "application/json",
        ...headers,
      },
    };

    if (data) {
      config.body = JSON.stringify(data);
    }

    try {
      const response = await fetch(this.baseURL + endpoint, config);
      const contentType = response.headers.get("Content-Type");

      const result =
        contentType && contentType.includes("application/json")
          ? await response.json()
          : await response.text();

      if (!response.ok) {
        throw new Error(result.message || "Error en la solicitud");
      }

      return result;
    } catch (error) {
      console.error(`[${method}] ${endpoint} →`, error.message);
      throw error;
    }
  }

  getAll(resource, headers = {}) {
    return this.request(resource, "GET", null, headers);
  }

  getById(resource, id, headers = {}) {
    return this.request(`${resource}.php?id=${id}`, "GET", null, headers);
  }

  create(resource, data, headers = {}) {
    return this.request(`${resource}.php`, "POST", data, headers);
  }

  update(resource, id, data, headers = {}) {
    return this.request(`${resource}.php?id=${id}`, "PUT", data, headers);
  }

  delete(resource, id, headers = {}) {
    return this.request(`${resource}.php?id=${id}`, "DELETE", null, headers);
  }
}

export default ApiClient;
