Example API REST
================

Este es un ejemplo práctico de como implementar una API REST con Symfony2

Para este ejemplo es necesario una BBDD MySQL y Memcached para almacenar los datos

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