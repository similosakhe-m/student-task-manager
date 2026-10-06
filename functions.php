<?php
function setFlash($message, $type = "success") {
    $_SESSION["flash"] = [
        "message" => $message,
        "type" => $type
    ];
}

function getFlash() {
    if (isset($_SESSION["flash"])) {
        $flash = $_SESSION["flash"];
        unset($_SESSION["flash"]);
        return $flash;
    }
    return null;
}
?>
