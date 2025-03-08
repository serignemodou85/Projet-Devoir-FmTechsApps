<?php
    require_once("UserController.php");

    $userController=new UserController();
    //authentifie un utilisateur
    if (isset($_POST["formLogin"])){
        $userController->auth();
    }
    //deconnecte un utilisateur
    if (isset($_GET["logout"])){
        $userController->logout();
    }
    
    // Récupère tous les utilisateurs actifs
    $listeUsers = $userController->getAllUsers();
    
    // Ajouter un utilisateur
    if (isset($_POST["frmAddUser"])) {
        $userController->addUser();
    }

    // Modifier un utilisateur
    if (isset($_POST["frmEditUser"])) {
        $userController->editUser();
    }

    // Supprimer un utilisateur
    if (isset($_GET["action"]) && $_GET["action"] === "delete") {
        $id = $_GET["id"];
        $userController->deleteUser($id);
    }

    // Restaurer un utilisateur
    if (isset($_GET["action"]) && $_GET["action"] === "restaurer") {
        $id = $_GET["id"];
        $userController->restoreUser($id);
    }
    
    ?>
