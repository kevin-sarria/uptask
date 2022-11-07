<div class="contenedor login">

    <h1 class="uptask">UpTask</h1>
    <p class="tagline">Crea y Administra tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <form class="formulario" method="POST">
            
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