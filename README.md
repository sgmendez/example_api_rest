Example API REST
================

Este es un ejemplo práctico de como implementar una API REST con Symfony2

Para este ejemplo es necesario una BBDD MySQL y Memcached para almacenar los datos

1)Configuracion
---------------

La configuración se establece en app/config/parameters.yml, este un ejemplo:

*database_driver: pdo_mysql
* database_host: 127.0.0.1
* database_port: null
* database_name: apirest
* database_user: root
* database_password: null
* mailer_transport: smtp
* mailer_host: 127.0.0.1
* mailer_user: null
* mailer_password: null
* locale: es
* secret: 910d2367jgfdfd1f7b7dfghnbv7744db5
* memcached: [["localhost", 11211]]

2)Rutas, metodos y códigos de respuesta
---------------------------------------

La API sigue el estándar Rest para los metodos y los codigos de respuesta:

Metodos:

* GET - Para realizar la consulta
* POST - Para la inserción de datos
* PUT - Actualización de datos
* DELETE - Borrado de datos

Códigos:

* 200 - Cuando la consulta es correcta
* 201 - Cuando el objeto fue creado correctamente
* 400 - La peticion no es correcta, parametros erroneos
* 404 - Cuando no se puede encontrar el objeto solicitado
* 500 - Cuando ocurre un error inesperado

Rutas:

* [GET] | /album/ | Listado de albumes | 200(OK)/404(NotFound) 
* [GET] | /album/{id}/ | Datos album id | 200(OK)/404(NotFound)
* [POST] | /album/ | Agregar album | 201(OK)/400(BadRequest)
* [PUT] | /album/{id}/ | Modificar album | 200(OK)/404(NotFound)
* [PUT] | /album/artista/{idAlbum}/ | Asignar artista a un album | 200(OK)/404(NotFound)/400(BadRequest)
* [DELETE] | /album/ | Borrar album | 200(OK)/404(NotFound) 

* [GET] | /artist/ | Listado de artistas | 200(OK)/404(NotFound) 
* [GET] | /artist/{id}/ | Datos artista id | 200(OK)/404(NotFound)
* [POST] | /artist/ | Agregar artista | 201(OK)/400(BadRequest)
* [PUT] | /artist/{id}/ | Modificar artista | 200(OK)/404(NotFound)
* [PUT] | /artist/album/{idArtista}/ | Asignar album a un artista | 200(OK)/404(NotFound)/400(BadRequest)
* [DELETE] | /artist/ | Borrar artista | 200(OK)/404(NotFound)