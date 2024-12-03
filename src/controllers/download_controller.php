<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

function downloadEventMedia($event_id) {
    // Conectar con la base de datos
    $db = DBConnector::getInstance();

    // Obtener los archivos asociados al evento
    $query = "SELECT file_src FROM posts WHERE event_id = :event_id";
    $params = [':event_id' => $event_id];
    $db->execute($query, $params);

    $files = $db->getData(DBConnector::FETCH_ALL);


    if (!$files || count($files) === 0) {
        die('No hay archivos asociados a este evento.');
    }

    // Crear un archivo ZIP temporal
    $zip = new ZipArchive();
    $zip_file = tempnam(sys_get_temp_dir(), 'event_') . '.zip';

    if ($zip->open($zip_file, ZipArchive::CREATE) !== TRUE) {
        die('Error al crear el archivo ZIP.');
    }

    // Agregar archivos al ZIP
    foreach ($files as $file) {
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $file['file_src'];

        if (file_exists($file_path)) {
            $zip->addFile($file_path, basename($file_path)); // Nombre dentro del ZIP
        }
    }

    $zip->close();

    // Enviar el archivo ZIP para su descarga
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="event_' . $event_id . '_media.zip"');
    header('Content-Length: ' . filesize($zip_file));
    readfile($zip_file);

    // Eliminar el archivo temporal
    unlink($zip_file);
    exit;
}

//*Llamada a la función pulsando el botón

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <button type="submit" name="descargar-zip">Descargar ZIP</button>
    </form>
</body>
</html>