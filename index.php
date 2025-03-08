<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>FmTechApp</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="public/templates/templateVitrine/assets/css/one-page-parallax/app.min.css" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->
</head>

<body data-spy="scroll" data-target="#header" data-offset="51">

    <div id="page-container" class="fade">
        <!-- ================== Section Menu ================== -->
        <?php require_once("view/sections/vitrine/menu.php") ?>
        <!-- ================== End Menu ================== -->

        <!-- ================== Section Baniere ================== -->
        <?php require_once("view/sections/vitrine/baniere.php") ?>
        <!-- ================== End Baniere ================== -->

        <!-- ================== Section About ================== -->
        <?php require_once("view/sections/vitrine/about.php") ?>
        <!-- ================== End About ================== -->

        <!-- ================== Section Chiffrage ================== -->
        <?php require_once("view/sections/vitrine/chiffrage.php") ?>
        <!-- ================== End Chiffrage ================== -->

        <!-- ================== Section Team ================== -->
        <?php require_once("view/sections/vitrine/team.php") ?>
        <!-- ================== End Team ================== -->

        <!-- ================== Section Publicité ================== -->
        <?php require_once("view/sections/vitrine/publicite.php") ?>
        <!-- ================== End Publicité ================== -->

        <!-- ================== Section Service ================== -->
        <?php require_once("view/sections/vitrine/service.php") ?>
        <!-- ================== End Service ================== -->

        <!-- ================== Section Info ================== -->
        <?php require_once("view/sections/vitrine/info.php") ?>
        <!-- ================== End Info ================== -->

        <!-- ================== Section Réalisation ================== -->
        <?php require_once("view/sections/vitrine/realisation.php") ?>
        <!-- ================== End Réalisation ================== -->

        <!-- ================== Section Témoignage ================== -->
        <?php require_once("view/sections/vitrine/temoignage.php") ?>
        <!-- ================== End Témoignage ================== -->

        <!-- ================== Section Pricing ================== -->
        <?php require_once("view/sections/vitrine/pricing.php") ?>
        <!-- ================== Section Pricing ================== -->
       
        <!-- ================== Section Contact ================== -->
        <?php require_once("view/sections/vitrine/contact.php") ?>
        <!-- ================== End Contact ================== -->

        <!-- ================== Section Footer ================== -->
        <?php require_once("view/sections/vitrine/footer.php") ?>
        <!-- ================== End Footer ================== -->

        <!-- ================== Section ConfColor ================== -->
        <?php require_once("view/sections/vitrine/confColor.php") ?>
        <!-- ================== End ConfColor ================== -->
    </div>

    <!-- ================== BASE JS ================== -->
    <script src="public/templates/templateVitrine/assets/js/one-page-parallax/app.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</body>

</html>