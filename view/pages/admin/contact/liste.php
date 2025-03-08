<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ================== Head ================== -->
    <?php require_once("../../../sections/admin/head.php") ?>
</head>

<body>

    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <!-- ================== Menu Haut =============== -->
        <?php require_once("../../../sections/admin/menuHaut.php") ?>

        <!-- ================== Menu Gauche =============== -->
        <?php require_once("../../../sections/admin/menuGauche.php") ?>

        <!-- ================== Base Content =============== -->
        <div id="content" class="content">
            <h1 class="page-header"># Liste des Contacts</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Contacts Reçus</h4>
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
                                <th class="text-nowrap text-center">Sujet</th>
                                <th class="text-nowrap text-center">Message</th>
                                <th class="text-nowrap text-center">Date de réception</th>
                                <th class="text-nowrap text-center">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($listeContacts)) : ?>
                                <?php foreach ($listeContacts as $contact) : ?>
                                    <tr class="odd gradeX">
                                        <!-- Nom -->
                                        <td class="text-center">
                                            <?= htmlspecialchars($contact['nom']) ?>
                                        </td>

                                        <!-- Email -->
                                        <td class="text-center">
                                            <?= htmlspecialchars($contact['email']) ?>
                                        </td>

                                        <!-- Sujet -->
                                        <td class="text-center">
                                            <?= htmlspecialchars($contact['sujet']) ?>
                                        </td>

                                        <!-- Message -->
                                        <td class="text-center">
                                            <?php
                                            $message = isset($contact['message']) ? $contact['message'] : "";
                                            $shortMessage = mb_substr($message, 0, 30) . (mb_strlen($message) > 30 ? "...lire plus" : "");
                                            ?>
                                            <span data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($message) ?>">
                                                <?= htmlspecialchars($shortMessage) ?>
                                            </span>
                                        </td>

                                        <!-- Date de réception -->
                                        <td class="text-center">
                                            <?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($contact['created_at']))) ?>
                                        </td>

                                        <!-- Statut -->
                                        <td class="text-center">
                                            <?php if($contact['lu']) : ?>
                                                <span class="badge badge-success">Lu</span>
                                            <?php else : ?>
                                                <span class="badge badge-warning">Non lu</span>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6">
                                        <p class="alert alert-info text-center h3 f-w-700">Aucun contact reçu</p>
                                    </td>
                                </tr>
                            <?php endif?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- ================ End Base Content ============ -->

        <!-- ================== Configuration =============== -->
        <?php require_once("../../../sections/admin/configuration.php") ?>

        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>

    <!-- ================== Scripts =============== -->
    <?php require_once("../../../sections/admin/script.php") ?>

</body>
</html>