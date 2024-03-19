<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    //  Validacion para cuentas nuevas
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre del Usuario es Obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El Correo del Usuario es Obligatorio';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña no puede estar vacía';
        }

        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La Contraseña debe contener al menos 6 caracteres';
        }

        if($this->password !==  $this->password2){
            self::$alertas['error'][] = 'La Contraseña y su confirmación no coinciden';
        }

        return self::$alertas;
    }

    //  Valida un Email
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El Correo es Obligatorio';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'El Correo no es Válido';
        }

        return self::$alertas;
    }

    //  Valida la contraseña
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña no puede estar vacía';
        }

        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La Contraseña debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    //  Hashea el Password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //  Generar un Token
    public function generarToken(){
        $this->token = uniqid();
    }
}


?>