<!-- add-event_modal.php -->
<?php

    $modal_open = isset($_GET['modal']) && $_GET['modal'] === 'open';

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
            $errors['description-length'] = "La descripción no puede superar los 200 caracteres";
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

            $new_event_id = createNewEvent($event, $logged_user_id);

            if ($new_event_id) {
                header("Location: ".NOT_ROOT_DIR."pages/user_event_view.php?event_id=" . urlencode($new_event_id));
                exit;
            } else {
                $errors[""] = "";
            }
        }
    }

?>

<div class="modal<?= $modal_open ? ' open' : ''; ?>" id="add-event-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class> Crea un nuevo evento </h3>
            <span class="close-modal-btn">&times;</span>
        </div>
        <form action="?modal=open" method="post">
            <div class="modal-body">
                <div class="modal-form-field">
                    <label for="event-title"> Título del evento: </label>
                    <input type="text" 
                        class="new-event-input<?= isset($errors['empty-title']) ? ' form-input-error' : ''; ?>" 
                        name="title" 
                        value="<?= isset($title) ? htmlspecialchars($title) : '' ?>">
                    <?php if (isset($errors['empty-title'])): ?>
                        <span class="form-error-text"> <?= $errors['empty-title']; ?> </span>
                    <?php endif; ?>
                </div>
                <div class="modal-form-field">
                    <label for="event-description"> Descripción: </label>
                    <textarea class="new-event-input<?= isset($errors['description-length']) ? ' form-input-error' : ''; ?>" 
                        id="event-description" 
                        name="description" 
                        value="" rows="4"><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
                    <?php if (isset($errors['description-length'])): ?>
                        <span class="form-error-text"> <?= $errors['description-length']; ?> </span>
                    <?php endif; ?>
                </div>
                <div class="modal-form-field">
                    <label for="event-type"> Tipo de evento: </label>
                    <select id="event-type" name="type">
                        <option disabled selected> Selecciona el tipo </option>
                        <?php foreach (EVENT_TYPE as $key => $value): ?>
                            <option value="<?= $key; ?>" <?= isset($type) && $type == $key ? 'selected' : '' ?>> <?= $value; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="modal-form-field">
                    <label for="event-location"> Ubicación: </label>
                    <input type="text" 
                        class="new-event-input" 
                        name="location" 
                        value="<?= isset($location) ? htmlspecialchars($location) : '' ?>">
                </div>
                <div class="modal-form-field">
                    <label for="event-start-date"> Fecha de inicio: </label>
                    <input type="datetime-local" 
                        class="new-event-input<?= isset($errors['empty-startdate']) ? ' form-input-error' : ''; ?>" 
                        id="event-start-date" 
                        name="start_date" 
                        value="<?= isset($start_date) ? $start_date : '' ?>">
                    <?php if (isset($errors['empty-startdate'])): ?>
                        <span class="form-error-text"> <?= $errors['empty-startdate']; ?> </span>
                    <?php endif; ?>
                </div>
                <div class="modal-form-field">
                    <label for="event-end-date"> Fecha de finalización: </label>
                    <input type="datetime-local" 
                        class="new-event-input<?= isset($errors['empty-enddate']) ? ' form-input-error' : ''; ?>" 
                        id="event-end-date" 
                        name="end_date" 
                        value="<?= isset($end_date) ? $end_date : '' ?>">
                    <?php if (isset($errors['empty-enddate'])): ?>
                        <span class="form-error-text"> <?= $errors['empty-enddate']; ?> </span>
                    <?php endif; ?>
                </div>
                <div class="modal-form-field">
                <label for="event-access"> Tipo de acceso: </label>
                    <select id="event-type" name="access">
                        <option value="private" <?= isset($access) && $access === FALSE_VALUE ? 'selected' : '' ?>> Privado </option>
                        <option value="public" <?= isset($access) && $access === TRUE_VALUE ? 'selected' : '' ?>> Público </option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="close-modal-btn"> Cancelar </button>
                <button type="submit" name="create" id="add-event-btn"> Crear evento </button>
            </div>
        </form>
    </div>
</div>
