<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ================== Head ================== -->
    <?php require_once("view/sections/admin/head.php") ?>
    <!-- ================ End Head ================= -->
</head>
<body>

	<!-- ================== Session ================== -->
	<?php //require_once("view/sections/admin/verifierSession.php") ?>

    <!-- ================== Loader ================== -->
    <?php require_once("view/sections/admin/loader.php") ?>
	<!-- ================== End Loader =============== -->
	
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

        <!-- ================== Menu Haut =============== -->
		<?php require_once("view/sections/admin/menuHaut.php") ?>
		<!-- ================ End Menu Haut =============== -->
		
		<!-- ================== Menu Gauche =============== -->
		<?php require_once("view/sections/admin/menuGauche.php") ?>
		<!-- ================ End Menu Gauche ============ -->
		
		<!-- ================== Menu Gauche =============== -->
		<?php require_once("view/sections/admin/baseContent.php") ?>
        <!-- ================ End Menu Gauche ============ -->
		
		<!-- ================== Menu Gauche =============== -->
		<?php require_once("view/sections/admin/configuration.php") ?>
        <!-- ================ End Menu Gauche ============ -->
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	
    <!-- ================== Menu Gauche =============== -->
	<?php require_once("view/sections/admin/script.php") ?>
    <!-- ================ End Menu Gauche ============ -->

	<!-- ================== message sucess =============== -->
    <?php require_once("view/sections/admin/showMessage.php") ?>
	<!-- ================ End message sucess ============ -->
	
</body>
</html>