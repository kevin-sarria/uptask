<?php

namespace Model;

use Model\ActiveRecord;

class Usuario extends ActiveRecord {

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct( $args = [] ) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->password2 = $args['password2'] ?? null;
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;

    }


    // Validar el login de usuarios
    public function validarLogin() {
        
        if( !$this->email ) {
            self::$alertas['error'][] = "El Email del usuario es Obligatorio";
        }else if( !filter_var( $this->email, FILTER_VALIDATE_EMAIL ) ) {
            self::$alertas['error'][] = "Email no válido";
        }

        if( !$this->password ) {
            self::$alertas['error'][] = "La Contraseña del usuario es Obligatoria";
        } 

        return self::$alertas;

    }


    // Validación para cuentas nuevas
    public function validarNuevaCuenta() {

        if( !$this->nombre ) {
            self::$alertas['error'][] = "El Nombre del usuario es Obligatorio";
        }

        if( !$this->email ) {
            self::$alertas['error'][] = "El Email del usuario es Obligatorio";
        }

        if( !$this->password ) {
            self::$alertas['error'][] = "La Contraseña del usuario es Obligatoria";
        }else if( strlen($this->password) < 8 ) {
            self::$alertas['error'][] = "La Contraseña debe tener al menos 8 caracteres";
        }
        
        if( $this->password !== $this->password2 ) {
            self::$alertas['error'][] = "La Contraseñas son diferentes";
        }

        return self::$alertas;

    }

    // Valida el email
    public function validarEmail() {
        if( !$this->email ) {
            self::$alertas['error'][] = "El Email es Obligatorio";
        }else if( !filter_var( $this->email, FILTER_VALIDATE_EMAIL ) ) {
            self::$alertas['error'][] = "Email no válido";
        }

        return self::$alertas;
    }

    public function nuevoPassword() : array {

        if( !$this->password_actual ) {
            self::$alertas['error'][] = 'La Contraseña Actual es Obligatoria';
        }

        if( !$this->password_nuevo ) {
            self::$alertas['error'][] = 'La Nueva Contraseña es Obligatoria';
        }else if( strlen($this->password_nuevo) < 8 ) {
            self::$alertas['error'][] = 'La Contraseña Nueva debe tener al menos 8 caracteres';
        }

        return self::$alertas;

    }

    // Comprobar el Password
    public function comprobar_password() : bool {

        return password_verify( $this->password_actual, $this->password );

    }

    // Hashea el password
    public function hashearPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Crea un nuevo token
    public function crearToken() : void {
        $this->token = uniqid();
    }

    public function validarPassword() {
        
        if( !$this->password ) {
            self::$alertas['error'][] = "La Contraseña del usuario es Obligatoria";
        }else if( strlen($this->password) < 8 ) {
            self::$alertas['error'][] = "La Contraseña debe tener al menos 8 caracteres";
        }

        return self::$alertas;

    }

    public function validar_perfil() {
    
        if( !$this->nombre ) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }

        if( !$this->email ) {
            self::$alertas['error'][] = 'El Correo es Obligatorio';
        }

        return self::$alertas;

    }




}