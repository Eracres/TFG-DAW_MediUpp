<?php

    define('DEFAULT_TOKEN_CHARACTER_COUNT', 64);

    define('TOKEN_TYPE_REMEMBER_ME', 'remember_me');
    define('TOKEN_TYPE_RECOVERY_PASSWORD', 'recovery_password');
    // Define el tiempo de expiración predeterminado para tokens de recordar sesión
    define('DEFAULT_REMEMBER_ME_TOKEN_EXPIRATION_TIME', 7 * 24 * 60 * 60);
    // Define el tiempo de expiración predeterminado para tokens de recuperación de contraseña
    define('DEFAULT_RECOVERY_EMAIL_TOKEN_EXPIRATION_TIME', 15 * 60);

    define('FALSE_VALUE', 0);
    define('TRUE_VALUE', 1);

    define('TOKEN_NOT_CONSUMED_VALUE', 0);
    define('TOKEN_CONSUMED_VALUE', 1);

    define('COOKIE_REMEMBER_ME_NAME', 'remember_me');
    define('COOKIE_EXPIRATION_TIME', -(3600));
