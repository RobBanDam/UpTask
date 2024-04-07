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
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nueva = $args['password_nueva'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    //  Validar el Login de Usuarios
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El Correo del Usuario es Obligatorio';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'El Correo no es Válido';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña no puede estar vacía';
        }

        return self::$alertas;
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

    //  Valida el perfil del Usuario
    public function validar_perfil(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El Correo es Obligatorio';
        }
        return self::$alertas;
    }

    //  Comprueba si los datos de inicio de sesión son correctos
    public function nuevo_password() : array {
        if(!$this->password_actual){
            self::$alertas['error'][] = 'La Contraseña Actual no Puede ir Vacía.';
        }
        if(!$this->password_nueva){
            self::$alertas['error'][] = 'La Nueva Contraseña no Puede ir Vacía.';
        }
        if(strlen($this->password_nueva) < 6){
            self::$alertas['error'][] = 'La Contraseña Debe Contener Al Menos 6 Caracteres.';
        }
        return self::$alertas;
    }

    //  Comprueba la nueva contraseña
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password);
    }

    //  Hashea el Password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //  Generar un Token
    public function generarToken() : void {
        $this->token = uniqid();
    }
}


?>