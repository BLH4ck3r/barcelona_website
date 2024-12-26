FC Barcelona Fan Page - Proyecto Web
Descripción
Este proyecto es una página web dedicada a los fanáticos del FC Barcelona, creada con fines educativos y de práctica en desarrollo web y seguridad informática. La página sirve como un entorno controlado para probar técnicas de penetración, identificar vulnerabilidades y aprender sobre medidas de protección.

Nota: Este proyecto es exclusivamente para fines educativos y debe ser utilizado en entornos locales o controlados. No se recomienda desplegar esta aplicación en un entorno de producción sin las debidas modificaciones y medidas de seguridad.

Características
Registro e inicio de sesión con validación de usuarios.
Sección de publicaciones para crear, comentar y dar "Me Gusta".
Información histórica del club: leyendas, títulos y estadísticas.
Galería de imágenes y enlaces a secciones como "Sobre Nosotros"
Diseño adaptado con estilos basados en los colores y la temática del FC Barcelona.
Propósito educativo en pruebas de penetración, incluyendo:
Validación de entradas de usuario.
Manejo de inyecciones SQL.
Seguridad en la gestión de sesiones y cookies.
Requisitos
Para ejecutar este proyecto, necesitas:

Servidor Web: Apache o Nginx.
PHP: Versión 7.4 o superior.
Base de Datos: MariaDB o MySQL.
Composer: Para instalar dependencias (si aplica).
Navegador Moderno: Compatible con HTML5 y CSS3.


Instalación
Clona este repositorio:
bash
Copiar código
git clone https://github.com/d1ckh4ck3r/fcbarcelona_website.git
Configura el entorno:
Copia el archivo config/db.php.example a config/db.php y edita las credenciales de tu base de datos.
Crea la base de datos y las tablas:
Ejecuta el script SQL database.sql incluido en el proyecto.
bash
Copiar código
mysql -u usuario -p < database.sql
Inicia el servidor web y accede al proyecto desde tu navegador.
