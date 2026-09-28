<?php

function getLanguageRequestParam()
{
	if (array_key_exists("lang", $_REQUEST)) return "?lang=".urlencode($_REQUEST["lang"]);
	else return "";
}

function getPreferredLanguages()
{
	if (array_key_exists("lang", $_REQUEST)) return array($_REQUEST["lang"]);
	$httpAcceptLanguage = array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : "";
	$languagesWithWeights = explode(',', $httpAcceptLanguage);
	$result = array();
	foreach ($languagesWithWeights as $languageWithWeight) {
		$language = explode(';q=', $languageWithWeight);
		// ;q=... is optional
		$result[$language[0]] = isset($language[1]) ? floatval($language[1]) : 1;
	}
	arsort($result);
	return array_keys($result);
}

function getSupportedLanguages()
{
	return array_filter(scandir("res"), function($f) {
		return is_dir("res/".$f) && !str_starts_with($f, ".");
	});
}

function findPreferredSupportedLanguage()
{
	$languages = getPreferredLanguages();
	$supported = getSupportedLanguages();
	foreach ($languages as $language) {
		if (in_array($language, $supported)) {
			return $language;
		}
	}
	return "en";
}

function getStrings($language)
{
	$file = "res/".$language."/strings.json";
	if (file_exists($file)) {
		return json_decode(file_get_contents($file), true);
	} else {
		return null;
	}

}

function getDir($language)
{
	// and more... but we don't have translations for these anyway
	$rtl = array("ar", "fa", "he", "ps", "ur", "yi");
	if (in_array($language, $rtl)) {
		return "rtl";
	} else {
		return "ltr";
	}
}

$language = findPreferredSupportedLanguage();
$supportedLanguages = getSupportedLanguages();
$stringsEn = getStrings("en");
$strings = getStrings($language) ?? $stringsEn;
$dir = getDir($language);

// fill missing strings in chosen language with default string from "en"
if ($language != "en") {
	foreach($stringsEn as $key => $string) {
		if (!array_key_exists($key, $strings)) $strings[$key] = $string;
	}
}

?>
