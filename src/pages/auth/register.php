<?php
//require_once '../utils/db/DBConnector.php';
require_once 'init.php'; // Asegúrate de incluir tu init.php


// $CTR = "../../controllers/auth/register_controller.php";



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body{
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .formulario{
            width: 40%;
            height:auto;

            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;


            padding:2em;
            margin: 10px;

            background:#232323;
            color:whitesmoke;
        }
        form{
            width:80%;
            padding:10px;

            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        }
        form div{
            width:100%;
            height:auto;

            margin:1em;
        }
        form label{
            font-size:1em;
            margin-bottom:1em;

        }
        form input{
            width:100%;
            height:2em;
            /* margin-top:10px; */
            border-radius:5px;
            background:grey;
            color:#232323;
            transition-duration:0.1s;

        }
        form input:hover{
            background:#FF6F3C;

        }

        button{
            width: 40%;
            height:3em;
            color:whitesmoke;
            background: #FF6F3C;
            font-size:1em;
            font-weight:bold;
            border:none;
            border-radius:5px;
            transition-duration:0.2s;
        }
        button:hover{
            color:#FF6F3C;
            background:#232323;
            border:1px solid #FF6F3C;

            -webkit-box-shadow: 0px 0px 18px -1px rgba(255,111,60,1);
            -moz-box-shadow: 0px 0px 18px -1px rgba(255,111,60,1);
            box-shadow: 0px 0px 18px -1px rgba(255,111,60,1);

        }


    </style>
</head>
<body>

    <div class="formulario" id="register-form">
        <img src="" alt="LOGO">

        <form action="register-controller.php" method="POST">
            <div>
                <label for="usuario">Nombre de usuario</label>
                <input type="text" id="usuario" name="usuario">
            </div>
            <div>
                <label for="clave">Contraseña</label>
                <input type="password" id="clave" name="clave">            

            </div>
            <div>
                <label for="repetir-clave">Confirmar contraseña</label>
                <input type="password" id="repetir-clave" name="repetir-clave">            

            </div>
            <div>
                <label for="email">Dirección de e-mail</label>
                <input type="email" id="" name="email">            
            </div>
            <div>
                <label for="repetir-email">Confirmar E-mail</label>
                <input type="email" id="" name="repetir-email">            

            </div>
            <button type="submit" id="btn-enviar" name="enviar">Crear cuenta</button>            


        </form>

    </div>
    
    

</body>
</html>