<?php

function getPreferredLanguages()
{
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

function findPreferredSupportedLanguage()
{
	$languages = getPreferredLanguages();
	foreach ($languages as $language) {
		$language = strtolower($language);
		$filename = "res/".$language."/strings.json";
		if (file_exists($filename)) {
			return $language;
		}
	}
	return "en";
}

function getStrings($language)
{
	return json_decode(file_get_contents("res/".$language."/strings.json"), true);
}

$language = findPreferredSupportedLanguage();
$strings = getStrings($language);

// fill missing strings in chosen language with default string from "en"
if ($language != "en") {
	$stringsEn = getStrings("en");
	foreach($stringsEn as $key => $string) {
		if (!array_key_exists($key, $strings)) $strings[$key] = $string;
	}
}

?>