<div class="contenedor login">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form class="formulario" method="POST" novalidate>
            
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    placeholder="Tu Email"
                />
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    placeholder="Tu Contraseña"
                />
            </div>

            <input type="submit" value="Iniciar Sesion" class="boton">

        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Crea Una</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>

    </div> <!-- Contenedor sm -->

</div>