<?php 
require_once "_intl.php";
header("Vary: Accept-Language");
?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo $strings["store_listing_short_description"]; ?>">
<title>StreetComplete</title>
<link rel="stylesheet" href="res/style.css">
<link rel="icon" href="res/favicon.svg">
<?php
	foreach ($supportedLanguages as $lang) {
		echo "<link rel=\"alternate\" hreflang=\"".$lang."\" href=\"?lang=".$lang."\">\n";
	}
?>
<link rel="alternate" hreflang="x-default" href="?lang=en" />
<style>

#intro {
	text-align: center;
	margin-bottom: 32px;
	margin-top: 48px;
}

#phone_and_description {
	display: flex;
	flex-direction: row;
}

@media (max-width: 640px) {
	#phone_and_description {
		flex-direction: column;
	}
}

@media (max-width: 420px) {
	#phone_screenshot_switcher > button {
		margin-left: -64px;
		margin-right: -64px;
	}
}

#phone_screenshot_switcher {
	align-self: center;
	flex-shrink: 0;
	display: flex;
	flex-direction: row;
	align-items: stretch;
}

#phone_screenshot_switcher > * {
}

#phone_screenshot_switcher > button {
	transition-duration: 0.3s;
	background-color: transparent;
	border: 0;
	padding: 12px;
	border-radius: 20px;
}

#phone_screenshot_switcher > button:hover {
	transition-duration: 0.3s;
	background-color: rgba(128,128,128,0.4);
}

#phone {
	display: grid;
	/* original dimensions (assuming dpi=3) * 80% (because the pixel 6 is just huge...) */
	width: 322.4px;
	height: 680.8px;
	border-radius: 21px;
	box-shadow: 0 4px 8px 0 rgba(128, 128, 128, 0.6), 0 6px 20px 0 rgba(128, 128, 128, 0.6);
}

#description {
	margin: 16px;
}

#phone > * {
	grid-column: 1;
	grid-row: 1;
}

#screenshots {
	margin-top: 18px;
	margin-bottom: 22px;
	margin-left: 16px;
	margin-right: 18px;
	overflow: hidden;
	white-space: nowrap;
}

#screenshots > * {
	background-repeat: no-repeat;
	background-size: cover;
	width: 100%;
	height: 100%;
	display: inline-block;
}

#phone_frame {
	margin: 0px;
	background-repeat: no-repeat;
	background-size: cover;
	background-image: url("res/pixel6.webp");
}

#languages {
	position: absolute;
	top: 0;
	right: 0;
	margin: 8px;
}

#language_select {
	display: none;
}

#download_buttons {
	margin: 0 auto;
	display: flex;
	max-width: 646px;
	flex-wrap: nowrap;
	justify-content: center;
}

@media (prefers-color-scheme: dark) {
	.monochrome_icon {
		fill: #fff;
	}
}

</style>
<script>
function changeLanguage(lang) {
	const url = new URL(window.location);
	url.searchParams.set("lang", lang);
	window.location = url.href;
}
function showLanguageSelector() {
	document.getElementById("language_select").style.display = "inline";
}
</script>
</head>
<body>
<div id="languages"><span style="cursor:pointer" onclick="showLanguageSelector()">🌐</span> <select id="language_select" onchange="changeLanguage(this.value)"><?php
foreach ($supportedLanguages as $supportedLanguage) {
	$displayLanguage = Locale::getDisplayName($supportedLanguage, $supportedLanguage);
	if ($displayLanguage) {
		$selected = $supportedLanguage == $language ? "selected" : "";
		echo "	<option ".$selected." value=\"".$supportedLanguage."\">".$displayLanguage."</option>\n";
	}
}
?></select></div>
<div class="center">
	<div id="intro">
		<img src="res/favicon.svg" alt="App Icon">
		<h1>StreetComplete</h1>
		<p class="subhead"><?php echo $strings["store_listing_short_description"]; ?></p>
		<div id="download_buttons">
			<a aria-label="Google Play" href="https://play.google.com/store/apps/details?id=de.westnordost.streetcomplete"><img alt="Google Play Badge" src="res/google-play-badge.png"></a><a aria-label="F-Droid" href="https://f-droid.org/packages/de.westnordost.streetcomplete/"><img alt="F-Droid Badge" src="res/f-droid-badge.png"></a>
		</div>
		<?php 
		if (str_starts_with($_SERVER["REQUEST_URI"], "/s?")) { 
			echo "<div class=\"infobox\">".sprintf($strings["urlconfig_scan_qr_code_again2"], "streetcomplete:/".$_SERVER["REQUEST_URI"])."</div>";
		} ?>
	</div>
	<hr>
	<div id="phone_and_description">
		<div id="phone_screenshot_switcher">
			<button aria-label="Previous Screenshot" style="z-index: 1;" id="previousScreenshotButton">
				<svg width="24" height="48" viewBox="0 0 3 6"><path d="m0,3 l2,3 h1 l-2,-3 l2,-3 h-1z" class="monochrome_icon"></path></svg>
			</button>
			<div id="phone">
				<div id="screenshots">
					<?php
					function isScreenshot($var) {
						return str_ends_with($var, ".webp"); 
					}
					
					$screenshotDir = "res/".$language;
					$screenshots = array_filter(scandir($screenshotDir), "isScreenshot");
					
					if (count($screenshots) == 0) {
						$screenshotDir = "res/en";
						$screenshots = array_filter(scandir($screenshotDir), "isScreenshot");
					}
					
					foreach ($screenshots as $screenshot) {
						echo "<div style=\"background-image: url('".$screenshotDir."/".$screenshot."')\"></div>";
					}
					?>
				</div>
				<div id="phone_frame"></div>
			</div>

			<button aria-label="Next Screenshot" style="z-index: 1;" id="nextScreenshotButton">
				<svg width="24" height="48" viewBox="0 0 3 6"><path d="m3,3 l-2,3 h-1 l2,-3 l-2,-3 h1z" class="monochrome_icon"></path></svg>
			</button>
		</div>
		<div id="description">
<?php 
			echo str_replace(
				array("\n", "OpenStreetMap"),
				array("<br>", "<a href=\"https://osm.org\">OpenStreetMap</a>"),
				$strings["store_listing_full_description"]
			); 
?>
		</div>
	</div>
</div>
<?php include "_footer.php"; ?>
<script>
var screenshotId = 0

var screenshots = document.getElementById("screenshots").children
var phone = document.getElementById("phone")
var prevButton = document.getElementById("previousScreenshotButton")
var nextButton = document.getElementById("nextScreenshotButton")

function switchScreenshot(add) {
	if (add > 0) { 
		if (screenshotId < screenshots.length-1) screenshotId++
	} else {
		if (screenshotId > 0) screenshotId--
	}
	// scrolling up a tiny amount to workaround a bug(?) that can only be reproduced in Chrome for Android:
	// scrollIntoView would only do anything when it could also scroll vertically to it
	window.scrollBy({ top: -0.1, behavior: 'instant'})
	screenshots[screenshotId].scrollIntoView({behavior: "smooth"})
	updateButtonsVisibility();
}

function updateButtonsVisibility() {
	nextButton.style.visibility = screenshotId < screenshots.length-1 ? "visible" : "hidden";
	prevButton.style.visibility = screenshotId > 0 ? "visible" : "hidden";
}

prevButton.onclick = function() { switchScreenshot(-1) }
nextButton.onclick = function() { switchScreenshot(+1) }
phone.onclick = function(e) { switchScreenshot(Math.sign(e.offsetX - phone.offsetWidth/2)) }
updateButtonsVisibility();

</script>
</body>
</html>
