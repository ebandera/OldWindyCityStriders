<?php
Class dbContentItems
{
    function getContentForPage($pageId,$db)
    {
        
         // $playerList=$db->query("SELECT * from ContentItem where PageId= 2 Order By SortOrder");
          
        $stmt = $db->prepare('SELECT * from ContentItem where PageId= :pageId Order By SortOrder DESC');
        $stmt->bindParam('pageId',$pageId,PDO::PARAM_INT);
        $stmt->execute();
       // $row = $stmt->fetch();
        //$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$notSure = $stmt->fetch(PDO::FETCH_NUM);
        //var_dump($notSure);exit();
        while(list($id,$pageId,$heading,$caption,$sortOrder,$expirationDate,$width,$height) = $stmt->fetch(PDO::FETCH_NUM))
        {
   
            $tempWebsiteContent = new ContentItem($id,$pageId,$heading,$caption,$sortOrder,$expirationDate,$width,$height);
            $returnList[] = $tempWebsiteContent;
            //var_dump($returnList);
            
        }
        
        return $returnList;
       

        
    }
    
    function updateContentForPage($pageId,$heading, $caption,$sortOrder,$expirationDate,$dbc)
    {
        $q = 'update ContentItem set Heading = "'. $heading . '",Caption="' . $caption . '",SortOrder=' . $sortOrder . ',ExpirationDate = ' . $expirationDate . ' WHERE PageId =' . $pageId;
        $insertRow = $mysqli_query($dbc, $q);
        if($insertRow)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    function updateContentSize($contentId,$number,$widthOrHeight,$db)
    {
        if($widthOrHeight=='width')
        {
       
        $stmt = $db->prepare('update ContentItem set widthPercent = :number WHERE Id = :contentId');
        }
        else if($widthOrHeight=='height')
        {
       
        $stmt = $db->prepare('update ContentItem set heightPixel = :number WHERE Id = :contentId');
        }
        else
        {
            return;
        }
        //$stmt = $db->prepare('SELECT * from ContentItem where PageId= :pageId Order By SortOrder DESC');
        $stmt->bindParam('number',$number,PDO::PARAM_INT);
        $stmt->bindParam('contentId',$contentId,PDO::PARAM_INT);
        $stmt->execute();  
                
    }
    
     function insertContentForPage($pageId,$heading, $caption, $expiration, $db)
    {
        //$q = sprintf("INSERT INTO ContentItem(PageId, Heading,Caption) Values(%d,'%s','%s')",$pageId,$heading,$caption);
        //$date = "2012-08-06";
        $expiration=date("Y-m-d",strtotime($expiration));
        //$expiration='2009-04-30 10:09:00';
        $stmt=$db->prepare("CALL sp_InsertContentItem(?,?,?,?)");  //call to stored procedure that will take a fortune game id, and return the newest random category
        $stmt->bindParam(1,$pageId,PDO::PARAM_INT);
        $stmt->bindParam(2,$heading,PDO::PARAM_STR);
        $stmt->bindParam(3,$caption,PDO::PARAM_STR);
        $stmt->bindParam(4,$expiration,PDO::PARAM_STR);
        $stmt->execute();
    }
    //this function will, for the give itemId submitted, on the page submitted, move the item one in the appropriate direction
    function reorderItem($pageId,$itemId,$direction,$db)
    {
        
      $stmt=$db->prepare("CALL sp_ReOrderContentItem(?,?,?)");  //call to stored procedure that will take a fortune game id, and return the newest random category
       $stmt->bindParam(1,$pageId,PDO::PARAM_INT);
       $stmt->bindParam(2,$itemId,PDO::PARAM_INT);
       $stmt->bindParam(3,$direction,PDO::PARAM_BOOL);
       $stmt->execute();
    }
    
    function cleanupPageSorting($pageId)
    {
       $stmt=$db->prepare("CALL sp_CleanupPageSorting(?)");  //call to stored procedure that will take a fortune game id, and return the newest random category
       $stmt->bindParam(1,$pageId,PDO::PARAM_INT);
       $stmt->execute();
    }
    
    function updateContentitem($contentId,$heading, $caption, $expiration, $db)
    {
        $expiration=date("Y-m-d",strtotime($expiration));
        $stmt=$db->prepare("call sp_UpdateContentItem(?,?,?,?);");  //call to stored procedure that will take a fortune game id, and return the newest random category
        $stmt->bindParam(1,$contentId,PDO::PARAM_INT);
        $stmt->bindParam(2,$heading,PDO::PARAM_STR);
        $stmt->bindParam(3,$caption,PDO::PARAM_STR);
        $stmt->bindParam(4,$expiration,PDO::PARAM_STR);
        $stmt->execute();
        
    }
     function updateCaptionOnly($contentId,$caption, $db)
    {
        $expiration=date("Y-m-d",strtotime($expiration));
        $stmt=$db->prepare("call sp_UpdateCaptionOnly(?,?);");  //call to stored procedure that will take a fortune game id, and return the newest random category
        $stmt->bindParam(1,$contentId,PDO::PARAM_INT);
        $stmt->bindParam(2,$caption,PDO::PARAM_STR);
       
        $stmt->execute();
        
    }
    function deleteContentItem($contentId,$db){
          $expiration=date("Y-m-d",strtotime($expiration));
        //$expiration='2009-04-30 10:09:00';
        $stmt=$db->prepare("DELETE from ContentItem where Id = ?");  //call to stored procedure that will take a fortune game id, and return the newest random category
        $stmt->bindParam(1,$contentId,PDO::PARAM_INT);
       
        $stmt->execute();
        
    }
    function getContentItemAsArray($contentId,$db){
        $stmt = $db->prepare('SELECT * from ContentItem where Id= :contentId');
        $stmt->bindParam('contentId',$contentId,PDO::PARAM_INT);
        $stmt->execute();
        
        //while(list($id,$pageId,$heading,$caption,$sortOrder,$expirationDate,$width,$height) = $stmt->fetch(PDO::FETCH_NUM))
       // {
   
         //   $contentObject = new ContentItem($id,$pageId,$heading,$caption,$sortOrder,$expirationDate,$width,$height);
            
        //}
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
        
    }
                
   
    
    
}

