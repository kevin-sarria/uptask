<?php

namespace Controllers;

use MVC\Router;

class LoginController {

    public static function login( Router $router ) {
        
        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

        }

        $router->render( 'auth/login', [
            'titulo' => 'Iniciar Sesión'
        ]);


    }

    public static function logout() {
        

    }

    public static function crear(Router $router) {
        
        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

        }

        $router->render( 'auth/crear', [
            'titulo' => 'Crear Cuenta'
        ]);

    }


    public static function olvide(Router $router) {
        
        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

        }

        $router->render( 'auth/olvide', [
            'titulo' => 'Olvide mi Contraseña'
        ]);

    }


    public static function reestablecer(Router $router) {
        
        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

        }

        $router->render( 'auth/reestablecer', [
            'titulo' => 'Reestablecer'
        ]);

    }


    public static function mensaje(Router $router) {
        
        

        $router->render( 'auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);

    }


    public static function confirmar(Router $router) {
        
        

        $router->render( 'auth/confirmar', [
            'titulo' => 'Confirma Tu Cuenta de UpTask'
        ]);

    }



}