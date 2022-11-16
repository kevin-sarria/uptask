<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {

    public static function login( Router $router ) {
        
        $alertas = [];

        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if( empty($alertas) ) {

                // Verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);

                if( !$usuario || !$usuario->confirmado ) {
                    Usuario::setAlerta('error', 'El Usuario No Existe o No Esta Confirmado');
                }else {

                    // El usuario existe
                    if( password_verify($_POST['password'], $usuario->password) ) {
                        
                        // Iniciar la sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar
                        header('Location: /dashboard');

                    }else {
                        $alertas = Usuario::setAlerta('error', 'Contraseña Incorrecta ');
                    }


                }

            }

            $alertas = Usuario::getAlertas();

        }

        $router->render( 'auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);


    }

    public static function logout() {

        session_start();
        $_SESSION = [];
        session_destroy();
        header('Location: /');

    }

    public static function crear(Router $router) {
        
        $usuario = new Usuario;
        $alertas = [];

        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            if( empty($alertas) ) {
                $existeUsuario = Usuario::where( 'email', $usuario->email );

                if($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                }else {

                    // Hashear el password
                    $usuario->hashearPassword();

                    // Eliminar la segunda contraseña
                    unset($usuario->password2);
                    
                    // Generamos el token
                    $usuario->crearToken();

                    // Crear un nuevo usuario
                    $resultado = $usuario->guardar();

                    // Enviar email
                    $email = new Email( $usuario->email, $usuario->nombre, $usuario->token );
                    $email->enviarConfirmacion();

                    if( $resultado ) {
                        header('Location: /mensaje');
                    }

                }


            }

        }

        $router->render( 'auth/crear', [
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);

    }


    public static function olvide(Router $router) {

        $alertas = [];

        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarEmail();


            if( empty($alertas) ) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);
                
                if( $usuario && $usuario->confirmado ) {
                    
                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);


                    // Actualizar el usuario
                    $usuario->guardar(); 


                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();


                    // Imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');

                }else {
                    // El usuario no existe
                    Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                }

            }

            $alertas = Usuario::getAlertas();

        }

        $router->render( 'auth/olvide', [
            'titulo' => 'Olvide mi Contraseña',
            'alertas' => $alertas
        ]);

    }


    public static function reestablecer(Router $router) {

        $token = s($_GET['token']);
        $mostrar = true;

        if(!$token) header('Location: /');

        // Identificar le usuario con este token
        $usuario = Usuario::where('token', $token);

        if( empty($usuario) ) {
            Usuario::setAlerta('error', 'Token No Válido');
            $mostrar = false;
        }
        


        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar el password
            $alertas = $usuario->validarPassword();

            if( empty($alertas) ) {
                
                // Hashear el nuevo password
                $usuario->hashearPassword();

                // Eliminar el token
                $usuario->token = null;

                // Guardar en la BD
                $resultado = $usuario->guardar();


                // Redireccionar
                if( $resultado ) {
                    header('Location: /');
                }

            }

        }

        $alertas = Usuario::getAlertas();

        $router->render( 'auth/reestablecer', [
            'titulo' => 'Reestablecer',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);

    }


    public static function mensaje(Router $router) {
        
        

        $router->render( 'auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);

    }


    public static function confirmar(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        if( empty($usuario) ) {
            
            // No se encontro un usuario con ese token
            Usuario::setAlerta('error', 'Token No Válido');

        } else {

            // Confirmar al usuario
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);
            
            // Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');

        }

        $alertas = Usuario::getAlertas();

        $router->render( 'auth/confirmar', [
            'titulo' => 'Confirma Tu Cuenta de UpTask',
            'alertas' => $alertas
        ]);

    }



}