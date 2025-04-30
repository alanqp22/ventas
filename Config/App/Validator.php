<?php

abstract class Validator
{
  protected $errors = [];

  public function getErrors()
  {
    return $this->errors;
  }

  public function isValid()
  {
    return empty($this->errors);
  }

  protected function required($field, $value)
  {
    if (empty($value)) {
      $this->errors[] = "El campo '$field' es obligatorio.";
    }
  }

  protected function equals($field1, $value1, $field2, $value2)
  {
    if ($value1 !== $value2) {
      $this->errors[] = "El campo '$field1' debe coincidir con '$field2'.";
    }
  }

  protected function minLength($field, $value, $min)
  {
    if (strlen($value) < $min) {
      $this->errors[] = "El campo '$field' debe tener al menos $min caracteres.";
    }
  }

  protected function maxLength($field, $value, $max)
  {
    if (strlen($value) > $max) {
      $this->errors[] = "El campo '$field' no debe exceder $max caracteres.";
    }
  }

  // Método que debe implementar la clase hija
  abstract public function validate(array $data): void;
}
