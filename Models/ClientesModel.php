<?php
class ClientesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function restaurarCliente(int $id_cliente)
    {
        $sql = "update clientes set cliente_estado=1 where id_cliente=?;";
        $datos = array($id_cliente);
        return $this->doQuery($sql, $datos);
    }

    public function eliminarCliente(int $id_cliente)
    {
        $sql = "update clientes set cliente_estado=0 where id_cliente=?;";
        $datos = array($id_cliente);
        return $this->doQuery($sql, $datos);
    }

    public function verificarCliente(string $documentoid)
    {
        $sql = "select * from clientes where documentoid='$documentoid';";
        $data = $this->select($sql);
        return $data;
    }

    public function getClienteById(int $id_cliente)
    {
        $sql = "select * from clientes where id_cliente='$id_cliente';";
        $data = $this->select($sql);
        return $data;
    }

    public function getClientes()
    {
        $sql = "select * from clientes ORDER BY cliente_estado DESC;";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarCliente(string $razon_social, string $documentoid, string $complementoid, string $cliente_email)
    {
        $sql = "insert into clientes (documentoid, complementoid, razon_social, cliente_email) values (?,?,?,?);";
        $datos = array($documentoid, $complementoid, $razon_social, $cliente_email);
        return $this->doQuery($sql, $datos);
    }

    public function actualizarCliente(int $id_cliente, string $razon_social, string $documentoid, string $complementoid, string $cliente_email)
    {
        $sql = "update clientes set documentoid=?, complementoid=?, razon_social=?, cliente_email=? where id_cliente=?;";
        $datos = array($documentoid, $complementoid, $razon_social, $cliente_email, $id_cliente);
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
