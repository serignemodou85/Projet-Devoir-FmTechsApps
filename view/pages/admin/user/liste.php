<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ================== Head ================== -->
    <?php require_once("../../../sections/admin/head.php") ?>
    <!-- ================ End Head ================= -->
</head>

<body>
<?php
    require_once("../../../../model/UserRepository.php");  
    $userRepository = new UserRepository();

    try {
        $listeUsers = $userRepository->getAll(1); // Utilisateurs actifs
        $listeUsersSupprimer = $userRepository->getAll(0); // Utilisateurs supprimés
    } catch (Exception $error) {
        echo "<p>Erreur lors du chargement de la liste des utilisateurs : " . $error->getMessage() . "</p>";
        $listeUsers = [];
        $listeUsersSupprimer = [];
    }
?>


    <!-- ================== Loader ================== -->
    <?php require_once("../../../sections/admin/loader.php") ?>
    <!-- ================== End Loader =============== -->

    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

        <!-- ================== Menu Haut =============== -->
        <?php require_once("../../../sections/admin/menuHaut.php") ?>
        <!-- ================ End Menu Haut =============== -->

        <!-- ================== Menu Gauche =============== -->
        <?php require_once("../../../sections/admin/menuGauche.php") ?>
        <!-- ================ End Menu Gauche ============ -->

        <!-- ================== Base Content =============== -->
        <div id="content" class="content">
            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item">
                    <a href="#modal-add-user" class="btn btn-sm btn-dark text-white" data-toggle="modal">Ajouter</a>
                </li>
                <li id="btn-show-liste" class="breadcrumb-item"><a href="#" class="btn btn-sm btn-dark text-white f-w-500">Afficher Liste</a></li>
                <li id="btn-show-corbeille" class="breadcrumb-item"><a href="#" class="btn btn-sm btn-dark text-white f-w-700">Afficher Corbeille</a></li>
            </ol>
            <!-- LISTE DES UTILISATEURS -->
            <h1 class="page-header"># Utilisateurs</h1>
            <div id="table-liste" class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Liste des Utilisateurs</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Nom</th>
                                <th class="text-nowrap text-center">Email</th>
                                <th class="text-nowrap text-center">Rôle</th>
                                <th class="text-nowrap text-center">Adresse</th>
                                <th class="text-nowrap text-center">Date Création</th>
                                <th class="text-nowrap text-center">Date Modification</th>
                                <th class="text-nowrap text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($listeUsers)) : ?>
                                <?php foreach ($listeUsers as $user) : ?>
                                    <tr class="odd gradeX">
                                        <!-- Nom -->
                                        <td class="text-center">
                                            <?= htmlspecialchars($user['nom']) ?>
                                        </td>

                                        <!-- Email -->
                                        <td class="text-center">
                                            <?= htmlspecialchars($user['email']) ?>
                                        </td>

                                        <!-- Rôle -->
                                        <td class="text-center">
                                            <?= htmlspecialchars($user['role']) ?>
                                        </td>

                                        <!-- Date Création -->
                                        <td class="text-center">
                                            <?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($user['created_at']))) ?>
                                            <br>
                                            par <?= htmlspecialchars($user['created_by_email']) ?>
                                        </td>

                                        <!-- Date Modification -->
                                        <td class="text-center">
                                            <?php if($user['updated_at']) : ?> 
                                                <?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($user['updated_at']))) ?>
                                                par <?= htmlspecialchars($user['updated_by_email']) ?>
                                            <?php else: ?> 
                                                <span class='text-danger f-w-700'>Jamais Modifié</span>
                                            <?php endif ?> 
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-center">
                                            <a href="javascript:;" 
                                                data-id="<?= htmlspecialchars($user['id']) ?>"
                                                data-nom="<?= htmlspecialchars($user['nom']) ?>"
                                                data-email="<?= htmlspecialchars($user['email']) ?>"
                                            
                                                data-role="<?= htmlspecialchars($user['role']) ?>"
                                                class="btn-edit"
                                                data-toggle="modal"
                                                data-target="#modal-edit-user" 
                                                title="Modifier">
                                                <i class="fa fa-edit btn btn-success"></i>
                                            </a>
                                            <a href="#" 
                                                data-id="<?= htmlspecialchars($user['id'])?>&action=delete" 
                                                name-user="<?= htmlspecialchars($user['nom']) ?>" 
                                                class="btn-delete" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash btn btn-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <p class="alert alert-danger text-center h3 f-w-700">La liste des utilisateurs est vide</p>
                            <?php endif?>
                        </tbody>  
                    </table>
                </div>
            </div>

            <!-- CORBEILLE APRES SUPPRESSION -->
            <div id="table-corbeille" class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Corbeille des Utilisateurs</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Nom</th>
                                <th class="text-nowrap text-center">Email</th>
                                <th class="text-nowrap text-center">Rôle</th>
                                <th class="text-nowrap text-center">Date Création</th>
                                <th class="text-nowrap text-center">Date Modification</th>
                                <th class="text-nowrap text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($listeUsers)) : ?>
                                <?php foreach ($listeUsers as $user) : ?>
                                    <tr class="odd gradeX">
                                        <!-- Nom -->
                                        <td class="text-center"><?= htmlspecialchars($user['nom']) ?></td>

                                        <!-- Email -->
                                        <td class="text-center"><?= htmlspecialchars($user['email']) ?></td>

                                        <!-- Rôle -->
                                        <td class="text-center"><?= htmlspecialchars($user['role']) ?></td>

                                        <!-- Date Création -->
                                        <td class="text-center"><?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($user['created_at']))) ?><br>par <?= htmlspecialchars($user['created_by_email']) ?></td>

                                        <!-- Date Modification -->
                                        <td class="text-center">
                                            <?php if($user['updated_at']) : ?> 
                                                <?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($user['updated_at']))) ?>
                                                par <?= htmlspecialchars($user['updated_by_email']) ?>
                                            <?php else: ?> 
                                                <span class='text-danger f-w-700'>Jamais Modifié</span>
                                            <?php endif ?> 
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-center">
                                            <a href="javascript:;" 
                                                data-id="<?= htmlspecialchars($user['id']) ?>"
                                                data-nom="<?= htmlspecialchars($user['nom']) ?>"
                                                data-email="<?= htmlspecialchars($user['email']) ?>"
                                                data-role="<?= htmlspecialchars($user['role']) ?>"
                                                class="btn-edit"
                                                data-toggle="modal"
                                                data-target="#modal-edit-user" 
                                                title="Modifier">
                                                <i class="fa fa-edit btn btn-success"></i>
                                            </a>
                                            <a href="#" 
                                                data-id="<?= htmlspecialchars($user['id'])?>&action=delete" 
                                                name-user="<?= htmlspecialchars($user['nom']) ?>" 
                                                class="btn-delete" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash btn btn-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <p class="alert alert-danger text-center h3 f-w-700">La liste des utilisateurs est vide</p>
                            <?php endif?>
                        </tbody>

                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- ================ End Base Content ============ -->

        <!-- ================== Configuration =============== -->
        <?php require_once("../../../sections/admin/configuration.php") ?>
        <!-- ================ End Configuration ============ -->

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
            data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>

    <!-- Modal Add User -->
    <div class="modal fade" id="modal-add-user" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un Utilisateur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form action="userMainController" method="post" enctype="multipart/form-data" id="addUserForm">
                        <!-- Champ pour le nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez le nom de l'utilisateur" required>
                            <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                        </div>

                        <!-- Champ pour l'email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Entrez l'email de l'utilisateur" required>
                            <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                        </div>

                        <!-- Champ pour le rôle -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <select name="role" id="role" class="form-select form-control" required>
                                <option value="">-- Sélectionnez un rôle --</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                        </div>
                        <!-- Champ pour le Adresse -->
                         <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" name="adresse" id="adresse" class="form-control"
                            placeholder="Entrez l'adresse de l'utilisateur" required>
                            <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                        </div>
                        <!-- Champ pour le telephone -->
                         <div class="mb-3">
                            <label for="telephone" class="form-label">Telephone</label>
                            <input type="text" name="telephone" id="telephone" class="form-control"
                            placeholder="Entrez le telephone de l'utilisateur" required>
                            <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                        </div>
                        <!-- Champ pour le mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Entrez le mot de passe" required>
                            <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="d-grid">
                            <button type="submit" name="frmAddUser" class="btn btn-primary fw-bold">Ajouter</button>
                            <button type="reset" class="btn btn-danger fw-bold">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="modal-edit-user" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modification d'un Utilisateur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form action="userMainController" method="post" enctype="multipart/form-data" id="editUserForm">
                        <!-- Champ pour le nom -->
                        <div class="mb-3">
                            <label for="edit-nom" class="form-label">Nom</label>
                            <input type="text" name="edit-nom" id="edit-nom" class="form-control" placeholder="Entrez le nom de l'utilisateur" required>
                            <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                        </div>

                        <!-- Champ pour l'email -->
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email</label>
                            <input type="email" name="edit-email" id="edit-email" class="form-control" placeholder="Entrez l'email de l'utilisateur" required>
                            <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                        </div>

                        <!-- Champ pour le rôle -->
                        <div class="mb-3">
                            <label for="edit-role" class="form-label">Rôle</label>
                            <select name="edit-role" id="edit-role" class="form-select form-control" required>
                                <option value="">-- Sélectionnez un rôle --</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                        </div>

                        <!-- Champ caché pour l'ID de l'utilisateur -->
                        <input type="hidden" name="edit-id" id="edit-id" value="">

                        <!-- Bouton de soumission -->
                        <div class="d-grid text-center">
                            <button type="submit" id="btnsubmitEdit" name="frmEditUser" class="btn text-center btn-primary fw-bold">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ================== ERROR/SUCCESS =============== -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php require_once("../../../sections/admin/showMessage.php") ?>
    <!-- ================ End ERROR/SUCCESS ============ -->

    <!-- ================== Scripts =============== -->
    <?php require_once("../../../sections/admin/script.php") ?>
    <!-- ================ End Scripts ============ -->

</body>

</html>