<?php
class Categorias extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        $resources = "Categorias/app";
        $this->views->getView($this, "index", array('resources' => $resources));
    }

    public function listar()
    {
        $data = $this->model->getCategorias();
        for ($i = 0; $i < count($data); $i++) {
            $id = (int)$data[$i]["id_categoria"];
            $data[$i]["estado"] = $this->getEstadoBadge($data[$i]["categoria_estado"]);
            $data[$i]["acciones"] = $this->getActionButtons($data[$i]["categoria_estado"], $id);
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    private function getActionButtons($estado, $id)
    {
        if ($estado == 1) {
            return <<<HTML
          <button class="btn btn-primary" data-action="edit" data-id="$id">
            <i class="fas fa-edit"></i>
          </button>
          <button class="btn btn-danger" data-action="delete" data-id="$id">
            <i class="fas fa-trash"></i>
          </button>
        HTML;
        } else {
            return <<<HTML
          <button class="btn btn-success" data-action="restore" data-id="$id">
            <i class="fas fa-trash-can-arrow-up"></i>
          </button>
        HTML;
        }
    }

    private function getEstadoBadge($estado)
    {
        return $estado == 1 ?
            '<span class="badge text-bg-primary">Activo</span>'
            :
            '<span class="badge text-bg-danger">Inactivo</span>';
    }

    public function editar(int $id)
    {
        header('Content-Type: application/json; charset=utf-8');
        $data = $this->model->getCategoriaById($id);
        if (!$data) {
            http_response_code(409);
            echo json_encode(['message' => 'La categoria no existe'], JSON_UNESCAPED_UNICODE);
            return;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        return;
    }

    public function restaurar(int $id)
    {
        header('Content-Type: application/json; charset=utf-8');
        if (!$this->validateMethod("PUT")) return;
        if (!$this->model->getCategoriaById($id)) {
            http_response_code(409);
            echo json_encode(['message' => 'La categoria no existe'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $result = $this->model->restaurarCategoria($id);

        if ($result === "ok") {
            http_response_code(200); // OK
            echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Error al restaurar la categoria'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function eliminar(int $id)
    {
        header('Content-Type: application/json; charset=utf-8');
        if (!$this->validateMethod("DELETE")) return;

        if (!$this->model->getCategoriaById($id)) {
            http_response_code(409);
            echo json_encode(['message' => 'La categoria no existe'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $result = $this->model->eliminarCategoria($id);

        if ($result === "ok") {
            http_response_code(200); // OK
            echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Error al eliminar la categoria'], JSON_UNESCAPED_UNICODE);
        }
    }


    public function actualizar(int $id_categoria)
    {
        try {
            if (!$this->validateMethod("PUT")) return;
            header('Content-Type: application/json; charset=utf-8');

            $input = json_decode(file_get_contents("php://input"), true);
            $required = ['nombre_categoria'];

            foreach ($required as $field) {
                if (empty($input[$field])) {
                    http_response_code(400); // Bad Request
                    echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
                    return;
                }
            }

            $nombre_categoria = $input['nombre_categoria'];
            $codigoProducto = $input['codigoProducto'];

            if (!$this->model->getCategoriaById($id_categoria)) {
                http_response_code(409);
                echo json_encode(['message' => 'La categoria no existe'], JSON_UNESCAPED_UNICODE);
                return;
            }

            $result = $this->model->actualizarCategoria($id_categoria, $nombre_categoria, $codigoProducto);

            if ($result === "ok") {
                http_response_code(201); // Created      
                echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['message' => 'Error al actualizar la categoria'], JSON_UNESCAPED_UNICODE);
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
        $required = ['nombre_categoria'];

        foreach ($required as $field) {
            if (empty($input[$field])) {
                http_response_code(400); // Bad Request
                echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
                return;
            }
        }

        $nombre_categoria = trim(htmlspecialchars($input['nombre_categoria']));
        $codigoProducto = trim(htmlspecialchars($input['codigoProducto']));

        try {
            if ($this->model->verificarCategoria($nombre_categoria)) {
                http_response_code(409);
                echo json_encode(['message' => 'La categoria ya existe'], JSON_UNESCAPED_UNICODE);
                return;
            }
            $result = $this->model->registrarCategoria($nombre_categoria, $codigoProducto);

            if ($result === "ok") {
                http_response_code(201); // Created      
                echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['message' => 'Error al registrar la categoria'], JSON_UNESCAPED_UNICODE);
            }
        } catch (\Throwable $th) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Error al registrar la categoria'], JSON_UNESCAPED_UNICODE);
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
