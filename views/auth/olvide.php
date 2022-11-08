<div class="contenedor olvide">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recuperar tu acceso a UpTask</p>

        <form class="formulario" method="POST" action="/olvide">
            
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    placeholder="Tu Email"
                />
            </div>

            <input type="submit" value="Recuperar Contraseña" class="boton">

        </form>

        <div class="acciones">
        <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
            <a href="/crear">¿Aún no tienes una cuenta? Crea Una</a>
        </div>

    </div> <!-- Contenedor sm -->

</div>