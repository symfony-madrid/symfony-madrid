Symfony Barcelona
==============

1) Instalación
--------------------------------

### Clonar el repositorio git

    git clone git@github.com:symfony-barcelona/symfony-barcelona.git
	cd symfony-barcelona

### Crear el archivo parameters.yml (sustituto de parameters.ini en las próximas versiones)

	cp app/config/parameters.yml.dist app/config/parameters.yml

En el repositorio está commiteado el archivo parameters.ini para que no falle el bundle SensioDistributionBundle, usado por ejemplo para regenerar el bootstrap.php.cache en actualizaciones de Symfony2

### Configurar la base de datos, los datos de correo, el locale y el token CSRF en el parameters.yml

    database_driver: pdo_mysql
    database_host: localhost
    database_port: 3306
    database_name: symfony_barcelona
    database_user: root
    database_password: ~

    mailer_transport: smtp
    mailer_host: localhost
    mailer_user: ~
    mailer_password: ~

    locale: es_ES
    secret: "Symf0nyBCN-T0k3n!"

### Actualizar vendors y deployar los assets de los bundles que haya en los vendors

	php bin/vendors install

### Crear base de datos

	mysql -u [usuario] -p [password] -e "create database symfony-barcelona CHARACTER SET utf8 COLLATE utf8_general_ci"

o

	php app/console doctrine:database:create

### Generar el modelo de datos

La primera vez

	php app/console doctrine:schema:create

y para actualizar

	php app/console doctrine:schema:update --force

### Cargar los datos de prueba

	php app/console doctrine:fixtures:load

### Configurar Apache (Ubuntu)

Editar el archivo hosts:

	$ sudo gedit /etc/hosts

y añadir la línea siguiente:

	127.0.0.1   www.symfony-barcelona.dev

Configuramos un VirtualHost para el nuevo dominio, editando el archivo (nuevo) www.symfony-barcelona.dev del directorio sites-available de apache2:

	$ sudo gedit /etc/apache2/sites-available/www.symfony-barcelona.dev

con el siguiente contenido:

	<VirtualHost *:80>
		ServerName www.symfony-barcelona.dev
		DocumentRoot /home/miusuario/www/symfony-barcelona/web
		DirectoryIndex app.php

		<Directory "/home/miusuario/www/symfony-barcelona/web">
	  		AllowOverride All
	  		Allow from All
		</Directory>
	</VirtualHost>

Habilitamos el nuevo VirtualHost:

	$ sudo a2ensite www.symfony-barcelona.dev

Reiniciamos apache:

	$ sudo /etc/init.d/apache2 restart

### Configurar los permisos de app/cache y app/logs (Ubuntu)

Para los permisos mucha gente recomienda instalar el paquete ACL.
Sin embargo, nuestra recomendación es modificar el usuario con el cual se ejecuta Apache para que coincida con nuestro usuario del ordenador donde estemos trabajando.

Para ello, hay que editar el archivo envvars de Apache

    $ sudo vim /etc/apache/envvars

Y modificar las líneas siguientes reemplazando www-data por nuestro usuario

    $ export APACHE_RUN_USER=[usuario]
    $ export APACHE_RUN_GROUP=[usuario]
