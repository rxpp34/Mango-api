<?php

include("db.config.php") ;
$conx=new mysqli("127.0.0.1",DBUSER,DBPWD,"ASTDB") ; 
$result=$conx->query("SELECT Name,Phone FROM Contact") ; 
$rows = $result -> fetch_all(MYSQLI_ASSOC);




$fp=fopen("astdb.xml","w") ; 
fwrite($fp,"<?xml version='1.0' encoding='UTF-8'?>") ;
fwrite($fp,"<SowiloIPPhoneDirectory>") ;



foreach($rows as $row)
{
fwrite($fp,"<DirectoryEntry>") ;
fwrite($fp,"\n") ;
fwrite($fp,"<Name>".$row["Name"]."</Name>") ;
fwrite($fp,"\n") ;
fwrite($fp,"<Telephone>".$row["Phone"]."</Telephone>") ;
fwrite($fp,"\n") ;
fwrite($fp,"</DirectoryEntry>") ;
fwrite($fp,"\n") ;
}


fwrite($fp,"</SowiloIPPhoneDirectory>") ;
fclose($fp) ;



?>