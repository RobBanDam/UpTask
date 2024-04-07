<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;


class DashboardController{
    public static function index(Router $router){

        session_start();

        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        $router->render('dashboard/index', [
            'titulo' => "Proyectos",
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router){
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $proyecto = new Proyecto($_POST);

            //  Validación
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                //  Generar una URL única
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                //  Almacenar el creador del Proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                //  Guardar el Proyecto
                $proyecto-> guardar();

                //  Redireccionar Usuario
                header('Location: /proyecto?id=' . $proyecto->url);
            }
        }
        
        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => "Crear Proyecto"
        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();

        $token = $_GET['id'];
        if(!$token) header('Location: /dashboard');
        //  Revisar que la persona que visita el proyecto, es quien la crea
        $proyecto = Proyecto::where('url', $token);

        if($proyecto->propietarioId !== $_SESSION['id']){
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function perfil(Router $router){
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();
            
            if(empty($alertas)){
                //  Verificar que el correo no se encuentre duplicado
                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    //  Mostrar mensaje de error
                    Usuario::setAlerta('error', 'El Correo ya se encuentra en uso');
                    $alertas = $usuario->getAlertas();
                }else{
                    //  Se guarda el Usuario
                    $usuario->guardar();
    
                    //  mostrar mensaje de cambio correcto
                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $usuario->getAlertas();
    
                    //  Se asigna el nuevo nombre a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
        }

        $router->render('dashboard/perfil', [
            'titulo' => "Perfil",
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function cambiar_password(Router $router){
        session_start();
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = Usuario::find($_SESSION['id']);

            //  Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();

            if(empty($alertas)){
                $resultado = $usuario->comprobar_password();

                if($resultado){
                    $usuario->password = $usuario->password_nueva;

                    //  Eliminar propiedades no necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nueva);

                    //  Hashear la nueva contraseña
                    $usuario->hashPassword();

                    //  Actualizar
                    $resultado = $usuario->guardar();

                    if($resultado){
                        Usuario::setAlerta('exito', 'Contraseña Guardada Correctamente');
                        $alertas = $usuario->getAlertas();
                    }
                }else{
                    Usuario::setAlerta('error', 'Contraseña Incorrecta');
                    $alertas = $usuario->getAlertas();
                }
            }

        }

        $router->render('dashboard/cambiar-password', [
            'titulo' => "Cambio de Contraseña",
            'alertas' => $alertas
        ]);
    }
}


?>