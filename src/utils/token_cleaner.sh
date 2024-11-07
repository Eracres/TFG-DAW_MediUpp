#!/bin/bash

# Credenciales de la base de datos
DB_HOST="localhost"
DB_NAME="tfg_mediupp_local"
DB_USER="malmorox"
DB_PASS="1234"

# Ejecuccion del comando SQL
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "
DELETE FROM tokens
WHERE consumed = 1 OR expiry_date < NOW();
"