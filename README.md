# Prueba Back-End Laravel
 
### Realizó :  Fidel Zarco 

## Instrucciones para desplegar

### Composer
 - Ejecutar ```composer install ```

### Base de datos y .env
 - Crear el schema en MYSQL
 - Copiar y pegar el archivo .env.example y renombrarlo a ```.env ```
 - Dentro del archivo ```.env ``` modificar el campo ```DB_DATABASE ``` con el nombre del schema que se creo, modificar el campo ```DB_USERNAME ``` con el nombre del superusuario de la base de datos, modificar el campo ```DB_PASSWORD ``` con la contraseña del superusuario de la base de datos
  - Ejecutar ```php artisan migrate```

