class ApiClient {
  private baseURL: string;

  constructor(baseURL: string = "") {
    this.baseURL = baseURL;
  }

  private async request(
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
        const message =
          typeof result === "string"
            ? result
            : result?.message || "Error en la solicitud";
        throw new Error(message);
      }
      // Normalizar respuesta si es texto plano "ok"
      if (typeof result === "string") {
        return { status: result }; // convierte "ok" en { status: "ok" }
      }
      return result;
    } catch (error) {
      console.error(`[${method}] ${endpoint} →`, (error as any).message);

      throw error;
    }
  }

  public getAll(resource: string, headers = {}) {
    return this.request(resource, "GET", null, headers);
  }

  public getById(resource: string, id: string, headers = {}) {
    return this.request(`${resource}${id}`, "GET", null, headers);
  }

  public getByIdPost(resource: string, data: any, headers = {}) {
    return this.request(`${resource}`, "POST", data, headers);
  }

  public async create(resource: string, data: any, headers = {}) {
    return await this.request(`${resource}`, "POST", data, headers);
  }

  public async update(resource: string, id: string, data: any, headers = {}) {
    return await this.request(`${resource}${id}`, "PUT", data, headers);
  }

  public delete(resource: string, id: string, headers = {}) {
    return this.request(`${resource}${id}`, "DELETE", null, headers);
  }

  public restore(resource: string, id: string, headers = {}) {
    return this.request(`${resource}${id}`, "PUT", null, headers);
  }
}

export default ApiClient;
