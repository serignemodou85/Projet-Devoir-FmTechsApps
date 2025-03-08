<?php
require_once("DBRepository.php");

class ContactRepository extends DBRepository
{
    /**
     * Récupérer tous les contacts
     */
    public function getAll()
    {
        $sql = "SELECT * FROM contacts ORDER BY created_at DESC";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erreur lors de la récupération des contacts : " . $error->getMessage());
            return [];
        }
    }

}