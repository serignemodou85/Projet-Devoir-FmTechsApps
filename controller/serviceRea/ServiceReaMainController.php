<?php

    session_start();
    require_once("ServiceReaController.php");

    $service = new ServiceReaController(); 

    
    if (isset($_POST['frmAddServiceRea'])) {
        $service->addServiceRea(); 
    }
    
    //Modification d'un service/Realisation
    if(isset($_POST["frmEditServiceRea"])){
        $service->editServiceRea();
    }


    //Suppression d'un service/realisation
    if  ($_SERVER['REQUEST_METHOD']=== 'GET' 
     && isset($_GET['id'], $_GET ['action'])
     && $_GET ["action"]=== 'delete'){
     $service->desactiverServiceRea();
    }

    /// Restaurer un service/réalisation
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'], $_GET['action']) && $_GET["action"] === 'restaurer') {
        $id = intval($_GET['id']);
        $updatedBy = $_SESSION['id'] ?? null;
        $service->restore($id, $updatedBy);
    }

    //Supprimer definitivement d'un service/Realisation
    if($_SERVER['REQUEST_METHOD'] === 'GET' 
        && isset($_GET['id'], $_GET['action'])
        && $_GET["action"] === 'deleteDefinitive'
    );