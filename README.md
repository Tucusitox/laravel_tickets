PASOS PARA INICIALIZAR EL SISTEMA AL MOMENTO DE PRESENTARLO (LEER TODOS LOS PASOS):

PASO N1 ---------------------------------------------------------

Abre la terminar en el projecto Ejecuta el comando "composer install".

Abre el XAMPP y activa los Serrvicios apache y mysql.

Despúes configure su nuevo archivo ".env" correctamente en el puerto 3306 y el nombre 
de la base de datos que es "database_tickets" con el gestor "Mysql".

Para enviar correos debe agregar al .env sus credenciales de servidor de correo o 
datos de una cuenta con clave de aplicacion.

En el archivo .env el SESSION_DRIVER debe estar en "database", así: "SESSION_DRIVER=database".

PASO N2 ---------------------------------------------------------

Configure la variable de entorno DB_MYSQLDUMP_PATH con la direccion de sus archivos bin de mysql

Ejemplo: DB_MYSQLDUMP_PATH='C:\Program Files\MySQL\MySQL Server 8.3\bin'

Esto es necesario para poder realizar el respaldo de la base de datos

PASO N3 ---------------------------------------------------------

Entra a phpMyAdmin y crea una nueva base de datos con el nombre "database_tickets".

PASO N4 ----------------------------------------------------------

Con el proyecto ya en vscode desde la terminal aplica el comando "php artisan migrate". 
Depúes de aplicarlo revisa el phpMyAdmin para ver si se crearon las tablas correctamente.

PASO N5 -----------------------------------------------------------

En la terminal aplica el comando "php artisan db:seed --class=AppSeeder" 
para insertar datos de prueba y así poder visualizar el funcionamiento del sistema.

PASO N5 ---------------------------------------------------------------

Abre dos terminales en una aplcia el comando "php artisan serve" y en el otro
aplica el comando "php artisan queue:work" para ejecutar los jobs encargados
de consumir, enviar correos y generar el backup de la base de datos.

NOTA --------------------------------------------------------------------

Si al momento de levantar el servidor existe un error de depencias aplica estos comandos 
"php artisan config:clear" o "php artisan cache:clear". 
Si esto no funciona busca información en internet sobre el error y como solucioanrlo.