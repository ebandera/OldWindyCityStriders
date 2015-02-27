<?php
class dbFiles
{

function getFilesByFileTypeArray($type,$db)
{
    
    
        $stmt = $db->prepare('call sp_GetFilesByType(?)');
        $stmt->bindParam(1,$type,PDO::PARAM_STR);
        $stmt->execute();
       // $row = $stmt->fetch();
        //$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$notSure = $stmt->fetch(PDO::FETCH_NUM);
        //var_dump($notSure);exit();
        $returnList='';
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
   
            $returnList[] = $row;
                       
        }
        
        return $returnList;
}
function uploadFileToServer($myFiles,$db)
{
    $error = false;
    $uploaddir = './images/userImages/';
    foreach($myFiles as $file)
    {
        if(move_uploaded_file($file['tmp_name'], $uploaddir . $file['name']))
        {
            //$files[] = $uploaddir .$file['name'];
            $filePath = $uploaddir . $file['name'];
            $fileName = $file['name'];
            
            $fileType = $this->determineFileType($fileName);
            $error = $this->insertFileRecordToDatabase($filePath,$fileName,$fileType,$db);
        }
        else
        {
            $error = true;
        }
    }
    return $error;
    
}

private function insertFileRecordToDatabase($filePath,$fileDisplayName,$fileType,$db)
{
     $stmt = $db->prepare('call sp_InsertFile(?,?,?)');
        $stmt->bindParam(1,$filePath,PDO::PARAM_STR);
        $stmt->bindParam(2,$fileDisplayName,PDO::PARAM_STR);
        $stmt->bindParam(3,$fileType,PDO::PARAM_STR);
        $stmt->execute();
        $error=false;
        ($stmt)? $error=false:$error=true;
        return $error;
}

private function determineFileType($fileName)
{
    $fileType;
    $pos = strrpos($fileName,'.');
    $ext = substr($fileName,$pos+1);
    if($ext=='pdf')
    {
        $fileType='pdf';
    }
    else
    {
        $fileType='image';
    }
    return $fileType;
    
}

}

