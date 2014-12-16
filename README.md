Example API REST
================

Este es un ejemplo práctico de como implementar una API REST con Symfony2

Para este ejemplo es necesario una BBDD MySQL y Memcached para almacenar los datos

1)Configuracion
---------------

La configuración se establece en app/config/parameters.yml, este un ejemplo:

parameters:
    database_driver: pdo_mysql
    database_host: 127.0.0.1
    database_port: null
    database_name: apirest
    database_user: root
    database_password: null
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    locale: es
    secret: 910d2367jgfdfd1f7b7dfghnbv7744db5
    memcached: [["localhost", 11211]]

2)Rest
------

La API sigue el estándar Rest para los metodos y los codigos de respuesta:

Metodos:

GET - Para realizar la consulta
POST - Para la inserción de datos
PUT - Actualización de datos
DELETE - Borrado de datos

Códigos:

200 - Cuando la consulta es correcta
201 - Cuando el objeto fue creado correctamente
404 - Cuando no se puede encontrar el objeto solicitado
500 - Cuando ocurre un error inesperado