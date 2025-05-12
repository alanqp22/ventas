<?php
class CajasModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function restaurarCaja(int $id_caja)
  {
    $sql = "update cajas set caja_estado=1 where id_caja=?;";
    $datos = array($id_caja);
    $data = $this->save($sql, $datos);
    if ($data == 1) {
      $res = "ok";
    } else {
      $res = "error";
    }
    return $res;
  }

  public function eliminarCaja(int $id_caja)
  {
    $sql = "update cajas set caja_estado=0 where id_caja=?;";
    $datos = array($id_caja);
    $data = $this->save($sql, $datos);
    if ($data == 1) {
      $res = "ok";
    } else {
      $res = "error";
    }
    return $res;
  }

  public function verificarCaja(string $nombre)
  {
    $sql = "select * from cajas where nombre='$nombre';";
    $data = $this->select($sql);
    return $data;
  }

  public function getCajaById(int $id_caja)
  {
    $sql = "select * from cajas where id_caja='$id_caja';";
    $data = $this->select($sql);
    return $data;
  }

  public function getCajas()
  {
    $sql = "select * from caja;";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function registrarCaja(string $nombre)
  {
    $sql = "insert into cajas (nombre) values (?);";
    $datos = array($nombre);
    $data = $this->save($sql, $datos);
    if ($data == 1) {
      $res = "ok";
    } else {
      $res = "error";
    }
    return $res;
  }

  public function actualizarCaja(int $id_caja, string $nombre)
  {
    $sql = "update cajas set nombre=? where id_caja=?;";
    $datos = array($nombre, $id_caja);
    $data = $this->save($sql, $datos);

    if ($data == 1) {
      $res = "ok";
    } else {
      $res = "error";
    }
    return $res;
  }
}
