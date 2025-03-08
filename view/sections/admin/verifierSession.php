<?php
    session_start();
    if(!isset($_SESSION["email"])){
        header("Location:login?error=1&message=" .
        urlencode("Merci de vous connecter D'abord ") .
        "&title=" .urlencode("Accés Non Autorisée"));
    }
    exit();

    $_SESSION["id"] = $user["id"] ?? null;
    $_SESSION["nom"] = $user["nom"] ?? null;
    $_SESSION["email"] = $user["email"] ?? null;
    $_SESSION["etat"] = $user["etat"] ?? null;
    $_SESSION["photo"]=$user["photo"] ?? null;

?>
