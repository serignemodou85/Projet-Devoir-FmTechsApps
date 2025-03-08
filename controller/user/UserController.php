<?php 

session_start();
require_once("../../model/UserRepository.php");

class UserController
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    // Permet de valider l'email et le password
    public function validateLoginFields($email, $password)
    {
        if (empty($email) || empty($password)) {
            return "Tous les champs sont obligatoires";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "L'adresse email est invalide";
        }
        return null;
    }

    // Permet de retourner un message d'erreur
    public function setErrorAndRedirect($message, $title, $redirectUrl = "login")
    { 
        $_SESSION["error"] = $message;
        header("Location: $redirectUrl?error=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    // Permet de retourner un message de succès
    public function successAndRedirect($message, $title, $redirectUrl = "admin")
    { 
        $_SESSION["success"] = $message;
        header("Location: $redirectUrl?success=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    // Fonction permettant d'authentifier le super Admin
    public function authSuperAdmin($email, $password)
    {
        if ($email === "admin@gmail.com" && $password === "passer123") {
            $_SESSION["id"] = 1;
            $_SESSION["nom"] = "Modou Fall";
            $_SESSION["email"] = $email;
            $_SESSION["etat"] = 1;
            $_SESSION["photo"] = "default.png";
    
            $this->successAndRedirect(
                "Bienvenue dans l'administration",
                "Connexion réussie !"
            );
        }
        return false;
    }

    // Fonction permettant d'authentifier l'Admin
    public function authAdmin($email, $password)
    {
        $user = $this->userRepository->login($email, $password);
        if ($user && $user["etat"] == 1) {
            $_SESSION["id"] = $user["id"];
            $_SESSION["nom"] = $user["nom"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["etat"] = $user["etat"];
            $_SESSION["photo"] = $user["photo"];

            $this->successAndRedirect(
                "Bienvenue dans l'administration",
                "Connexion réussie !"
            );
        } elseif ($user && $user["etat"] == 0) {
            $this->setErrorAndRedirect(
                "Votre compte a été bloqué.",
                "Accès non autorisé!"
            );
        } else {
            $this->setErrorAndRedirect(
                "Les données saisies sont incorrectes.",
                "Accès non autorisé!"
            );
        }
        return false;
    }

    // Fonction qui authentifie les utilisateurs
    public function auth()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST["email"] ?? "");
            $password = trim($_POST["password"] ?? "");
        }
        
        // Validation formulaire
        $errorMessage = $this->validateLoginFields($email, $password);
        if ($errorMessage) {
            $this->setErrorAndRedirect($errorMessage, "Erreur de connexion");
        }

        // Vérifie si un super Admin se connecte
        if ($this->authSuperAdmin($email, $password)) {
            exit;
        }

        // Vérifie si un Admin se connecte
        if ($this->authAdmin($email, $password)) {
            exit;
        }
    }

    // Permet de déconnecter un utilisateur
    public function logout()
    {
        session_unset();
        session_destroy();
        
        header("Location: login?success=1&message=" .
            urlencode("Vous avez été déconnecté avec succès") .
            "&title=" . urlencode("Déconnexion réussie"));
        exit;
    }
    
    public function getUserInfo() {
        if(isset($_SESSION['user_id'])) {
            $userRepo = new UserRepository();
            $user = $userRepo->getUserById($_SESSION['user_id']);
            return $user;
        }
        return null;
    }

    /**
     * Ajouter un utilisateur
     */
    public function addUser()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = trim($_POST["nom"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $role = trim($_POST["role"] ?? "");
        $adresse = trim($_POST["adresse"] ?? "");
        $telephone = trim($_POST["telephone"] ?? "");
        $password = trim($_POST["password"] ?? "");
        $photo = "default.png";  
        $etat = 1;
        $createdAt = date("Y-m-d H:i:s");

        // Validation des champs
        if (empty($nom) || empty($email) || empty($role) || empty($password)) {
            $this->setErrorAndRedirect("Tous les champs sont obligatoires", "Erreur d'ajout");
        }

        // Vérifier si l'email existe déjà
        if ($this->userRepository->getUserByEmail($email)) {
            $this->setErrorAndRedirect("Cet email est déjà utilisé", "Erreur d'ajout");
        }

        // Ajouter l'utilisateur avec tous les champs
        $result = $this->userRepository->addUser($nom, $adresse, $telephone, $photo, $email, $password, $role, $etat, $createdAt);

        if ($result) {
            $this->successAndRedirect("Utilisateur ajouté avec succès", "Ajout réussi", "listeUser");
        } else {
            $this->setErrorAndRedirect("Erreur lors de l'ajout de l'utilisateur", "Erreur d'ajout");
        }
    }
}


    /**
     * Modifier un utilisateur
     */
    public function editUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = trim($_POST["edit-id"] ?? "");
            $nom = trim($_POST["edit-nom"] ?? "");
            $email = trim($_POST["edit-email"] ?? "");
            $adresse = trim($_POST["edit-adresse"] ?? "");
            $telephone = trim($_POST["edit-telephone"] ?? "");
            $role = trim($_POST["edit-role"] ?? "");

            // Validation des champs
            if (empty($id) || empty($nom) || empty($email) || empty($role)) {
                $this->setErrorAndRedirect("Tous les champs sont obligatoires", "Erreur de modification");
            }

            // Mettre à jour l'utilisateur
            $result = $this->userRepository->updateUser($id, $nom, $email, $role);

            if ($result) {
                $this->successAndRedirect("Utilisateur modifié avec succès", "Modification réussie", "listeUser");
            } else {
                $this->setErrorAndRedirect("Erreur lors de la modification de l'utilisateur", "Erreur de modification");
            }
        }
    }

    /**
     * Supprimer un utilisateur
     */
    public function deleteUser($id)
    {
        if (empty($id)) {
            $this->setErrorAndRedirect("ID utilisateur manquant", "Erreur de suppression");
        }

        $result = $this->userRepository->deleteUser($id);

        if ($result) {
            $this->successAndRedirect("Utilisateur supprimé avec succès", "Suppression réussie", "listeUser");
        } else {
            $this->setErrorAndRedirect("Erreur lors de la suppression de l'utilisateur", "Erreur de suppression");
        }
    }

    /**
     * Restaurer un utilisateur
     */
    public function restoreUser($id)
    {
        if (empty($id)) {
            $this->setErrorAndRedirect("ID utilisateur manquant", "Erreur de restauration");
        }

        $result = $this->userRepository->restoreUser($id);

        if ($result) {
            $this->successAndRedirect("Utilisateur restauré avec succès", "Restauration réussie", "listeUser");
        } else {
            $this->setErrorAndRedirect("Erreur lors de la restauration de l'utilisateur", "Erreur de restauration");
        }
    }
    
    


}
