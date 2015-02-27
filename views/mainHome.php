 <div id="mainHome">
     <?php
      foreach($webpageContentList as $item)
     {
         //get values with code
         $itemWidthPercentage=$item->getWidth();
         if($itemWidthPercentage ==null) {$itemWidthPercentage=97;}
         $itemHeightPixel = $item->getHeight();
         $styleString='width:'.$itemWidthPercentage.'%;';
         if($itemHeightPixel != null){$styleString .='height:' . $itemHeightPixel . 'px;';}
         //handle hr right here using counter
         $tempCounter += $itemWidthPercentage;
         if($tempCounter > 97)
         {
             echo "<hr>";
             $tempCounter=$itemWidthPercentage;
         }
         echo '<div class="contentItemDisplay" id="' . $item->getId() . '" style="' . $styleString. '"><h1>' . $item->getHeading() . 
                 '</h1>'. $item->getCaption() . '</div>';
           
         
     
         
              //alert($( "#slider' . $item->getId() . '" ).slider( "value" ));   

     }
     
    ?>
 </div>
