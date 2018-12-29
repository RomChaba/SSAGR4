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

die();
