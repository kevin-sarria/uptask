<div class="contenedor reestablecer">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nueva contraseña</p>

        <form class="formulario" method="POST" action="/reestablecer">

            <div class="campo">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    placeholder="Tu Contraseña"
                />
            </div>

            <input type="submit" value="Reestablecer Contraseña" class="boton">

        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Crea Una</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>

    </div> <!-- Contenedor sm -->

</div>