<?php
#ip address that asterisk is on.


include("db.config.php") ;


if(isset($argv[1]) && isset($argv[2]) && isset($argv[3]))
{
    
    #Register CAll into Recent CALL
    $fnom=$argv[2] ; 
    $fnum=$argv[3] ;
    $sip=$argv[1];
    $connect = new mysqli("localhost", DBUSER,DBPWD, "ASTDB");
    $stmt=$connect->prepare('INSERT into historicall (sip,Phone,Name) VALUES (?,?,?)') ; 
    $stmt->bind_param("sss",$sip,$fnum,$fnom) ; 
    $stmt->execute() ; 

    $strHost = "192.168.5.252";

    $strUser = "admin";#specify the asterisk manager username you want to login with
    $strSecret = "Sowilo34";#specify the password for the above user
  

    $strChannel = "PJSIP/".strval($argv[1]) ;
    $strContext = "DLPN_DialPlan1";
    #specify the amount of time you want to try calling the specified channel before hangin up
    $strWaitTime = "5";
    #specify the priority you wish to place on making this call
    $strPriority = "1";
    #specify the maximum amount of retries
    $strMaxRetry = "2";

    
    $number=strval($argv[2]) ; //LE NUMERO A APPELER

    $pos=strpos ($number,"local");
        if ($number == null) :
            exit() ;
        endif ;
        
    if ($pos===false) :
    $errno=0 ;
    $errstr=0 ;
    $strCallerId = "Valider Appel : ".strval($argv[2]);
    $oSocket = fsockopen ("192.168.5.252", 5038, $errno, $errstr, 20);

        if (!$oSocket) 
        {
            echo "$errstr ($errno)<br>\n";
        } 
        else 
        {
        
            fputs($oSocket, "Action: login\r\n");
            fputs($oSocket, "Events: off\r\n");
            fputs($oSocket, "Username: $strUser\r\n");
            fputs($oSocket, "Secret: $strSecret\r\n\r\n");
            fputs($oSocket, "Action: originate\r\n");
            fputs($oSocket, "Channel: $strChannel\r\n");
            fputs($oSocket, "WaitTime: $strWaitTime\r\n");
            fputs($oSocket, "CallerId: $strCallerId\r\n");
            fputs($oSocket, "Exten: $number\r\n");
            fputs($oSocket, "Action: login\r\n");
            fputs($oSocket, "Context: $strContext\r\n");
            fputs($oSocket, "Priority: $strPriority\r\n\r\n");
            fputs($oSocket, "Async: yes\r\n\r\n" );
            sleep(2);
            fclose($oSocket); 
            echo("OK \n") ; 
            
            
        }



    else :
        exit() ;
    
    endif ;


}
else
{
    echo "ARGUMENT MISSED \n" ;
}

?>