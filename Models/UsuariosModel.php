<?php
class UsuariosModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getUsuario(string $nick, string $clave)
  {
    $sql = "select * from usuarios where nick='$nick' and clave='$clave' and usuario_estado=1;";
    $data = $this->select($sql);
    return $data;
  }

  public function verificarUsuario(string $nick, string $nombre)
  {
    $sql = "select * from usuarios where nick='$nick' or nombre='$nombre';";
    $data = $this->select($sql);
    return $data;
  }

  public function getUsuarios()
  {
    $sql = "select u.*, c.id_caja, c.caja from usuarios u inner join caja c on c.id_caja = u.id_caja;";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function getCajas()
  {
    $sql = "select * from caja where caja_estado=1;";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function registrarUsuario(string $nombre, string $nick, string $clave, int $id_caja)
  {
    $sql = "insert into usuarios (nombre, nick, clave, id_caja) values (?,?,?,?);";
    $datos = array($nombre, $nick, $clave, $id_caja);
    $data = $this->save($sql, $datos);
    if ($data == 1) {
      $res = "ok";
    } else {
      $res = "error";
    }
    return $res;
  }
}
