<!-- add-event_modal.php -->
<?php

    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
        $title = isset($_POST['title']) ? trim($_POST['title']) : null;
        $description = isset($_POST['description']) ? trim($_POST['description']) : null;
        $type = isset($_POST['type']) ? $_POST['type'] : null;
        $location = isset($_POST['location']) ? trim($_POST['location']) : null;
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
        $access = isset($_POST['access']) && $_POST['access'] === 'public' ? TRUE_VALUE : FALSE_VALUE;


        if (empty($title)) {
            $errors['empty-title'] = "El título del evento es obligatorio";
        }

        if (!empty($description) && strlen($description) > 200) {
            $errors['description_length'] = "La descripción no puede superar los 200 caracteres";
        }

        if (empty($start_date)) {
            $errors['empty-startdate'] = "La fecha de inicio del evento es obligatoria";
        }

        if (empty($end_date)) {
            $errors['empty-enddate'] = "La fecha de finalización del evento es obligatoria";
        }

        if (empty($errors)) {
            $event = [
                'title' => $title,
                'description' => $description,
                'type' => $type,
                'location' => $location,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'is_public' => $access
            ];

            $success = createNewEvent($event, $logged_user_id);

            if ($success) {
                
            } else {
                
            }
        }
    }

?>

<div class="modal" id="add-event-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class> Crea un nuevo evento </h3>
            <span class="close-modal-btn">&times;</span>
        </div>
        <form action="" method="post">
            <div class="modal-body">
                <div class="modal-form-field">
                    <label for="event-title"> Título del evento: </label>
                    <input type="text" id="event-title" name="title">
                </div>
                <div class="modal-form-field">
                    <label for="event-description"> Descripción: </label>
                    <textarea id="event-description" name="description" rows="4"></textarea>
                </div>
                <div class="modal-form-field">
                    <label for="event-type"> Tipo de evento: </label>
                    <select id="event-type" name="type">
                        <option disabled selected> Selecciona el tipo </option>
                        <?php foreach (EVENT_TYPE as $key => $value): ?>
                            <option value="<?= $key; ?>"> <?= $value; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="modal-form-field">
                    <label for="event-location"> Ubicación: </label>
                    <input type="text" id="event-location" name="location">
                </div>
                <div class="modal-form-field">
                    <label for="event-start-date"> Fecha de inicio: </label>
                    <input type="datetime-local" id="event-start-date" name="start_date">
                </div>
                <div class="modal-form-field">
                    <label for="event-end-date"> Fecha de finalización: </label>
                    <input type="datetime-local" id="event-end-date" name="end_date">
                </div>
                <div class="modal-form-field">
                <label for="event-access"> Tipo de acceso: </label>
                    <select id="event-type" name="access">
                        <option value="private"> Privado </option>
                        <option value="public"> Público </option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="close-modal-btn"> Cancelar </button>
                <button type="submit" name="create" id="add-event-btn"> Crear evento </button>
            </div>
        </form>
    </div>
</div>
