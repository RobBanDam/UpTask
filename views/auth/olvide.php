<div class="contenedor olvide">
	<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

	<div class="contenedor-sm">
		<p class="descripcion-pagina">Recupera tu Acceso UpTask</p>

		<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

		<form class="formulario" method="post" action="/olvide" novalidate>
			<div class="campo">
				<label for="email">Email</label>
				<input 
					type="email"
					id="email"
					placeholder="Tu E-mail"
					name="email"
				/>
			</div>

			<input type="submit" value="Enviar Instrucciones" class="boton">
		</form>

		<div class="acciones">
			<a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
			<a href="/crear">¿Aún no tienes una cuenta? Obtén una</a>
		</div>
	</div> <!-- contenedor-sm -->
</div>