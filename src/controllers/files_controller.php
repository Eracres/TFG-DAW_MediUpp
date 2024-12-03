<?php

//*para PFP----------------------------------------------

function updatePfp() {
    global $error_pfp_edit;

    if (!empty($_FILES['pfp-edit']['tmp_name'][0])) { // Verifica el primer archivo subido
        $archivo = [
            'tmp_name' => $_FILES['pfp-edit']['tmp_name'][0],
            'name' => $_FILES['pfp-edit']['name'][0],
            'type' => $_FILES['pfp-edit']['type'][0],
            'error' => $_FILES['pfp-edit']['error'][0],
            'size' => $_FILES['pfp-edit']['size'][0],
        ];

        // Validar tipo de archivo permitido
        $extensiones_validas = ['jpg', 'jpeg', 'png'];
        $tipo_archivo = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

        if (!in_array($tipo_archivo, $extensiones_validas)) {
            $error_pfp_edit = "Solo se permiten archivos JPG, JPEG o PNG.";
            return;
        }

        // Mover el archivo a una carpeta segura
        $ruta_destino = $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/uploads/perfiles/';
        if (!is_dir($ruta_destino)) {
            mkdir($ruta_destino, 0777, true);
        }

        $nuevo_nombre = uniqid("pfp_") . '.' . $tipo_archivo;
        $ruta_completa = $ruta_destino . $nuevo_nombre;

        if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
            // Guardar la ruta en la base de datos
            $db = DBConnector::getInstance();
            $queryActualizarPfp = "UPDATE users SET pfp_src = :pfp WHERE id = :id";
            $queryActualizarPfpParams = [
                ':pfp' => '/TFG-DAW_MediUpp/uploads/perfiles/' . $nuevo_nombre,
                ':id' => $_GET['id_usuario']
            ];

            $db->execute($queryActualizarPfp, $queryActualizarPfpParams);

            if ($db->getExecuted()) {
                return "Foto de perfil actualizada correctamente.";
            } else {
                $error_pfp_edit = "No se pudo actualizar la base de datos.";
            }
        } else {
            $error_pfp_edit = "Error al mover el archivo subido.";
        }
    } else {
        $error_pfp_edit = "No se seleccionó ningún archivo.";
    }
}




//Función para subir contenido multimedia
function insertPosts() {
    global $error_message;
    // global $current_event_id;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['file-upload']['tmp_name'][0])) {
        $archivos = $_FILES['file-upload'];
        $event_id = $current_event_id;
        $user_id = $logged_user_id; //Variable declarada al principio del fichero en el que se va a llamar a este controlador

        //!BURRADA QUE FLIPAS------------------------------------------------------------------------------
        // $event_id = 1;
        // $user_id = 4; //Variable declarada al principio del fichero en el que se va a llamar a este controlador



        // Carpeta de destino
        $ruta_destino = $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/uploads/posts/';
        if (!is_dir($ruta_destino)) {
            mkdir($ruta_destino, 0777, true);
        }

        $extensiones_validas = ['jpg', 'jpeg', 'png', 'mp4', 'mov', 'avi'];
        $max_size = 20 * 1024 * 1024; // 20 MB en bytes
        $errores_archivos = [];
        $db = DBConnector::getInstance();

        foreach ($archivos['tmp_name'] as $key => $tmp_name) {
            $nombre_original = $archivos['name'][$key];
            $tipo_archivo = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));

            // Validar tamaño del archivo
            if ($archivos['size'][$key] > $max_size) {
                $errores_archivos[] = "Archivo $nombre_original: supera el tamaño máximo permitido (20 MB).";
                continue;
            }

            // Validar tipo de archivo
            if (!in_array($tipo_archivo, $extensiones_validas)) {
                $errores_archivos[] = "Archivo $nombre_original: formato no permitido.";
                continue;
            }

            // Generar nombre único y ruta de destino
            $nuevo_nombre = uniqid("post_") . '.' . $tipo_archivo;
            $ruta_completa = $ruta_destino . $nuevo_nombre;

            // Mover archivo
            if (move_uploaded_file($tmp_name, $ruta_completa)) {
                // Guardar en la base de datos
                $queryInsertPost = "INSERT INTO posts (event_id, sender_id, file_src) VALUES (:event_id, :sender_id, :file_src)";
                $queryInsertPostParams = [
                    ':event_id' => $event_id,
                    ':sender_id' => $user_id,
                    ':file_src' => '/TFG-DAW_MediUpp/uploads/posts/' . $nuevo_nombre
                ];

                $db->execute($queryInsertPost, $queryInsertPostParams);

                if (!$db->getExecuted()) {
                    $errores_archivos[] = "Archivo $nombre_original: no se pudo insertar en la base de datos.";
                }
            } else {
                $errores_archivos[] = "Archivo $nombre_original: error al mover el archivo.";
            }
        }

        // Mostrar errores o éxito
        if (!empty($errores_archivos)) {
            $error_message = implode('<br>', $errores_archivos);
        } else {
            echo "<script>alert('Todos los archivos se subieron correctamente.');</script>";
        }
    } else {
        $error_message = "No se seleccionaron archivos.";
    }
}






?>