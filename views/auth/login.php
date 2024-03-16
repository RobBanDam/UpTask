<div class="contenedor login">
	<h1 class="uptask">UpTask</h1>
	<p class="tagline">Crea y Administra tus Proyectos</p>

	<div class="contenedor-sm">
		<p class="descripcion-pagina">Iniciar Sesión</p>

		<form class="formulario" method="post" action="/">
			<div class="campo">
				<label for="email">Email</label>
				<input 
					type="email"
					id="email"
					placeholder="Tu E-mail"
					name="email"
				/>
			</div>

			<div class="campo">
				<label for="password">Password</label>
				<input 
					type="password"
					id="password"
					placeholder="Tu Contraseña"
					name="password"
				/>
			</div>

			<input type="submit" value="Iniciar Sesión" class="boton">
		</form>

		<div class="acciones">
			<a href="/crear">¿Aún no tienes una cuenta? Obtén una</a>
			<a href="/olvide">¿Olvidaste tu Contraseña?</a>
		</div>
	</div> <!-- contenedor-sm -->
</div>