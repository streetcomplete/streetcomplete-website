<?php 
require_once "_intl.php";
header("Vary: Accept-Language");
?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?php echo $strings["about_title_privacy_statement"]; ?></title>
<link rel="stylesheet" href="style.css"/>
<link rel="icon" href="images/favicon.svg">
<style>

</style>
</head>
<body>
<div class="center">
	<div style="margin-left: 32px; margin-right: 32px;">
		<a href="/">&lt; Home</a>
		<h1><?php echo $strings["about_title_privacy_statement"]; ?></h1>
		<?php 
		echo $strings["privacy_html"];
		echo sprintf($strings["privacy_html_tileserver2"], "JawgMaps", "https://www.jawg.io/en/confidentiality/");
		echo $strings["privacy_html_statistics"];
		echo $strings["privacy_html_third_party_quest_sources"];
		echo $strings["privacy_html_image_upload2"];
		?>
	</div>
</div>
<?php include "_footer.php"; ?>
</body>
</html>