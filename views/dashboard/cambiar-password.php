
<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php';?>

    <a href="/perfil" class="enlace">Volver a Perfil</a>

    <form class="formulario" action="/cambiar-password" method="POST">
        <div class="campo">
            <label for="password_actual">Contraseña Actual:</label>
            <input 
                type="password"
                name="password_actual"
                placeholder="Tu Contraseña Actual"
            />
        </div>

        <div class="campo">
            <label for="password_nueva">Contraseña Nueva:</label>
            <input 
                type="password"
                name="password_nueva"
                placeholder="Tu Nueva Cotraseña"
            />
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>