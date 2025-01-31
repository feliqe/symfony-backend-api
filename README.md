# Guía para Ejecutar el Proyecto Symfony

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalados los siguientes programas en tu entorno de desarrollo:

- **PHP**: Versión 7.4 o superior.
- **Composer**: Gestor de dependencias para PHP.
- **Symfony CLI**: Herramienta de línea de comandos de Symfony.
- **Base de datos**: Una base de datos como MySQL la que esté configurada en el proyecto.

## Configuración de MySQL con XAMPP
Si estás utilizando XAMPP, asegúrate de haber cambiado el puerto de MySQL a 3307 y creado la base de datos con el nombre backend-bd.

La conexión debe estar configurada en el archivo .env de la siguiente manera:

```bash
DATABASE_URL="mysql://root@localhost:3307/backend-bd"
```

## Pasos para Ejecutar el Proyecto

### 1. Clonar el Repositorio

Si aún no tienes el repositorio del proyecto, clónalo ejecutando el siguiente comando:

```bash
git clone <https://github.com/feliqe/symfony-backend-api>
cd symfony-backend-api
```

### 2. Instalar las Dependencias del Proyecto

Una vez dentro del directorio del proyecto, ejecuta el siguiente comando para instalar todas las dependencias definidas en el archivo composer.json:

```bash
composer install
```

### 3. Cargar la Base de Datos

Antes de ejecutar el proyecto, asegúrate de que el archivo .env está configurado correctamente con los detalles de tu base de datos (usuario, contraseña, host, nombre de la base de datos, etc.).

Instalar Paquetes para Base de Datos
Ejecuta el siguiente comando para instalar el paquete ORM de Symfony que permite interactuar con la base de datos:

```bash
composer require symfony/orm-pack
```

### Actualizar la Base de Datos

A continuación, ejecuta el siguiente comando para crear o actualizar el esquema de la base de datos según las entidades definidas en el proyecto:

```bash
php bin/console doctrine:schema:update --force

```

Este comando sincroniza la estructura de la base de datos con las entidades de Doctrine, creando o modificando tablas según sea necesario.

### 4. Activar el Servidor Symfony

Para iniciar el servidor web de Symfony, ejecuta el siguiente comando:

```bash
symfony server:start
```

Este comando levantará el servidor de desarrollo en http://localhost:8000 (o en otro puerto si el puerto 8000 está ocupado).

### 5. Ejecutar las Migraciones (si es necesario)

Si el proyecto utiliza migraciones de Doctrine, puedes aplicar las migraciones pendientes para actualizar la base de datos ejecutando el siguiente comando:

```bash
php bin/console doctrine:migrations:migrate
```

Este comando ejecutará todas las migraciones que aún no se han aplicado.

### 6. Cargar Datos de Prueba (opcional)

Si necesitas cargar datos de prueba en la base de datos, puedes ejecutar el siguiente comando para cargar las fixtures:

```bash
php bin/console doctrine:fixtures:load
```

Este comando cargará los datos de prueba definidos en los archivos de fixtures de Symfony.

### 7. Acceder al Proyecto

Una vez que el servidor esté en funcionamiento, abre tu navegador y accede al siguiente enlace:

```bash
http://localhost:8000
```

### 8. Detener el Servidor

Si deseas detener el servidor de Symfony, ejecuta el siguiente comando:

```bash
symfony server:stop
```

### 9. Crud ejecutar JSON

Si deseas ejecuTar el json para probar la funcionalidad de CRUD:

Crear
```bash
link [POST]
[http://127.0.0.1:8000/tasks/crear]

JSON
{
  "name":"tarea1",
  "description":"realizar1",
  "expiration_date": "2025-01-01",
  "state": true,
  "priority":"alta",
  "responsible":"pedro"
}
```

Ver
```bash
link [GET]
[http://127.0.0.1:8000/tasks/view]

```

Actualizar
```bash
link [PUT]
[http://127.0.0.1:8000/tasks/update/1]

JSON
{
  "name":"tarea1",
  "description":"realizar1",
  "expiration_date":"2025-03-01",
  "state":false,
  "priority":"baja",
  "responsible":"felipe"
}
```

Eliminiar
```bash
link [DELETE]
[http://127.0.0.1:8000/tasks/delete/1]

```
