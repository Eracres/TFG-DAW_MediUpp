<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';


function printError($mensaje){
    echo '
        <p class="text-red-600">'.$mensaje.'</p>
    ';
}

function printSuccess($mensaje){
    echo '
    <p style="font-size:0.8rem" style="color:green">'.$mensaje.'</p>
';
}