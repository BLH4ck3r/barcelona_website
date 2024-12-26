<?php
// index.php - Página principal

session_start();
require_once __DIR__ . '/config/db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FC Barcelona - Página de Pruebas</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <h1>Bienvenidos a la página oficial del FC Barcelona</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Mostrar estas opciones si el usuario está logueado -->
                <a href="dashboard.php">Mi Perfil</a>
                <a href="logout.php">Cerrar Sesión</a>
            <?php else: ?>
                <!-- Mostrar estas opciones si el usuario no está logueado -->
                <a href="login.php">Login</a>
                <a href="register.php">Registro</a>
            <?php endif; ?>
            <a href="posts.php">Publicaciones</a>
            <a href="about.php">Sobre Nosotros</a>
            <a href="contact.php">Contacto</a>
            <a href="shop.php">Tienda</a>
        </nav>
    </header>

    <main>
        <section class="images-section">
            <h2>Galería de Imágenes</h2>
            <div class="image-gallery">
                <img src="images/barcelona1.jpg" alt="Barcelona Image 1">
                <img src="images/barcelona2.jpg" alt="Barcelona Image 2">
                <img src="images/barcelona3.jpg" alt="Barcelona Image 3">
                <!-- Añade más imágenes según sea necesario -->
            </div>
        </section>

        <section class="championships-section">
	    <h2>Campeonatos Obtenidos</h2>
   	    <div class="championships-container">
                <ul>
           	    <li>La Liga: <span>26 títulos</span></li>
          	    <li>Copa del Rey: <span>31 títulos</span></li>
           	    <li>Supercopa de España: <span>13 títulos</span></li>
           	    <li>UEFA Champions League: <span>5 títulos</span></li>
           	    <li>UEFA Super Cup: <span>5 títulos</span></li>
           	    <li>FIFA Club World Cup: <span>3 títulos</span></li>
           	    <!-- Añade más títulos según sea necesario -->
       	        </ul>
   	    </div>
	</section>


       
      	 <section class="legends-section">
   	     <h2>Leyendas del FC Barcelona</h2>
    	     <div class="legends-container">
       		 <div class="legend">
           	     <h3>Lionel Messi</h3>
                     <p>Posición: Delantero</p>
                     <p>Títulos:</p>
                     <ul>
               		 <li>10 x La Liga</li>
               		 <li>7 x Copa del Rey</li>
               		 <li>8 x Supercopa de España</li>
               		 <li>4 x UEFA Champions League</li>
               		 <li>3 x UEFA Super Cup</li>
               		 <li>3 x FIFA Club World Cup</li>
           	     </ul>
           	     <p>Considerado uno de los mejores futbolistas de todos los tiempos, Messi ha sido el corazón del Barcelona durante más de una década.</p>
       		 </div>

       		 <div class="legend">
           	     <h3>Ronaldinho</h3>
           	     <p>Posición: Delantero</p>
                     <p>Títulos:</p>
                     <ul>
                         <li>2 x La Liga</li>
               		 <li>2 x Supercopa de España</li>
               		 <li>1 x UEFA Champions League</li>
           	     </ul>
           	     <p>Ronaldinho trajo magia y alegría al Camp Nou con su increíble habilidad y carisma, encantando a los fans y cambiando el juego.</p>
         	 </div>

       		 <div class="legend">
          	     <h3>Carles Puyol</h3>
           	     <p>Posición: Defensa</p>
           	     <p>Títulos:</p>
           	     <ul>
               		 <li>6 x La Liga</li>
               		 <li>2 x Copa del Rey</li>
               		 <li>6 x Supercopa de España</li>
               		 <li>3 x UEFA Champions League</li>
               		 <li>2 x UEFA Super Cup</li>
               		 <li>2 x FIFA Club World Cup</li>
           	     </ul>
           	     <p>Un líder indiscutible y símbolo de la resistencia defensiva del Barcelona, Puyol fue la piedra angular de la defensa durante muchos años.</p>
                </div>

       	        <div class="legend">
           	     <h3>Pep Guardiola</h3>
                     <p>Posición: Entrenador</p>
                     <p>Títulos como entrenador:</p>
           	     <ul>
               		 <li>3 x La Liga</li>
               		 <li>2 x Copa del Rey</li>
               		 <li>3 x Supercopa de España</li>
               		 <li>2 x UEFA Champions League</li>
               		 <li>2 x UEFA Super Cup</li>
               		 <li>2 x FIFA Club World Cup</li>
           	     </ul>
           	      <p>Guardiola llevó al Barcelona a una era dorada con su estilo de juego tiki-taka, consolidando su estatus como uno de los mejores entrenadores del mundo.</p>
       		 </div>

       		 <div class="legend">
           	     <h3>Xavi Hernández</h3>
                     <p>Posición: Mediocampista</p>
                     <p>Títulos:</p>
           	     <ul>
               		 <li>8 x La Liga</li>
               		 <li>3 x Copa del Rey</li>
               		 <li>6 x Supercopa de España</li>
               		 <li>4 x UEFA Champions League</li>
               		 <li>2 x UEFA Super Cup</li>
               		 <li>2 x FIFA Club World Cup</li>
           	     </ul>
                     <p>Xavi fue el cerebro del equipo, su visión y precisión en el pase definieron una era de éxito en el Barcelona.</p>
       		 </div>

       		 <div class="legend">
           	     <h3>Andrés Iniesta</h3>
                     <p>Posición: Mediocampista</p>
                     <p>Títulos:</p>
           	     <ul>
               		 <li>9 x La Liga</li>
               		 <li>6 x Copa del Rey</li>
               		 <li>7 x Supercopa de España</li>
               		 <li>4 x UEFA Champions League</li>
              		 <li>3 x UEFA Super Cup</li>
               		 <li>3 x FIFA Club World Cup</li>
                     </ul>
                     <p>Con su habilidad técnica y momentos decisivos, Iniesta fue vital en el éxito del Barcelona, incluyendo su gol en la final de la Champions League 2009.</p>
       		 </div>

       		 <div class="legend">
           	     <h3>Luis Enrique</h3>
                     <p>Posición: Entrenador</p>
                     <p>Títulos como entrenador:</p>
                     <ul>
               		 <li>2 x La Liga</li>
               		 <li>3 x Copa del Rey</li>
               		 <li>1 x Supercopa de España</li>
               		 <li>1 x UEFA Champions League</li>
               		 <li>1 x UEFA Super Cup</li>
               		 <li>1 x FIFA Club World Cup</li>
           	     </ul>
                     <p>Como entrenador, Luis Enrique llevó al Barcelona a una impresionante temporada de triplete en 2015, destacándose por su enfoque táctico y versatilidad.</p>
      		  </div>
   	      </div>
	  </section>


        </main>

    <aside>
        <h2>Patrocinadores</h2>
        <ul>
            <li>Nike</li>
            <li>Rakuten</li>
            <li>Beko</li>
        </ul>
    </aside>

    <footer>
        <p>&copy; 2024 FC Barcelona. D1CKH4CK3R.</p>
        <p>
            <a href="terms.php">Términos y Condiciones</a> | 
            <a href="privacy.php">Política de Privacidad</a>
        </p>
    </footer>
</body>
</html>

<?php
require_once 'partials/footer.php';
?>
