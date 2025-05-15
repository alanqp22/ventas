<?php
class Productos extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        $data['medidas'] = $this->model->getMedidas();
        $data['categorias'] = $this->model->getCategorias();
        $data['resources'] = "Productos/app";
        $this->views->getView($this, "index", $data);
    }

    public function listar()
    {
        $data = $this->model->getProductos();
        for ($i = 0; $i < count($data); $i++) {
            $id = (int)$data[$i]["id_producto"];
            $data[$i]["estado"] = $this->getEstadoBadge($data[$i]["producto_estado"]);
            $data[$i]["acciones"] = $this->getActionButtons($data[$i]["producto_estado"], $id);
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
        $data = $this->model->getProductoById($id);
        if (!$data) {
            http_response_code(409);
            echo json_encode(['message' => 'El producto no existe'], JSON_UNESCAPED_UNICODE);
            return;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        return;
    }

    public function restaurar(int $id)
    {
        header('Content-Type: application/json; charset=utf-8');
        if (!$this->validateMethod("PUT")) return;
        if (!$this->model->getProductoById($id)) {
            http_response_code(409);
            echo json_encode(['message' => 'El producto no existe'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $result = $this->model->restaurarProducto($id);

        if ($result === "ok") {
            http_response_code(200); // OK
            echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Error al restaurar el producto'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function eliminar(int $id)
    {
        header('Content-Type: application/json; charset=utf-8');
        if (!$this->validateMethod("DELETE")) return;

        if (!$this->model->getProductoById($id)) {
            http_response_code(409);
            echo json_encode(['message' => 'El producto no existe'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $result = $this->model->eliminarProducto($id);

        if ($result === "ok") {
            http_response_code(200); // OK
            echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Error al eliminar el producto'], JSON_UNESCAPED_UNICODE);
        }
    }


    public function actualizar(int $id_producto)
    {
        try {
            if (!$this->validateMethod("PUT")) return;
            header('Content-Type: application/json; charset=utf-8');

            $input = json_decode(file_get_contents("php://input"), true);
            $required = ['nombre_producto', 'codigo'];

            foreach ($required as $field) {
                if (empty($input[$field])) {
                    http_response_code(400); // Bad Request
                    echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
                    return;
                }
            }


            $nombre_producto = $input['nombre_producto'];
            $codigo = $input['codigo'];
            $costo_compra = $input['costo_compra'];
            $precio_venta = $input['precio_venta'];
            $cantidad = $input['cantidad'];
            $id_categoria = $input['id_categoria'];
            $id_medida = $input['id_medida'];

            if (!$this->model->getProductoById($id_producto)) {
                http_response_code(409);
                echo json_encode(['message' => 'El producto no existe'], JSON_UNESCAPED_UNICODE);
                return;
            }

            $result = $this->model->actualizarProducto($id_producto, $nombre_producto, $codigo, $costo_compra, $precio_venta, $cantidad, $id_categoria, $id_medida);

            if ($result === "ok") {
                http_response_code(201); // Created      
                echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['message' => 'Error al actualizar el producto'], JSON_UNESCAPED_UNICODE);
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
        $required = ['nombre_producto', 'codigo'];

        foreach ($required as $field) {
            if (empty($input[$field])) {
                http_response_code(400); // Bad Request
                echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
                return;
            }
        }

        $nombre_producto = $input['nombre_producto'];
        $codigo = $input['codigo'];
        $costo_compra = $input['costo_compra'];
        $precio_venta = $input['precio_venta'];
        $cantidad = $input['cantidad'];
        $id_categoria = $input['id_categoria'];
        $id_medida = $input['id_medida'];

        try {
            if ($this->model->verificarProducto($codigo)) {
                http_response_code(409);
                echo json_encode(['message' => 'El producto ya existe'], JSON_UNESCAPED_UNICODE);
                return;
            }
            $result = $this->model->registrarProducto($nombre_producto, $codigo, $costo_compra, $precio_venta, $cantidad, $id_categoria, $id_medida);

            if ($result === "ok") {
                http_response_code(201); // Created      
                echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['message' => 'Error al registrar el producto'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
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
