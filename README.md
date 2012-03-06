Symfony Madrid
==============

1) Instalación
--------------------------------

### Clonar el repositorio git

    git clone git@github.com:symfony-madrid/symfony-madrid.git 
	cd symfony-madrid

### Crear el archivo parameters.yml (sustituto de parameters.ini en las próximas versiones)

	cp app/config/parameters.yml.dist app/config/parameters.yml

En el repositorio está commiteado el archivo parameters.ini para que no falle el bundle SensioDistributionBundle, usado por ejemplo para regenerar el bootstrap.php.cache en actualizaciones de Symfony2

### Configurar la base de datos, los datos de correo, el locale y el token CSRF en el parameters.yml

    database_driver: pdo_mysql
    database_host: localhost
    database_port: 3306
    database_name: symfony_madrid
    database_user: root
    database_password: ~

	mailer_transport: gmail
	mailer_encryption: ssl
	mailer_auth_mode: login
	mailer_host: smtp.gmail.com
	mailer_user: usuario
	mailer_password: password

    locale: es_ES
    secret: "Symf0nyM4dr1d-T0k3n!"

### Configurar los usuarios del backoffice

    Editar la parte de providers -> in_memory -> users para crear tantos usuarios admin como se quiera

### Actualizar vendors y deployar los assets de los bundles que haya en los vendors

	php bin/vendors install

### Crear base de datos

	mysql -u [usuario] -p [password] -e "create database symfony_madrid CHARACTER SET utf8 COLLATE utf8_general_ci"

o

	php app/console doctrine:database:create

### Generar el modelo de datos

Para crear la BBDD del proyecto o actualizarla en posteriores versiones

	php app/console doctrine:migrations:migrate

### Cargar los datos de prueba

	php app/console doctrine:fixtures:load

### Configurar Apache (Ubuntu)

Editar el archivo hosts:

	$ sudo gedit /etc/hosts

y añadir la línea siguiente:

	127.0.0.1   www.symfony-madrid.dev

Configuramos un VirtualHost para el nuevo dominio, editando el archivo (nuevo) www.symfony-madrid.dev del directorio sites-available de apache2:

	$ sudo gedit /etc/apache2/sites-available/www.symfony-madrid.dev

con el siguiente contenido:

	<VirtualHost *:80>
		ServerName www.symfony-madrid.dev
		DocumentRoot /home/miusuario/www/symfony-madrid/web
		DirectoryIndex app.php
 
		<Directory "/home/miusuario/www/symfony-madrid/web">
	  		AllowOverride All
	  		Allow from All
			</Directory>
	</VirtualHost>

Habilitamos el nuevo VirtualHost:

	$ sudo a2ensite www.symfony-madrid.dev

Reiniciamos apache:

	$ sudo /etc/init.d/apache2 restart

### Configurar los permisos de app/cache y app/logs (Ubuntu)

Instalar el paquete acl

	sudo apt-get install acl

Editar el fichero /etc/fstab y añadir la opción "acl" a la partición donde tenemos nuestro proyecto

	# /home was on /dev/sda7 during installation
	UUID=d027a8eb-e234-1c9f-aef1-43a7dd9a2345 /home    ext4   defaults,acl   0   2

Reiniciar o volver a montar la partición:

	sudo /bin/mount -o remount /home

Otorgar los permisos a los directorios app/cache y app/logs

	sudo setfacl -R -m u:www-data:rwx -m u:miusuario:rwx app/cache app/logs
	sudo setfacl -dR -m u:www-data:rwx -m u:miusuario:rwx app/cache app/logs
 
#### Más información en: [Setting up Permissions](http://symfony.com/doc/current/book/installation.html#configuration-and-setup)

### Nekland/FeedBundle

Para la generación de los rss hay que crear un directorio feeds dentro de web y darle permisos;

	mkdir web/feeds
	chmod +xwr web/feeds

2) Ejecutar los tests
---------------------

Esta app viene con varias test suites: unit, component y functional tests. Por ahora, los
functional tests no pueden ser ejecutados, debido a que el componente DOM Crawler aún no
soporta el parseado de documentos HTML 5 (seguramente estará soportado en la versión 2.1)

### Configuración del entorno "travis"

Los component test usan una base de datos de test que se puede configurar a través del entorno
"travis"

    $ cp app/config/config_travis.yml.dist app/config/config_travis.yml

Posteriormente solo hará falta configurar los parámetros de la base de datos (sección
```doctrine```) de test en el archivo ```app/config/config_travis.yml```.

Adicionalmente resaltar que para ejecutar el 100% los tests, habría que habilitar APC por
cli pues hay el servicio de parseo de RSS usa APC para cachear los feeds.
