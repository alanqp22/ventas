<?php
class MedidasModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function restaurarMedida(int $id_medida)
  {
    $sql = "update medidas set medida_estado=1 where id_medida=?;";
    $datos = array($id_medida);
    return $this->doQuery($sql, $datos);
  }

  public function eliminarMedida(int $id_medida)
  {
    $sql = "update medidas set medida_estado=0 where id_medida=?;";
    $datos = array($id_medida);
    return $this->doQuery($sql, $datos);
  }

  public function verificarMedida(string $descripcion_medida)
  {
    $sql = "select * from medidas where descripcion_medida='$descripcion_medida';";
    $data = $this->select($sql);
    return $data;
  }

  public function getMedidaById(int $id_medida)
  {
    $sql = "select * from medidas where id_medida='$id_medida';";
    $data = $this->select($sql);
    return $data;
  }

  public function getMedidas()
  {
    $sql = "select * from medidas ORDER BY medida_estado DESC;";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function registrarMedida(string $descripcion_medida, string $descripcion_corta)
  {
    $sql = "insert into medidas (descripcion_medida, descripcion_corta) values (?,?);";
    $datos = array($descripcion_medida, $descripcion_corta);
    return $this->doQuery($sql, $datos);
  }

  public function actualizarMedida(int $id_medida, string $descripcion_medida, string $descripcion_corta)
  {
    $sql = "update medidas set descripcion_medida=?, descripcion_corta=? where id_medida=?;";
    $datos = array($descripcion_medida, $descripcion_corta, $id_medida);
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
