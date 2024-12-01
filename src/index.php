<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediUpp - Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-gray-100 text-gray-800 font-sans flex items-center justify-center min-h-screen">

    <!-- Container principal -->
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg text-center">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="img/MediUpp (final).png" alt="MediUpp Logo" class="w-32 h-32">
        </div>

        <!-- Título del proyecto -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Bienvenido a MediUpp</h1>

        <!-- Descripción breve -->
        <p class="text-gray-600 mb-8">
            La plataforma ideal para gestionar y compartir tus eventos multimedia. Únete a nosotros y explora las posibilidades.
        </p>

        <!-- Botones de acción -->
        <div class="flex justify-center space-x-4">
            <a href="pages/auth/register.php" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300">
                Registrarse
            </a>
            <a href="pages/auth/login.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition duration-300">
                Login
            </a>
        </div>
    </div>

</body>
</html>
