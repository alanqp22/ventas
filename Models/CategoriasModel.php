<?php
class CategoriasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function restaurarCategoria(int $id_categoria)
    {
        $sql = "update categorias set categoria_estado=1 where id_categoria=?;";
        $datos = array($id_categoria);
        return $this->doQuery($sql, $datos);
    }

    public function eliminarCategoria(int $id_categoria)
    {
        $sql = "update categorias set categoria_estado=0 where id_categoria=?;";
        $datos = array($id_categoria);
        return $this->doQuery($sql, $datos);
    }

    public function verificarCategoria(string $nombre_categoria)
    {
        $sql = "select * from categorias where nombre_categoria='$nombre_categoria';";
        $data = $this->select($sql);
        return $data;
    }

    public function getCategoriaById(int $id_categoria)
    {
        $sql = "select * from categorias where id_categoria='$id_categoria';";
        $data = $this->select($sql);
        return $data;
    }

    public function getCategorias()
    {
        $sql = "select * from categorias ORDER BY categoria_estado DESC;";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarCategoria(string $nombre_categoria, string $codigoProducto)
    {
        $sql = "insert into categorias (nombre_categoria, codigoProducto) values (?,?);";
        $datos = array($nombre_categoria, $codigoProducto);
        return $this->doQuery($sql, $datos);
    }

    public function actualizarCategoria(int $id_categoria, string $nombre_categoria, string $codigoProducto)
    {
        $sql = "update categorias set nombre_categoria=?, codigoProducto=? where id_categoria=?;";
        $datos = array($nombre_categoria, $codigoProducto, $id_categoria);
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
