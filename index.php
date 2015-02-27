<?php

require_once('BDL/DataAccess/database.php');

require_once('BDL/DataAccess/dbContentItems.php');

require_once('BDL/DataAccess/dbFiles.php');

require_once('BDL/BusinessClasses/ContentItem.php');

require_once('BDL/BusinessClasses/File.php');


$goto='Home';
$insert='none';
$update='none';
$action='none';
$pageId = 0;
//var_dump($_GET);
//get the action whether get or post
if(isset($_GET['action'])){ $action= $_GET['action'];}
if(isset($_POST['action'])){ $action= $_POST['action'];}
if(isset($_GET['goto'])){ $goto= $_GET['goto'];}
if(isset($_POST['goto'])){ $goto= $_POST['goto'];}
(isset($_POST['update']))? $update = $_POST['update']:$update='none';
(isset($_POST['insert']))? $insert = $_POST['insert']:$insert='none';
$dbContentItemObject = new dbContentItems();
$dbFilesObject = new dbFiles();

//v///ar_dump($webpageContentList);


// (isset($_POST['action']))? $action = $_POST['action']:$action='';

//insert will only have Caption and header
 //var_dump($_POST);
 //var_dump($action);
switch($action)
{
    case 'reorderitem':
       if (isset($_POST['pageId'])&& isset($_POST['contentId'])&& isset($_POST['direction']))
       {
           $pageId = $_POST['pageId'];
           $contentId = $_POST['contentId'];
           $direction = $_POST['direction'];
           
           $pageId = (int)$pageId;
           $contentId = (int)$contentId;
           ($direction=='up')?$direction=true:$direction=false;
           
           $dbContentItemObject->reorderItem($pageId,$contentId,$direction,$db);
           
           
       }
       break;
    case 'insert':
         (isset($_POST['pageId']))? $pageId = $_POST['pageId']:$pageId='';
        (isset($_POST['caption']))? $caption = $_POST['caption']:$caption='';
        (isset($_POST['heading']))? $heading = $_POST['heading']:$heading='';
        (isset($_POST['expiration']))? $expiration = $_POST['expiration']:$expiration=0;
        $webpageContentList = $dbContentItemObject->insertContentForPage($pageId,$heading,$caption,$expiration,$db);
        
        break;
    case 'updateContentSize':
        (isset($_POST['width']))? $width = $_POST['width']:$width='';
        (isset($_POST['height']))? $height = $_POST['height']:$height='';
        (isset($_POST['contentId']))? $contentId = $_POST['contentId']:$contentId='';
        if($contentId!=''&&$width!='')
        {
            $dbContentItemObject->updateContentSize($contentId,$width,'width',$db);
        }
        else if($contentId!=''&&$height!='')
        {
            $dbContentItemObject->updateContentSize($contentId,$height,'height',$db);
        }
        break;
    case 'updateContentItem':
        (isset($_POST['contentId']))? $contentId = $_POST['contentId']:$contentId='';
        (isset($_POST['caption']))? $caption = $_POST['caption']:$caption='';
        (isset($_POST['heading']))? $heading = $_POST['heading']:$heading='';
        (isset($_POST['expiration']))? $expiration = $_POST['expiration']:$expiration=0;
        if($contentId!=''&&$caption!=''&&$heading!='')
        {
            $dbContentItemObject->updateContentItem($contentId,$heading,$caption,$expiration,$db);
            
        }
        else if($contentId!=''&&$caption!='')  //for updating only the caption
        {
            $dbContentItemObject->updateCaptionOnly($contentId,$caption,$db);
        }
        break;
    case 'deleteContentItem':
        (isset($_POST['contentId']))? $contentId = $_POST['contentId']:$contentId='';
        if($contentId!='')
        {
            $dbContentItemObject->deleteContentItem($contentId, $db);
            
        }
        break;
    case 'getItem':
        (isset($_POST['contentId']))? $contentId = $_POST['contentId']:$contentId='';
        if($contentId!='')
        {
            echo JSON_encode($dbContentItemObject->getContentItemAsArray($contentId, $db));
            exit();
            
        }
        break;
    case 'displayImageWindow':   //updated version of get item
        (isset($_POST['contentId']))? $contentId = $_POST['contentId']:$contentId='';
        if($contentId!='')
        {
            $arrayForItem=$dbContentItemObject->getContentItemAsArray($contentId, $db);
            //var_dump($arrayForItem);
            $arrayForFiles = $dbFilesObject->getFilesByFileTypeArray('image', $db);
            $arrayForFiles = array('Files'=>$arrayForFiles);
            //var_dump($arrayForFiles);
            $combinedArray = array_merge($arrayForItem,$arrayForFiles);
            //echo 'hello';
            echo JSON_encode($combinedArray);
            exit();
            
        }
        break;
    case 'uploadImageFile': 
        if(isset($_FILES)){
            $dbFilesObject->uploadFileToServer($_FILES,$db);
        }
        break;
    default:
    
}
$pageIdValue='';
$isAdmin=false;
switch($goto)
{   
    
    case 'Home':
        $pageIdValue=4;      
        break;
    case 'Calendar':
        $pageIdValue=5;
        break;
    case 'Newspage':
        $pageIdValue=3;
        break;
    case 'Photos':
        $pageIdValue=6;
        break;
    case 'Results':
        $pageIdValue=7;
        break;
    case 'Board':
        $pageIdValue=8;
        break;
    case 'Join':
        $pageIdValue=9;
        break;
    case 'Links':
        $pageIdValue=10;
        break;
    case 'Sponsors':
        $pageIdValue=11;
        break;
    case 'AdminHome':
        $pageIdValue=4;
        $isAdmin='AdminHome';
        break;
    case 'AdminCalendar':
        $pageIdValue=5;
        $isAdmin='AdminCalendar';
        break;
    case 'AdminNewspage':
        $pageIdValue=3;
        $isAdmin='AdminNewspage';
        break;
    case 'AdminPhotos':
        $pageIdValue=6;
       $isAdmin='AdminPhotos';
        break;
    case 'AdminResults':
        $pageIdValue=7;
        $isAdmin='AdminResults';
        break;
    case 'AdminBoard':
        $pageIdValue=8;
        $isAdmin='AdminBoard';
        break;
    case 'AdminJoin':
        $pageIdValue=9;
        $isAdmin='AdminJoin';
        break;
    case 'AdminLinks':
        $pageIdValue=10;
        $isAdmin='AdminLinks';
        break;
    case 'AdminSponsors':
        $pageIdValue=11;
        $isAdmin='AdminSponsors';
        break;
    deafult:
        $pageIdValue=4;
        
        
}
$webpageContentList = $dbContentItemObject->getContentForPage($pageIdValue,$db);
if($isAdmin) //if the value is populated
{
include('adminViews/header.php');
include('adminViews/mainHome.php');
}
else
{
 include('views/header.php');
include('views/mainHome.php');  
}

include('views/footer.php');

?>