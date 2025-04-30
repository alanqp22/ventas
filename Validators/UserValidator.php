<?php
require_once 'Validator.php';

class UserValidator extends Validator
{

  public function validate(array $data): void
  {
    $this->required('nick', $data['nick'] ?? null);
    $this->required('nombre', $data['nombre'] ?? null);
    $this->required('clave', $data['clave'] ?? null);
    $this->required('confirm_clave', $data['confirm_clave'] ?? null);

    if (!empty($data['clave']) && !empty($data['confirm_clave'])) {
      $this->equals('clave', $data['clave'], 'confirm_clave', $data['confirm_clave']);
      $this->minLength('clave', $data['clave'], 5);
    }

    if (!empty($data['nick'])) {
      $this->minLength('nick', $data['nick'], 3);
    }

    if (!empty($data['nombre'])) {
      $this->minLength('nombre', $data['nombre'], 3);
    }
  }
}
