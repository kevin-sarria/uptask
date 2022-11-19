<?php


namespace Controllers;

use MVC\Router;
use Model\Proyecto;
use Model\Usuario;

class DashboardController {

    public static function index( Router $router ) {

        session_start();
        isAuth();

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);

    }

    public static function crear_proyecto( Router $router ) {

        session_start();
        isAuth();
        $alertas = [];

        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            $proyecto = new Proyecto($_POST);
            
            // Validación
            $alertas = $proyecto->validarProyecto();

            if( empty($alertas) ) {
                
                // Generar una URL única
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                // Almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                // Guardar el Proyecto
                $proyecto->guardar();

                header('Location: /proyecto?url=' . $proyecto->url);

            }


        }


        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);

    }

    public static function proyecto( Router $router ) {

        session_start();
        isAuth();

        $token = $_GET['url'];

        if( !$token ) {
            header('Location: /dashboard');
        }

        // Revisar que la persona que visita el proyecto, es quien lo creo
        $proyecto = Proyecto::where('url', $token);

        if( $proyecto->propietarioId !== $_SESSION['id'] ) {
            
            header('Location: /dashboard');

        }else {
            
            // Muestra el Proyecto
            

        }



        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);

    }


    public static function perfil( Router $router ) {

        session_start();
        $alertas = [];

        isAuth();

        $usuario = Usuario::find($_SESSION['id']);

        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            if( empty($alertas) ) {

                $existeUsuario = Usuario::where('email', $usuario->email);

                if( $existeUsuario && $existeUsuario->id !== $usuario->id ) {
                    
                    // Mensaje de error
                    Usuario::setAlerta('error', 'Email no Válido, ya pertenece a otra cuenta de UpTask');
                    $alertas = $usuario->getAlertas();


                }else {

                    // Guardar el usuario
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Datos Guardados correctamente');
                    $alertas = $usuario->getAlertas();

                    // Asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;

                }

            }

        }

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas,
            'usuario' => $usuario 
        ]);

    }

    public static function cambiar_password( Router $router ) {


        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST' ) {

            $usuario = Usuario::find($_SESSION['id']);
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->nuevoPassword();

            if( empty($alertas) ) {

                $resultado = $usuario->comprobar_password();

                if( $resultado ) {
                    $usuario->password = $usuario->password_nuevo;
                    // Eliminar propiedades no necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    // Hashear el nuevo password
                    $usuario->hashearPassword();

                    // Actualizar 
                    $resultado = $usuario->guardar();

                    if( $resultado ) {
                        Usuario::setAlerta('exito', 'Password Guardado Correctamente');
                        $alertas = Usuario::getAlertas();    
                    }


                }else {

                    Usuario::setAlerta('error', 'Contraseña Incorrecta');
                    $alertas = Usuario::getAlertas();

                }

            }

        }


        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Contraseña',
            'alertas' => $alertas
        ]);

    }

}


