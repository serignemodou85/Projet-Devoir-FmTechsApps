<?php
    require_once("DBRepository.php");

    class ServiceReaRepository extends DBRepository
    {
        //Récupérer la liste des service et des réalisations
        public function getAll(int $etat)
        {
            $sql = "SELECT
                        sr.*,
                        u1.email AS created_by_email,
                        u2.email AS updated_by_email
                    FROM
                        servicereas sr
                    LEFT JOIN
                        users u1 ON sr.created_by = u1.id
                    LEFT JOIN
                        users u2 ON sr.updated_by = u2.id
                    WHERE sr.etat = :etat";

            try {

                $statement = $this->db->prepare($sql);
                $statement->execute(['etat' => $etat]);
                return $statement->fetchAll(PDO::FETCH_ASSOC) ?: null;

            } catch (PDOException $error) {
                $etatLabel = $etat == 1 ? "actives" : "supprimés";
                error_log("Erreur lors de la recupération des $etatLabel" . $error->getMessage());
                throw $error;
            }
        }
        
        //Récupérer la liste des service ou réalisations
        public function getAllByEtatAndType(int $etat, string $type)
        {
            $sql = "SELECT * FROM servicereas WHERE etat = :etat and type = :type";
            
            try {
                $statement = $this->db->prepare($sql);
                $statement->execute(['etat' => $etat, 'type' => $type]);
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result ?: null;
            } catch (PDOException $error) {
                $etatLabel = $etat == 1 ? "actives" : "supprimés";
                $typeLabel = $type == "R" ? "réalisations" : "services";
                error_log("Erreur lors de la recupération des $etatLabel $typeLabel" . $error->getMessage());
                throw $error;
            }
        }

        //Récupérer un service ou réalisation via son id
        public function getServiceReaById(int $id)
        {
            $sql = "SELECT * FROM servicereas WHERE id = :id";

            try {
                $statement = $this->db->prepare($sql);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC) ?: null;
            } catch (PDOException $error) {
                error_log("Erreur lors de la recupération de la réalisation/service d'id $id " . $error->getMessage());
                throw $error;
            }
        }

        //Permet d'ajouter une nouvelle réalisation
        public function add($nom, $description, $photo, $type, $createdBy)
        {
            $sql = "INSERT INTO servicereas (nom, description, photo, type, etat, created_at, created_by)
                    VALUES (:nom, :description, :photo, :type, default, NOW(), :created_by) ";

            try {

                $statement = $this->db->prepare($sql);
                $statement->execute([
                    'nom' => $nom,
                    'description' => $description,
                    'photo' => $photo,
                    'type' => $type,
                    'created_by' => $createdBy,
                ]);
 
                $lastInsertId = $this->db->lastInsertId();
                return $lastInsertId ?: null;
            } catch (PDOException $error) {
                error_log("Erreur lors l'ajout de la réalisation/service $nom " . $error->getMessage());
                throw $error;
            }
        }

        //Permet d'ajouter une nouvelle réalisation
        public function edit($id, $nom, $description, $photo, $type, $updatedBy)
        {
            $sql = "UPDATE servicereas
                    SET nom = :nom, description = :description, photo = :photo, type = :type,
                    updated_at = NOW(), updated_by=:updated_by WHERE id = :id ";

            try {

                $statement = $this->db->prepare($sql);
                $statement->execute([
                    'nom' => $nom,
                    'description' => $description,
                    'photo' => $photo,
                    'type' => $type,
                    'updated_by' => $updatedBy,
                    'id' => $id
                ]);

                return $statement->rowCount() >= 0; //true si $rowAffected > 0
            } catch (PDOException $error) {
                error_log("Erreur lors la modification de la réalisation/service $nom " . $error->getMessage());
                throw $error;
            }
        }

        //Permet de désactiver un service ou une réalisation
        public function desactivate($id, $deletedBy)
        {
            $sql = "UPDATE servicereas SET etat = 0, deleted_at = NOW(), deleted_by = :deleted_by WHERE id = :id";

            try {
                $statement = $this->db->prepare($sql);
                $statement->execute(['deleted_by' => $deletedBy,'id' => $id]);
                $rowAffected = $statement->rowCount();
                return $rowAffected > 0;
            } catch (PDOException $error) {
                error_log("Erreur lors de la désactivation de la réalisation/service d'id $id " . $error->getMessage());
                throw $error;
            }
        }

        //Permet de d'activer un service ou une réalisation
        public function activate($id, $updatedBy)
        {
            $sql = "UPDATE servicereas SET etat = 1, updated_at = NOW(), updated_by = :updated_by WHERE id = :id";

            try {
                $statement = $this->db->prepare($sql);
                $statement->execute(['updated_by' => $updatedBy, 'id' => $id]);
                $rowAffected = $statement->rowCount();
                return $rowAffected > 0;
            } catch (PDOException $error) {
                error_log("Erreur lors de l'activation de la réalisation/service d'id $id " . $error->getMessage());
                throw $error;
            }
        }

        //Permet de supprimer définitivement un service ou réalisation
        public function delete(int $id)
        {
            $sql = "DELETE * FROM servicereas WHERE id = :id";

            try {
                $statement = $this->db->prepare($sql);
                $statement->execute(['id' => $id]);
                $rowAffected = $statement->rowCount();
                return $rowAffected > 0;
            } catch (PDOException $error) {
                error_log("Erreur lors de la suppression définitive de la réalisation/service d'id $id " . $error->getMessage());
                throw $error;
            }
        }
        public function restore($id, $updatedBy)
        {
            $sql = "UPDATE servicereas 
                    SET etat = 1, updated_at = NOW(), updated_by = :updated_by 
                    WHERE id = :id AND etat = 0";

            try {
                $statement = $this->db->prepare($sql);
                $statement->execute([
                    'updated_by' => $updatedBy,
                    'id' => $id
                ]);
                $rowAffected = $statement->rowCount();
                return $rowAffected > 0;
            } catch (PDOException $error) {
                error_log("Erreur lors de la restauration de la réalisation/service d'id $id : " . $error->getMessage());
                throw $error;
            }
        }
    }
?>