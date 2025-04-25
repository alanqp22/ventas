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

  public function getUsuarios()
  {
    $sql = "select u.*, c.id_caja, c.caja from usuarios u inner join caja c on c.id_caja = u.id_caja;";
    $data = $this->selectAll($sql);
    return $data;
  }
}
