class ApiClient {
  baseURL: string;
  constructor(baseURL: string = "") {
    this.baseURL = baseURL;
  }

  async request(
    endpoint: string,
    method: string = "GET",
    data: any = null,
    headers: Record<string, string> = {}
  ) {
    const config: RequestInit = {
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
        throw new Error((result as any).message || "Error en la solicitud");
      }

      return result;
    } catch (error) {
      console.error(`[${method}] ${endpoint} →`, (error as any).message);
      throw error;
    }
  }

  getAll(resource: string, headers = {}) {
    return this.request(resource, "GET", null, headers);
  }

  getById(resource: string, id: string, headers = {}) {
    return this.request(`${resource}.php?id=${id}`, "GET", null, headers);
  }

  create(resource: string, data: any, headers = {}) {
    return this.request(`${resource}.php`, "POST", data, headers);
  }

  update(resource: string, id: string, data: any, headers = {}) {
    return this.request(`${resource}.php?id=${id}`, "PUT", data, headers);
  }

  delete(resource: string, id: string, headers = {}) {
    return this.request(`${resource}.php?id=${id}`, "DELETE", null, headers);
  }
}

export default ApiClient;
