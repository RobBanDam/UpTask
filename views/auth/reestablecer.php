<div class="contenedor reestablecer">
	<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

	<div class="contenedor-sm">
		<p class="descripcion-pagina">Coloca tu nueva contraseña</p>

		<form class="formulario" method="post" action="/reestablecer">
			<div class="campo">
				<label for="password">Password</label>
				<input 
					type="password"
					id="password"
					placeholder="Tu Contraseña"
					name="password"
				/>
			</div>

			<input type="submit" value="Guardar Contraseña" class="boton">
		</form>

		<div class="acciones">
			<a href="/crear">¿Aún no tienes una cuenta? Obtén una</a>
			<a href="/olvide">¿Olvidaste tu Contraseña?</a>
		</div>
	</div> <!-- contenedor-sm -->
</div>