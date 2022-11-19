<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/perfil" class="enlace">Volver al perfil</a>

    <form class="formulario" method="POST">

        <div class="campo">

            <label for="password_actual">Contraseña actual</label>
            <input
                type="password"
                id="password_actual"
                name="password_actual"
                placeholder="Tu Contraseña Actual"
            />

        </div>


        <div class="campo">

            <label for="password_nuevo">Contraseña Nueva</label>
            <input
                type="password"
                id="password_nuevo"
                name="password_nuevo"
                placeholder="Tu Nueva Contraseña"
            />

        </div>

        <input type="submit" value="Guardar Cambios" class="boton">

    </form>

</div>


<?php include_once __DIR__ . '/footer-dashboard.php' ?>