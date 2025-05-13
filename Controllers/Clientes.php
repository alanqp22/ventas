<?php
class Clientes extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        $resources = "Clientes/app";
        $this->views->getView($this, "index", array('resources' => $resources));
    }

    public function listar()
    {
        $data = $this->model->getClientes();
        for ($i = 0; $i < count($data); $i++) {
            $id = (int)$data[$i]["id_cliente"];
            if ($data[$i]["cliente_estado"] == 1) {
                $data[$i]["estado"] = '<span class="badge text-bg-primary">Activo</span>';
                $data[$i]["acciones"] = <<<HTML
          <button class="btn btn-primary" data-action="edit" data-id="$id">
            <i class="fas fa-edit"></i>
          </button>
          <button class="btn btn-danger" data-action="delete" data-id="$id">
            <i class="fas fa-trash"></i>
          </button>
        HTML;
            } else {
                $data[$i]["estado"] = '<span class="badge text-bg-danger">Inactivo</span>';
                $data[$i]["acciones"] = '';
                $data[$i]["acciones"] = <<<HTML
          <button class="btn btn-success" data-action="restore" data-id="$id">
            <i class="fas fa-trash-can-arrow-up"></i>
          </button>
        HTML;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function editar(int $id)
    {
        header('Content-Type: application/json; charset=utf-8');
        $data = $this->model->getClienteById($id);
        if (!$data) {
            http_response_code(409);
            echo json_encode(['message' => 'El cliente no existe'], JSON_UNESCAPED_UNICODE);
            return;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        return;
    }

    public function restaurar(int $id)
    {
        header('Content-Type: application/json; charset=utf-8');
        if (!$this->validateMethod("PUT")) return;
        if (!$this->model->getClienteById($id)) {
            http_response_code(409);
            echo json_encode(['message' => 'El cliente no existe'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $result = $this->model->restaurarCliente($id);

        if ($result === "ok") {
            http_response_code(200); // OK
            echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Error al restaurar el cliente'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function eliminar(int $id)
    {
        header('Content-Type: application/json; charset=utf-8');
        if (!$this->validateMethod("DELETE")) return;

        if (!$this->model->getClienteById($id)) {
            http_response_code(409);
            echo json_encode(['message' => 'El cliente no existe'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $result = $this->model->eliminarCliente($id);

        if ($result === "ok") {
            http_response_code(200); // OK
            echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Error al eliminar el cliente'], JSON_UNESCAPED_UNICODE);
        }
    }


    public function actualizar(int $id_cliente)
    {
        try {
            if (!$this->validateMethod("PUT")) return;
            header('Content-Type: application/json; charset=utf-8');

            $input = json_decode(file_get_contents("php://input"), true);
            $required = ['razon_social', 'documentoid', 'complementoid', 'cliente_email'];

            foreach ($required as $field) {
                if (empty($input[$field])) {
                    http_response_code(400); // Bad Request
                    echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
                    return;
                }
            }


            $razon_social = trim(htmlspecialchars($input['razon_social']));
            $documentoid = trim(htmlspecialchars($input['documentoid']));
            $complementoid = trim(htmlspecialchars($input['complementoid']));
            $cliente_email = trim(htmlspecialchars($input['cliente_email']));


            if (!$this->model->getClienteById($id_cliente)) {
                http_response_code(409);
                echo json_encode(['message' => 'El cliente no existe'], JSON_UNESCAPED_UNICODE);
                return;
            }

            $result = $this->model->actualizarCliente($id_cliente, $razon_social, $documentoid, $complementoid, $cliente_email);

            if ($result === "ok") {
                http_response_code(201); // Created      
                echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['message' => 'Error al actualizar el cliente'], JSON_UNESCAPED_UNICODE);
            }
        } catch (\Throwable $th) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => $th], JSON_UNESCAPED_UNICODE);
        }
    }

    public function registrar()
    {
        if (!$this->validateMethod("POST")) return;
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents("php://input"), true);
        $required = ['razon_social', 'documentoid', 'complementoid', 'cliente_email'];

        foreach ($required as $field) {
            if (empty($input[$field])) {
                http_response_code(400); // Bad Request
                echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
                return;
            }
        }

        $razon_social = trim(htmlspecialchars($input['razon_social']));
        $documentoid = trim(htmlspecialchars($input['documentoid']));
        $complementoid = trim(htmlspecialchars($input['complementoid']));
        $cliente_email = trim(htmlspecialchars($input['cliente_email']));

        try {
            if ($this->model->verificarCliente($documentoid)) {
                http_response_code(409);
                echo json_encode(['message' => 'El cliente ya existe'], JSON_UNESCAPED_UNICODE);
                return;
            }
            $result = $this->model->registrarCliente($razon_social, $documentoid, $complementoid, $cliente_email);

            if ($result === "ok") {
                http_response_code(201); // Created      
                echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['message' => 'Error al registrar el cliente'], JSON_UNESCAPED_UNICODE);
            }
        } catch (\Throwable $th) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Error al registrar el cliente'], JSON_UNESCAPED_UNICODE);
        }
    }

    private function validateMethod(string $expectedMethod)
    {
        if ($_SERVER['REQUEST_METHOD'] != $expectedMethod) {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['message' => 'Método no permitido'], JSON_UNESCAPED_UNICODE);
            return false;
        }
        return true;
    }
}
