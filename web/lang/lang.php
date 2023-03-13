<?php
$lang_available = array(
    'fr' => '/fr.php',
    'en' => '/en.php'
);
// Récupération de la langue du navigateur
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $user_lang = locale_get_primary_language(locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']));
} 
else {
    $user_lang = 'fr'; // langue par défaut
}

if(array_key_exists($user_lang, $lang_available)){
    include_once(__DIR__ . $lang_available[$user_lang]);
}
else{
    include_once('fr.php');
}

//echo firstlaunch['firstlaunch'];