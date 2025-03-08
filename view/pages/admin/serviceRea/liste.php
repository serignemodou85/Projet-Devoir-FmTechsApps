
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ================== Head ================== -->
    <?php require_once("../../../sections/admin/head.php") ?>
    <!-- ================ End Head ================= -->
</head>

<body>
	<!-- Recuperation de la liste ServiceRea dans la BD -->
	<?php 
		require_once("../../../../model/ServiceReaRepository.php");
		$serviceReaRepository= new ServiceReaRepository();

		try {
			$listeServicesReas= $serviceReaRepository->getAll(1);
			$listeServicesReasSupprimer= $serviceReaRepository->getAll(0);
		} catch (Exception $error) {
			echo "<p>Erreur lors du chargement de la liste des Service et Realisation" .$error->getMessage() . "</p>";
			$listeServicesReas= [];
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
						<a href="#modal-add-serviceRea" class="btn btn-sm btn-dark text-white" data-toggle="modal">Ajouter</a>
					</li>
					<li id="btn-show-liste" class="breadcrumb-item"><a href="#" class="btn btn-sm btn-dark text-white f-w-500">Afficher Liste</a></li>
					<li id="btn-show-corbeille" class="breadcrumb-item"><a href="#" class="btn btn-sm btn-dark text-white f-w-700">Afficher Corbeille</a></li>
					<li id="btn-users" class="breadcrumb-item"><a href="listeUser" class="btn btn-sm btn-dark text-white f-w-500">Liste User</a></li>
				</ol>
				<!-- LISTE SERVICE ET REALISTION -->
				<h1 class="page-header"># Service /Realisation</h1>
				<div id="table-liste" class="panel panel-inverse">
					<div class="panel-heading">
						<h4 class="panel-title">Liste des Realisations/Service</h4>
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
								<th width="1%" data-orderable="false">Photo</th>
								<th class="text-nowrap text-center">Nom</th>
								<th class="text-nowrap text-center">Description</th>
								<th class="text-nowrap text-center">Type</th>
								<th class="text-nowrap text-center">Date Creation</th>
								<th class="text-nowrap text-center">Date Modification</th>
								<th class="text-nowrap text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($listeServicesReas)) : ?>
								<?php foreach ($listeServicesReas as $serviceRea) : ?>
									<tr class="odd gradeX">

										<!-- Photo -->
										<td width="1%" class="with-img text-center">
											<?php if(!empty($serviceRea['photo'])) : ?>
												<img src="public/images/servicesRea/<?= htmlspecialchars($serviceRea['photo']); ?>" style="width: 45px; " class="img-rounded height-30">
											<?php else : ?>
												<img src="public/images/servicesRea/default.jpg" alt="" class="img-rounded height-30">
											<?php endif?>	
										</td>

										<!-- Nom -->
										<td class="text-center">
											<?= htmlspecialchars($serviceRea['nom']) ?>
										</td>

										<!-- Description -->
										<td class="text-center">
											<?php
											$description = isset($serviceRea['description']) ? $serviceRea['description'] : "";
											$shortDescription = mb_substr($description, 0, 20) . (mb_strlen($description) > 20 ? "...lire plus" : "");
											?>
											<span data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($description) ?>">
												<?= htmlspecialchars($shortDescription) ?>
											</span>
										</td>

										<!-- Type -->
										<td class="text-center">
											<?= htmlspecialchars($serviceRea['type']=== 'R' ? "Realisation" : "Service") ?>
										</td>

										<!-- Date Creation -->
										<td class="text-center">
											<?= htmlspecialchars(date("d/m/Y H:i:s"), strtotime($serviceRea['created_at'])) ?>
											<br>
											par <?= htmlspecialchars($serviceRea['created_by_email']) ?>
										</td> 

										<!-- Date Modification -->
										<td class="text-center">
											<?php if($serviceRea['updated_at']) : ?> 
												<?= htmlspecialchars(date("d/m/Y H:i:s"), strtotime($serviceRea['updated_at'])) ?>
												par <?= htmlspecialchars($serviceRea['updated_by_email']) ?>
											<?php else: ?> 
												<span class='text-danger f-w-700'>Jamais Modifier</span>
											<?php endif ?> 
										</td>

										<!-- Action -->
										<td class="text-center">
											<a href="javascript:;" 
												data-id="<?= htmlspecialchars($serviceRea['id']) ?>"
												data-nom="<?= htmlspecialchars($serviceRea['nom']) ?>"
												data-description="<?= htmlspecialchars($serviceRea['description']) ?>"
												data-type="<?= htmlspecialchars($serviceRea['type']) ?>"
												data-photo="<?= htmlspecialchars($serviceRea['photo']) ?>"
												class="btn-edit"
												data-toggle="modal"
												data-target="#modal-edit-serviceRea" 
												title="Modifier">
												<i class="fa fa-edit btn btn-success"></i>
											</a>
											<a href="" data-id= "  <?= htmlspecialchars($serviceRea['id'])?>"  
											 name-servicerea= "<?= htmlspecialchars($serviceRea['nom'])?>"
											 class ="btn-delete" data-toggle="tooltip" data-placement="top" title="Supprimer">
												<i class="fa fa-trash btn btn-danger"></i>
											</a>
										</td>
									</tr>
								<?php endforeach ?>
							<?php else : ?>
								<p class="alert alert-danger text-center h3 f-w-700">La liste des Services/Realisations est vide</p>
							<?php endif?>
						</tbody>  
					</table>
					</div>
				</div>

				<!-- CORBEILLE APRES SUPPRESSION -->
				<div id="table-corbeille" class="panel panel-inverse">
					<div class="panel-heading">
						<h4 class="panel-title">Corbeille des Realisations-S ervice</h4>
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
								<th width="1%" data-orderable="false">Photo</th>
								<th class="text-nowrap text-center">Nom</th>
								<th class="text-nowrap text-center">Description</th>
								<th class="text-nowrap text-center">Type</th>
								<th class="text-nowrap text-center">Date Creation</th>
								<th class="text-nowrap text-center">Date Modification</th>
								<th class="text-nowrap text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($listeServicesReasSupprimer)) : ?>
								<?php foreach ($listeServicesReasSupprimer as $serviceRea) : ?>
									<tr class="odd gradeX">

										<!-- Photo -->
										<td width="1%" class="with-img text-center">
											<?php if(!empty($serviceRea['photo'])) : ?>
												<img src="public/images/servicesRea/<?= htmlspecialchars($serviceRea['photo']); ?>" style="width: 45px; " class="img-rounded height-30">
											<?php else : ?>
												<img src="public/images/servicesRea/default.jpg" alt="" class="img-rounded height-30">
											<?php endif?>	
										</td>

										<!-- Nom -->
										<td class="text-center">
											<?= htmlspecialchars($serviceRea['nom']) ?>
										</td>

										<!-- Description -->
										<td class="text-center">
											<?php
											$description = isset($serviceRea['description']) ? $serviceRea['description'] : "";
											$shortDescription = mb_substr($description, 0, 20) . (mb_strlen($description) > 20 ? "...lire plus" : "");
											?>
											<span data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($description) ?>">
												<?= htmlspecialchars($shortDescription) ?>
											</span>
										</td>

										<!-- Type -->
										<td class="text-center">
											<?= htmlspecialchars($serviceRea['type']=== 'R' ? "Realisation" : "Service") ?>
										</td>

										<!-- Date Creation -->
										<td class="text-center">
											<?= htmlspecialchars(date("d/m/Y H:i:s"), strtotime($serviceRea['created_at'])) ?>
											<br>
											par <?= htmlspecialchars($serviceRea['created_by_email']) ?>
										</td> 

										<!-- Date Modification -->
										<td class="text-center">
											<?php if($serviceRea['updated_at']) : ?> 
												<?= htmlspecialchars(date("d/m/Y H:i:s"), strtotime($serviceRea['updated_at'])) ?>
												par <?= htmlspecialchars($serviceRea['updated_by_email']) ?>
											<?php else: ?> 
												<span class='text-danger f-w-700'>Jamais Modifier</span>
											<?php endif ?> 
										</td>

										<!-- Action -->
										<td class="text-center">
											<!-- Restaurer -->
											<a href="#" 
												data-id=" <?= htmlspecialchars($serviceRea['id']) ?>&action=restaurer " 
												name-servicerea=" <?= htmlspecialchars($serviceRea['nom']) ?>" 
												class="btn-restaurer" data-toggle="tooltip" data-placement="top" title="Restaurer">
												<span class="btn btn-warning fw-bold">Restaurer</span>
											</a>

											
										</td>
									</tr>
								<?php endforeach ?>
							<?php else : ?>
								<p class="alert alert-danger text-center h3 f-w-700">La Corbeille est vide</p>
							<?php endif?>
						</tbody>  
					</table>
					</div>
				</div>
			</div>
        <!-- ================ End Base Content ============ -->

        <!-- ================== Menu Gauche =============== -->
        <?php require_once("../../../sections/admin/configuration.php") ?>
        <!-- ================ End Menu Gauche ============ -->

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
            data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>

	<!-- Modal Add ServiceRea -->
	<div class="modal fade" id="modal-add-serviceRea" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Header -->
				<div class="modal-header">
					<h4 class="modal-title">Ajouter un Service / Réalisation</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>

				<!-- Body -->
				<div class="modal-body">
					 <form action="serviceReaMainController" method="post" enctype="multipart/form-data" id="addRealisationForm">
						<!-- Champ pour le nom -->
						<div class="mb-3">
							<label for="nom" class="form-label">Nom Service/Realisation</label>
							<input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez le nom de la réalisation" required>
							<p class="error-message h5 fw-bold mt-2 mb-2"></p>
						</div>

						<!-- Champ pour la description -->
						<div class="mb-3">
							<label for="description" class="form-label">Description</label>
							<textarea name="description" id="description" class="form-control" rows="4" placeholder="Entrez une description" required></textarea>
							<p class="error-message h5 fw-bold mt-2 mb-2"></p>
						</div>

						<!-- Champ pour la photo -->
						<div class="mb-3">
							<label for="photo" class="form-label">Photo</label>
							<input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
							<p class="error-message h5 fw-bold mt-2 mb-2"></p>
						</div>

						<!-- Champ pour le type -->
						<div class="mb-3">
							<label for="type" class="form-label">Type</label>
							<select name="type" id="type" class="form-select form-control" required>
								<option value="">-- Sélectionnez un type --</option>
								<option value="S">Service</option>
								<option value="R">Réalisation</option>
							</select>
							<p class="error-message h5 fw-bold mt-2 mb-2"></p>
						</div>

						<!-- Bouton de soumission -->
						<div class="d-grid">
							<button type="submit" name="frmAddServiceRea" class="btn btn-primary fw-bold">Ajouter</button>
							<button type="reset" class="btn btn-danger fw-bold" >Annuler</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Edit ServiceRea -->
	<div class="modal fade" id="modal-edit-serviceRea" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<!-- Header -->
				<div class="modal-header">
					<h4 class="modal-title">Modification un Service / Réalisation</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>

				<!-- Body -->
				<div class="modal-body">
					 <form action="serviceReaMainController" method="post" enctype="multipart/form-data" id="editRealisationForm">
						<!-- Champ pour le nom -->
						<div class="mb-3">
							<label for="nom" class="form-label">Nom Service/Realisation</label>
							<input type="text" name="edit-nom" id="edit-nom" class="form-control" placeholder="Entrez le nom de la réalisation" required>
							<p class="error-message h5 fw-bold mt-2 mb-2"></p>
						</div>

						<!-- Champ pour la description -->
						<div class="mb-3">
							<label for="description" class="form-label">Description</label>
							<textarea name="edit-description" id="edit-description" class="form-control" rows="4" placeholder="Entrez une description" required></textarea>
							<p class="error-message h5 fw-bold mt-2 mb-2"></p>
						</div>

						<!-- Champ pour la photo -->
						<div class="mb-3">
							<label for="photo" class="form-label">Photo</label>
							<input type="file" name="edit-photo" id="edit-photo" class="form-control" accept="image/*" required>
							<div class="image-preview-container">
								<img src="" id="photo-preview" alt="Apercu de l'image" class="photo-preview">
							</div>
							<p class="error-message h5 fw-bold mt-2 mb-2"></p>
						</div>

						<!-- Champ pour le type -->
						<div class="mb-3">
							<label for="type" class="form-label">Type</label>
							<select name="edit-type" id="edit-type" class="form-select form-control" required>
								<option value="">-- Sélectionnez un type --</option>
								<option value="S">Service</option>
								<option value="R">Réalisation</option>
							</select>
							<p class="error-message h5 fw-bold mt-2 mb-2"></p>
						</div>

						<input type="text" hidden name="edit-id" id="edit-id" value="">

						<!-- Bouton de soumission -->
						<div class="d-grid tetxt-center">
							<button type="submit" id="btnsubmitEdit" name="frmEditServiceRea" class="btn text-center btn-primary fw-bold">Modifier</button>
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



    <!-- ================== Menu Gauche =============== -->
    <?php require_once("../../../sections/admin/script.php") ?>
    <!-- ================ End Menu Gauche ============ -->

</body>

</html>