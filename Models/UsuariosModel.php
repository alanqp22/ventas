<?php
class UsuariosModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function restaurarUsuario(int $id_usuario)
  {
    $sql = "update usuarios set usuario_estado=1 where id_usuario=?;";
    $datos = array($id_usuario);
    $data = $this->save($sql, $datos);
    if ($data == 1) {
      $res = "ok";
    } else {
      $res = "error";
    }
    return $res;
  }

  public function eliminarUsuario(int $id_usuario)
  {
    $sql = "update usuarios set usuario_estado=0 where id_usuario=?;";
    $datos = array($id_usuario);
    $data = $this->save($sql, $datos);
    if ($data == 1) {
      $res = "ok";
    } else {
      $res = "error";
    }
    return $res;
  }

  public function verificarUsuario(string $nick)
  {
    $sql = "select * from usuarios where nick='$nick';";
    $data = $this->select($sql);
    return $data;
  }

  public function getUsuarioById(int $id_usuario)
  {
    $sql = "select * from usuarios where id_usuario='$id_usuario';";
    $data = $this->select($sql);
    return $data;
  }

  public function getUsuario(string $nick, string $clave)
  {
    $sql = "select * from usuarios where nick='$nick' and clave='$clave' and usuario_estado=1;";
    $data = $this->select($sql);
    return $data;
  }
  public function getUsuarios()
  {
    $sql = "select u.usuario_estado, u.nombre, u.nick, u.id_usuario, c.id_caja, c.nombre as caja from usuarios u inner join cajas c on c.id_caja = u.id_caja ORDER BY u.usuario_estado DESC;";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function getCajas()
  {
    $sql = "select * from cajas where caja_estado=1;";
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

  public function actualizarUsuario(int $id_usuario, string $nombre, string $nick, int $id_caja)
  {
    $sql = "update usuarios set nombre=?, nick=?, id_caja=? where id_usuario=?;";
    $datos = array($nombre, $nick, $id_caja, $id_usuario);
    $data = $this->save($sql, $datos);

    if ($data == 1) {
      $res = "ok";
    } else {
      $res = "error";
    }
    return $res;
  }
}
