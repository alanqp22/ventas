<?php
class ProductosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCategorias()
    {
        $sql = "select * from categorias where categoria_estado=1;";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getMedidas()
    {
        $sql = "select * from medidas where medida_estado=1;";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function restaurarProducto(int $id_producto)
    {
        $sql = "update productos set producto_estado=1 where id_producto=?;";
        $datos = array($id_producto);
        return $this->doQuery($sql, $datos);
    }

    public function eliminarProducto(int $id_producto)
    {
        $sql = "update productos set producto_estado=0 where id_producto=?;";
        $datos = array($id_producto);
        return $this->doQuery($sql, $datos);
    }

    public function verificarProducto(string $codigo)
    {
        $sql = "select * from productos where codigo='$codigo';";
        $data = $this->select($sql);
        return $data;
    }

    public function getProductoById(int $id_producto)
    {
        $sql = "select * from productos where id_producto='$id_producto';";
        $data = $this->select($sql);
        return $data;
    }

    public function getProductos()
    {
        $sql = "SELECT p.*, c.nombre_categoria, m.descripcion_corta
            FROM productos p 
            INNER JOIN categorias c ON p.id_categoria = c.id_categoria 
            INNER JOIN medidas m ON m.id_medida = p.id_medida 
            ORDER BY producto_estado DESC;";

        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarProducto(string $nombre_producto, string $codigo, float $costo_compra, float $precio_venta, int $cantidad, int $id_categoria, int $id_medida)
    {
        $sql = "insert into productos 
            (codigo, nombre_producto, costo_compra, precio_venta, cantidad, id_medida, id_categoria) 
            values (?,?,?,?,?,?,?);";

        $datos = array($codigo, $nombre_producto, $costo_compra, $precio_venta, $cantidad, $id_medida, $id_categoria);
        return $this->doQuery($sql, $datos);
    }

    public function actualizarProducto(int $id_producto, string $nombre_producto, string $codigo, float $costo_compra, float $precio_venta, int $cantidad, int $id_categoria, int $id_medida)
    {
        $sql = "update productos set codigo=?, nombre_producto=?, costo_compra=?, precio_venta=?, cantidad=?, id_medida=?, id_categoria=? where id_producto=?;";
        $datos = array($codigo, $nombre_producto, $costo_compra, $precio_venta, $cantidad, $id_medida, $id_categoria, $id_producto);
        return $this->doQuery($sql, $datos);
    }

    private function doQuery(string $sql, array $datos = [])
    {
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
}
