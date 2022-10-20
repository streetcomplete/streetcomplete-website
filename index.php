<?php 
require_once "_intl.php";
header("Vary: Accept-Language");
?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="<?php echo $strings["store_listing_short_description"]; ?>"/>
<title>StreetComplete</title>
<link rel="stylesheet" href="style.css"/>
<link rel="icon" href="images/favicon.svg">
<style>

#intro {
	text-align: center;
	margin-bottom: 32px;
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
	background-color: rgb(0,0,0,0.2);
}

#phone {
	display: grid;
	/* original dimensions (assuming dpi=3) * 80% (because the pixel 6 is just huge...) */
	width: 322.4px;
	height: 680.8px;
	border-radius: 21px;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
	background-image: url("images/pixel6.webp");
}

</style>
</head>
<body>
<div class="center">
	<div id="intro">
		<h1>StreetComplete</h1>
		<p class="subhead"><?php 
		echo str_replace(
			"OpenStreetMap",
			"<a href=\"https://osm.org\">OpenStreetMap</a>",
			$strings["store_listing_short_description"]
		);
		?></p>
		<div>
			<a aria-label="Google Play" href="https://play.google.com/store/apps/details?id=de.westnordost.streetcomplete"><img alt="Google Play Badge" src="images/google-play-badge.png" height="80"/></a><a aria-label="F-Droid" href="https://f-droid.org/packages/de.westnordost.streetcomplete/"><img alt="F-Droid Badge" src="images/f-droid-badge.png" height="80"/></a><a aria-label="GitHub" href="https://github.com/streetcomplete/StreetComplete/releases/latest"><img alt="GitHub Badge" src="images/github-badge.png" height="80"/></a>
		</div>
	</div>
	<hr>
	<div id="phone_and_description">
		<div id="phone_screenshot_switcher">
			<button aria-label="Previous Screenshot" style="z-index: 1;" id="previousScreenshotButton">
				<svg width="24" height="48" viewBox="0 0 3 6"><path d="m0,3 l2,3 h1 l-2,-3 l2,-3 h-1z" style="fill:#000"></path></svg>
			</button>
			<div id="phone">
				<div id="screenshots">
					<div style='background-image: url("images/screenshot1.webp")'></div>
					<div style='background-image: url("images/screenshot2.webp")'></div>
					<div style='background-image: url("images/screenshot3.webp")'></div>
					<div style='background-image: url("images/screenshot4.webp")'></div>
					<div style='background-image: url("images/screenshot5.webp")'></div>
					<div style='background-image: url("images/screenshot6.webp")'></div>
					<div style='background-image: url("images/screenshot7.webp")'></div>
					<div style='background-image: url("images/screenshot8.webp")'></div>
				</div>
				<div id="phone_frame"></div>
			</div>

			<button aria-label="Next Screenshot" style="z-index: 1;" id="nextScreenshotButton">
				<svg width="24" height="48" viewBox="0 0 3 6"><path d="m3,3 l-2,3 h-1 l2,-3 l-2,-3 h1z" style="fill:#000"></path></svg>
			</button>
		</div>
		<p id="description">
		<?php 
		echo str_replace(
			array("\n", "OpenStreetMap"),
			array("<br>", "<a href=\"https://osm.org\">OpenStreetMap</a>"),
			$strings["store_listing_full_description"]
		); ?>
		</p>
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
}

prevButton.onclick = function() { switchScreenshot(-1) }
nextButton.onclick = function() { switchScreenshot(+1) }
phone.onclick = function(e) { switchScreenshot(Math.sign(e.offsetX - phone.offsetWidth/2)) }

</script>
</body>
</html>