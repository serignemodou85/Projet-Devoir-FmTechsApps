<?php
require_once("DBRepository.php");
    class UserRepository extends DBRepository
    {
        //Authentification utilisateur 
        public function login($email, $password)
        {
            $sql= "SELECT * FROM users WHERE email= :email AND etat = 1";
            try {
                $statement= $this->db->prepare($sql);
                $statement->execute(['email' => $email]);
                $user= $statement->fetch(PDO::FETCH_ASSOC);
                
                if($user && password_verify($password, $user["password"])){
                    return $user;
                }
                return false;

            } catch (PDOException $error) {
                error_log("Erreur de connexion de utilisateur" . $error->getMessage());
            throw $error;
            }       
        }
        public function addUser($nom, $adresse, $telephone, $photo, $email, $password, $role, $etat, $createdAt)
        {
            $sql = "INSERT INTO users (nom, adresse, telephone, photo, email, password, role, etat, created_at) 
                    VALUES (:nom, :adresse, :telephone, :photo, :email, :password, :role, :etat, :created_at)";
            
            try {
                $statement = $this->db->prepare($sql);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
                
                $statement->execute([
                    ':nom' => $nom,
                    ':adresse' => $adresse,
                    ':telephone' => $telephone,
                    ':photo' => $photo,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':role' => $role,
                    ':etat' => $etat,
                    ':created_at' => $createdAt
                ]);
                
                return true;
            } catch (PDOException $error) {
                error_log("Erreur lors de l'ajout de l'utilisateur : " . $error->getMessage());
                return false;
            }
        }


    
    /**
     * Mettre à jour un utilisateur
     */
    public function updateUser($id, $nom, $email, $role)
    {
        $sql = "UPDATE users SET nom = :nom, email = :email, role = :role WHERE id = :id";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute([
                'id' => $id,
                'nom' => $nom,
                'email' => $email,
                'role' => $role
            ]);
            return true;
        } catch (PDOException $error) {
            error_log("Erreur lors de la mise à jour de l'utilisateur : " . $error->getMessage());
            return false;
        }
    }
    
    public function deleteUser($id)
    {
        $sql = "UPDATE users SET etat = 0 WHERE id = :id";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['id' => $id]);
            return true;
        } catch (PDOException $error) {
            error_log("Erreur lors de la suppression de l'utilisateur : " . $error->getMessage());
            return false;
        }
    }

    
    public function restoreUser($id)
    {
        $sql = "UPDATE users SET etat = 1 WHERE id = :id";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['id' => $id]);
            return true;
        } catch (PDOException $error) {
            error_log("Erreur lors de la restauration de l'utilisateur : " . $error->getMessage());
            return false;
        }
    }

    
    public function getAll($status) {
        $sql = "SELECT * FROM users WHERE status = :status"; // Adapte la requête selon ta base de données
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUserById($id)

{

    $sql = "SELECT * FROM users WHERE id = :id";

    try {

        $statement = $this->db->prepare($sql);

        $statement->execute(['id' => $id]);

        return $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {

        error_log("Erreur lors de la récupération de l'utilisateur par ID : " . $error->getMessage());

        return false;

    }

}



public function getUserByEmail($email)

{

    $sql = "SELECT * FROM users WHERE email = :email";

    try {

        $statement = $this->db->prepare($sql);

        $statement->execute(['email' => $email]);

        return $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {

        error_log("Erreur lors de la récupération de l'utilisateur par email : " . $error->getMessage());

        return false;

    }

}
}
        
