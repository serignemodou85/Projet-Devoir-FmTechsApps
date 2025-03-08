<?php
require_once("../../model/ServiceReaRepository.php");

class ServiceReaController {
    private $repository;

    public function __construct() {
        $this->repository = new ServiceReaRepository();
    }
    //Pour faire la gestion des erreurs et sucess
    public function setErrorAndRedirect($message,$title,$redirectUrl="listeRealisation"){ 
        $_SESSION["error"]=$message;
        header("Location:$redirectUrl?error=1&message=" .
        urlencode(string:$message) ."&title=" .urlencode(string:$title));
        exit;
    }
    //permet de retourner un message de success
    public function successAndRedirect($message,$title,$redirectUrl="listeRealisation"){ 
        $_SESSION["success"]=$message;
        header("Location:$redirectUrl?success=1&message=" .
        urlencode(string:$message) ."&title=" .urlencode(string:$title));
        exit;
    }

    //Ajouter un service rea dans la BD
    public function addServiceRea() {
        if($_SERVER["REQUEST_METHOD"] === 'POST'){
            $nom=trim($_POST['nom'] ?? '');
            $description=trim($_POST['description'] ?? '');
            $type=trim($_POST['type'] ?? '');
            $CreatedBy=$_SESSION['id'] ?? null;
            $photo=$_FILES['photo']  ?? null;
            
            //Validation des données
            if (empty($nom) || empty($description) || empty($type) || !$photo){
                $this->setErrorAndRedirect("Tous les champs sont obligatoires.", "Erreur D'ajout");
                exit;
            }
            //Validation de la photo
            if ($photo['error'] !=UPLOAD_ERR_OK) {
                $this->setErrorAndRedirect("une erreur est survenue lors du téléchargement du photo.", "Erreur D'ajout");
                exit;
            }
            //Validation du type
            if (!in_array($type,['R', 'S'])){
                $this->setErrorAndRedirect("Le type séléctionner est invalide.", "Erreur D'ajout");
                exit;
            }
            //Téléchargement de la photo
            $uploadDir= "../../public/images/servicesRea/";
            $photoname=uniqid() . "_". basename($photo['name']);
            $uploadpath =$uploadDir . $photoname;

            //Deplacement de la photo dans service Rea
            if (!move_uploaded_file($photo['tmp_name'], $uploadpath)){
                $this->setErrorAndRedirect("une erreur est survenue lors du téléchargement du photo", "Erreur D'ajout");
                exit;
            }
            //Appel de la methode add pour inserer les données dans la BD
            try {
                $reponse= $this->repository->add($nom, $description,$photoname , $type , $CreatedBy);
                if ($reponse){
                    $msg= $type =='R' ? "Service Rea ajouté avec succès" : "Service Rea ajouté avec succès";
                    $this->successAndRedirect($msg, "Succès");
                }
                else{
                    $this->setErrorAndRedirect("une erreur est survenue lors de l'ajout","erreur");
                }
            }
            catch (Exception $error) {
                $this->setErrorAndRedirect("une erreur" . $error->getMessage());
            }
        }
    }
    //Modifier un service Rea dans la base de donnée 
    public function editServiceRea() 
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            
            // Récupération des données du formulaire
            $id = intval( trim($_POST['edit-id'] ?? ''));
            $nom = trim($_POST['edit-nom'] ?? '');
            $description = trim($_POST['edit-description'] ?? '');
            $type = trim($_POST['edit-type'] ?? '');
            $updatedBy = $_SESSION["id"] ?? null;
            $photo = $_FILES['edit-photo'] ?? null;
            $photoName = trim($_POST['current-photo'] ?? ''); // Récupérer l'ancienne photo si aucune nouvelle n'est uploadée
    
            // Validation des données
            if (empty($nom) || empty($description) || empty($type)) {
                $this->setErrorAndRedirect("Tous les champs sont obligatoires.", "Erreur de modification");
            }
    
