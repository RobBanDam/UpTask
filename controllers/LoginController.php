<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        }


        //  Render a la vista
        $router->render('auth/login', [
            'titulo' => "Iniciar Sesión"
        ]);
    }

    public static function logout(){
        echo "Desde Logout";

        
    }

    public static function crear(Router $router){
        $alertas = [];
        //  Instanciar usuario
        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD'] ==='POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario){
                    Usuario::setAlerta('error', 'El Usuario ya se encuentra registrado');
                    $alertas = Usuario::getAlertas();
                }else{
                    //  Hashear Password
                    $usuario->hashPassword();

                    //  Eliminar Password2
                    unset($usuario->password2);

                    //  Generar el Token
                    $usuario->generarToken();

                    //  Crear un nuevo Usuario
                    $resultado = $usuario->crear();

                    //  Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    

                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }


        //  Render a la vista
        $router->render('auth/crear', [
            'titulo'=>"Crea tu Cuenta en UpTask",
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
    }

    public static function olvide(Router $router){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
        }

        //  Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Contraseña'
        ]);
    }

    public static function reestablecer(Router $router){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
        }

        //  Muestra la vista
        $router -> render('auth/reestablecer', [
            'titulo' => 'Reestablecer Contraseña'
        ]);
    }

    public static function mensaje(Router $router){
        
        //  Muestra la vista
        $router -> render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    public static function confirmar(Router $router){

        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        //  Encontrar al Usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            //  No se encontró un usuario con ese token
            Usuario::setAlerta('error', 'Token no Válido');
        }else{
            //  Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);

            //  Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        $alertas = Usuario::getAlertas();
        
        //  Muestra la vista
        $router -> render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta UpTask',
            'alertas' => $alertas
        ]);
    }
}
