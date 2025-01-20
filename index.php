<?php 
require_once(__DIR__ . '/system/core.class.php');
require_once(__DIR__ . '/system/config.php');
// size convertor
function sizeFormat($bytes){ 
$kb = 1024;
$mb = $kb * 1024;
$gb = $mb * 1024;
$tb = $gb * 1024;

if (($bytes >= 0) && ($bytes < $kb)) {
return $bytes . ' B';

} elseif (($bytes >= $kb) && ($bytes < $mb)) {
return ceil($bytes / $kb) . ' KB';

} elseif (($bytes >= $mb) && ($bytes < $gb)) {
return ceil($bytes / $mb) . ' MB';

} elseif (($bytes >= $gb) && ($bytes < $tb)) {
return ceil($bytes / $gb) . ' GB';

} elseif ($bytes >= $tb) {
return ceil($bytes / $tb) . ' TB';
} else {
return $bytes . ' B';
}
}

$maxsize = max_size;

$core = new Core();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= app_name; ?> - <?= app_desc; ?></title>
	<link rel="stylesheet" type="text/css" href="assets/main.css">
</head>
<body>
	<div class="wrapper">
		<img src="assets/images/logo.png">
<?php 
if(isset($_POST['submit'])){
	if($core->FileTypeVerification($_FILES["fileToUpload"])){
		if($core->FileSizeVerification($_FILES["fileToUpload"])){
			$newfilename = $core->FileNameConvertor($_FILES["fileToUpload"]);
			if($core->UploadFile($_FILES["fileToUpload"], $newfilename)){
				 $destination = base64_encode(file_destination.'/'.$newfilename);
				?>
				<div class="notification success">
					Félicitations, nous avons bien reçu vos documents.
				</div>
				<?php
			}else{
				?>
				<div class="notification error">
					Nous avons rencontré une erreur lors du téléversement de vos documents.
				</div>
				<?php
			}
		}else{
			?>
			<div class="notification error">
			La taille de votre fichier est trop grande ou petite.
			</div>
			<?php
		}
	}else{
		?>
		<div class="notification error">
			Le format de fichier est incorrect.
		</div>
		<?php
	}
}

?>
        <form method="post" action="" enctype="multipart/form-data">
		  <input type="file" name="fileToUpload">
		  <p>Faites glisser vos fichiers dans la fenêtre ou cliquez ici - <?=sizeFormat($maxsize)?> Max</p>
		  <button name="submit" type="submit">Envoyer</button>
		  <ul>
        		<li>Supported files: <?= FILELIST; ?></li> 
        	</ul>
        </form>
    </div>



	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script type="text/javascript">
$(document).ready(function(){
  $('form input').change(function () {
  	if(this.files.length == 0){}else{
    	$('form p').text("File selected: "+this.files[0].name);
	}
  });
});
    </script>
	
	<?php if(plausibledomain&&plausibledatadomain == !null){ ?>
	<script defer data-domain="<?=plausibledatadomain?>" src="<?=plausibledomain?>/js/script.js"></script>
	<?php }  ?>
</body>
</html>