            if (!in_array($type, ['R', 'S'])) {
                $this->setErrorAndRedirect("Le type sélectionné est invalide.", "Erreur de modification");
            }
    
            // Validation et traitement de l'upload de l'image
            if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'avif'];
                $fileExtension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
    
                if (!in_array($fileExtension, $allowedExtensions)) {
                    $this->setErrorAndRedirect("Format d'image invalide. Formats autorisés : jpg, jpeg, png, gif, avif.", "Erreur de modification");
                }
    
                // Définition du chemin d'upload
                $uploadDir = "../../public/images/servicesRea/";
                $photoName = uniqid() . "_" . basename($photo['name']);
                $uploadPath = $uploadDir . $photoName;
    
                if (!move_uploaded_file($photo['tmp_name'], $uploadPath)) {
                    $this->setErrorAndRedirect("Échec du téléchargement de l'image.", "Erreur de modification");
                }
            }
    
            // Modification dans la base de données
            try {
                $reponse = $this->repository->edit($id, $nom, $description, $photoName, $type, $updatedBy);
    
                if ($reponse) {
                    $msg = ($type == 'R') ? "Réalisation modifiée avec succès" : "Service modifié avec succès";
                    $this->successAndRedirect($msg, "Modification Réussie");
                } else {
                    $this->setErrorAndRedirect("Une erreur est survenue lors de la modification.", "Erreur de modification");
                }
            } catch (Exception $error) {
                error_log($error->getMessage()); 
                $this->setErrorAndRedirect("Une erreur interne est survenue. Veuillez réessayer.", "Erreur de modification");
            }
        }
    }
    public function desactiverServiceRea()
    {
        $id = intval($_GET['id']);
        $deleteBy = $_SESSION['id'] ?? null;
        $etatUser = $_SESSION['etat'] ?? null;

        // Vérification de l'état de l'utilisateur
        if (!isset($etatUser) || intval($etatUser) !== 1) {
            $this->setErrorAndRedirect("Votre compte n'est pas actif", "Accès non autorisé", "login");
        }

        // Vérification des données
        if (empty($id) || empty($deleteBy)) {
            $this->setErrorAndRedirect("Impossible de désactiver cette réalisation", "Information manquante");
        }

        // Appel du repository pour désactiver
        try {
            $result = $this->repository->desactivate($id, $deleteBy);

            if ($result) {
                $this->successAndRedirect("Réalisation ou service supprimé avec succès", "Suppression réussie");
            } else {
                $this->setErrorAndRedirect("Une erreur est survenue lors de la désactivation.", "Erreur de suppression");
            }
        } catch (Exception $error) {
            $this->setErrorAndRedirect("Erreur lors de la suppression : " . $error->getMessage(), "Erreur de suppression");
        }
    }
    public function restore($id, $updatedBy)
    {
        if ($_SERVER["REQUEST_METHOD"] === 'GET') {
            $id = intval($_GET['id']);
            $updatedBy = $_SESSION['id'] ?? null;
            $etatUser = $_SESSION['etat'] ?? null;

            // Vérification de l'état de l'utilisateur
            if (!isset($etatUser) || intval($etatUser) !== 1) {
                $this->setErrorAndRedirect("Votre compte n'est pas actif", "Accès non autorisé", "login");
            }

            // Vérification des données
            if (empty($id) || empty($updatedBy)) {
                $this->setErrorAndRedirect("Impossible de restaurer cette réalisation", "Information manquante");
            }

            // Appel du repository pour restaurer
            try {
                $result = $this->repository->restore($id, $updatedBy);

                if ($result) {
                    $this->successAndRedirect("Réalisation ou service restauré avec succès", "Restauration réussie");
                } else {
                    $this->setErrorAndRedirect("Une erreur est survenue lors de la restauration.", "Erreur de restauration");
                }
            } catch (Exception $error) {
                $this->setErrorAndRedirect("Erreur lors de la restauration : " . $error->getMessage(), "Erreur de restauration");
            }
        }
    }


}