<!--
   Post.php
   Nom du projet: facebook-cfpt
   Auteur : Eisman Camara Abel
   Crée le : 28.01.2021
   Mis a jour le : 22.03.2021
-->
<?php
include 'Fonctions.php';

$maxSize = 7000000;
$maxSizePerFile = 3000000;

$time = time();
//Quand submit existe
if (isset($_POST["submit"])) {
	$files = $_FILES['mesfichiers'];
	if ($_POST['Commentaire'] && count($files) < 1) {
		
		InsertPost($_POST['Commentaire']);
	}

	if (count($files['name']) >= 1 && $files['name'] != "") {
		//9
		for ($i = 0; $i < count($files['name']); $i++) {
			//3 5
			var_dump($files);
			$totalSize = 0;
			$size = $files["size"][$i];
			$files["name"][$i] = $time . "_" . $files["name"][$i];
			if ($size <= $maxSizePerFile && preg_match('#image#', $files['type'][$i]) && $totalSize <= $maxSize) {
				// 4 a remplacer avec img pour la destination
				if (move_uploaded_file($files['tmp_name'][$i], '../img/' . $files["name"][$i])) {

						InsertPostMedia($_POST['Commentaire'], $files['type'][$i], $files['name'][$i]);

						
				}
				else{
					echo 'Tout les fichiers non pas été transférés.';
				}
			} else {
				echo 'Fichier trop lourd !';
			}
			$totalSize += $files['size'][$i];
		}
	}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>cfpt-facebook-Post</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/facebook.css" rel="stylesheet">
</head>

<body>

	<div class="wrapper">
		<div class="box">
			<div class="row row-offcanvas row-offcanvas-left">



				<!-- main-->
				<div class="column col-sm-12 col-xs-12" id="main">

					<!-- top nav -->
					<div class="navbar navbar-blue navbar-static-top">
						<div class="navbar-header">
							<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a href="#" class="navbar-brand logo">b</a>
						</div>
						<nav class="collapse navbar-collapse" role="navigation">
							<ul class="nav navbar-nav">
								<li>
									<a href="index.php"><i class="glyphicon glyphicon-home"></i> Home</a>
								</li>
								<li>
									<a href="Post.php"><i class="glyphicon glyphicon-plus"></i>Post</a>
								</li>
							</ul>

						</nav>
					</div>
					<!-- /top nav -->
					<!-- Un modal dialogue avec un qui qui permet d'écrire dans la textarea et de selctioner plusieurs images -->
					<div class="modal-dialog" style="margin-top: 30px" ;>
						<div class="modal-content">
							<div class="modal-header">
								<b>Share</b>
							</div>
							<!--2-->
							<form method="POST" action="#" enctype="multipart/form-data">
								<div class="modal-body">
									<div class="form-group">
										<textarea class="form-control input-lg" autofocus placeholder="Commentaire ?" name="Commentaire"></textarea>
									</div>
								</div>
								<div class="modal-footer">
									<div>
										<div class="form-group" action="index.php">
											<!--7 8-->
											<input type="file" multiple accept="image/jpeg,image/png,image/gif" class="form-control-file" name="mesfichiers[]" style="float:left;">
											<button class="btn btn-primary btn-sm" data-dismiss="modal" aria-hidden="true" type="submit" name="submit">Post</button>
										</div>
									</div>

								</div>

							</form>
						</div>

					</div>
					<!-- /Un modal dialogue avec un qui qui permet d'écrire dans la textarea et de selctioner plusieurs images -->
				</div>
				<!-- /main-->




				<script type="text/javascript" src="assets/js/jquery.js"></script>
				<script type="text/javascript" src="assets/js/bootstrap.js"></script>
				<script type="text/javascript">
					$(document).ready(function() {
						$('[data-toggle=offcanvas]').click(function() {
							$(this).toggleClass('visible-xs text-center');
							$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
							$('.row-offcanvas').toggleClass('active');
							$('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
							$('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
							$('#btnShow').toggle();
						});
					});
				</script>
</body>

</html>