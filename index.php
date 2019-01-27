<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 07/12/2018
 * Time: 12:37
 */










//phpinfo();

echo "Si 'sqlsrv' n'est pas dans la site c'est que les .dll sont mal configurées  ";
var_dump(PDO::getAvailableDrivers());




try {
    $bdd = new PDO('sqlsrv:Server=(local);Database=bddtest',"admin", "admin");
    $bdd->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}

catch( PDOException $e ) {
    var_dump($e);
    echo $e->errorInfo[2];
    die( "Error connecting to SQL Server" );
}

echo "Connected to SQL Server\n";


$req = $bdd->query("SELECT * FROM table_test");

$out = $req->fetchAll();

var_dump($out);

$date_encryptee = _ENCRYPTE_DATA("toto");

echo ("Exemple du cryptage de données: ex : toto <br><br>");

echo"Données crypté: ";
echo ("<br>");
echo ($date_encryptee);
echo ("<br>");

echo"Données décrypté: ";
echo ("<br>");
echo (_DECRYPTE_DATA($date_encryptee));
echo ("<br>");



function _ENCRYPTE_DATA($string)
{
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'SSAGR4';
    $secret_iv = 'coucou';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);

    return $output;

}


function _DECRYPTE_DATA($string) {
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'SSAGR4';
    $secret_iv = 'coucou';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);


    return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
}




//web/app_dev.php

?>
<a href="web/app_dev.php">Lien vers le DEV</a>
<br>
<a href="web/">Lien vers le PROD</a>