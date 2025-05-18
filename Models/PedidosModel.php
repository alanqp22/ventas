<?php
class PedidosModel extends Query
{

  public function __construct()
  {
    parent::__construct();
  }

  public function buscarCliente(string $documentoid)
  {
    $sql = "SELECT * FROM clientes WHERE documentoid = '$documentoid'";
    $data = $this->select($sql);
    return $data;
  }

  public function buscarProducto(string $codigo)
  {
    $sql = "SELECT p.*, m.descripcion_corta, c.codigoProducto
        FROM productos p
        INNER JOIN medidas m ON p.id_medida = m.id_medida
        INNER JOIN categorias c ON p.id_categoria = c.id_categoria
        WHERE codigo = '$codigo' AND p.producto_estado = 1 AND p.cantidad > 0";
    $data = $this->select($sql);
    return $data;
  }
}
