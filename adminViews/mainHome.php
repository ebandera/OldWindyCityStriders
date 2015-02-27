 <div id="mainHome">
    
  
    <jqueryloadmarkerstart />
     <?php
     $tempCounter=0;
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
         echo '<div class="contentItem" id="' . $item->getId() . '" style="' . $styleString. '"><h1>' . $item->getHeading() . 
                 '</h1>'. $item->getCaption() . 
                '<div class="sortButtons">' .
                    '<input type="button" class="buttonUpdate" value = "up" onclick="sortItem(' . $item->getPageId() . ',' . $item->getId() . ',\'up\',\'' . $isAdmin .'\')" /><br />' .
                    '<input type="button" class="buttonUpdate" value = "down" onclick="sortItem(' . $item->getPageId() . ',' . $item->getId() . ',\'down\',\'' . $isAdmin .'\')" /></div>' .
                '<div class="actionButtonDiv">' .
                 '<input type="button" value="x" onclick="deleteItem(' . $item->getId() . ',\'' . $isAdmin . '\')" />' .
                 '<input type="button" value = "e" onclick="makeCKUpdate(' . $item->getId() . ')" />' .
                 '<input type="button" value = "i" onclick="startImageWindow('.$item->getId() .')" />' .
                 '<input type="hidden" id="width' . $item->getId() . '" value="' . $itemWidthPercentage . '" />' .
                 '<input type="hidden" id="height' . $item->getId() . '" value="' . $itemHeightPixel . '" />' .
                 '<span id="swidth' . $item->getId() . '">width:' . $itemWidthPercentage . '%</span> <span id = "sheight' . $item->getId() . '">height:' . $itemHeightPixel . 'px</span></div>' .
                '<div class="sliderDiv"><div class="vslider" id="vslider"></div><div class="hslider" id="hslider"></div></div>' .
                     
              '</div>';
         
     
         
              //alert($( "#slider' . $item->getId() . '" ).slider( "value" ));   

     }
     
    ?>
  
     
     <form action="." method="POST">
         <span id="spNewItem">New Heading:<input type="text" name ="heading" id="heading" />
    <div id="editor">
	</div>
	<div id="contents" style="display: none">
		<p>
			Edited Contents:
		</p>
		<!-- This div will be used to display the editor contents. -->
		<div id="editorcontents">
		</div>
	</div>
     <input type="hidden" name ="action" value ="insert" />
      <input type="hidden" name ="pageId" id="pageId" value ="<?php echo $pageIdValue;?>" />
      <input type="hidden" name="pageTitle" id="pageTitle" value="<?php echo $isAdmin;?>" />
      <input type="hidden" name="contentId" id="updatingContentId" value="" />
     <label id="lblExpires">Expires: </label> <input type="date" name="expiration" id="expiration"/><br />
     <input class="buttonUpdate" id="insertNewItemButton" type="button" value = "Insert" onclick="insertContentItem()" />
      <input class="buttonUpdate" id="updateExistingItemButton" type="button" value = "Update" onclick="updateItem()" />
     <input class="buttonUpdate" type="button" onclick="killCK()" value="Cancel"/></span>
     <input class="buttonUpdate" type="button" id="addNew" onclick="makeCKInsert()" value="Add New"/>
     <script type="text/javascript">initializeAdmin();</script>
     </form>
    <jqueryloadmarkerend />
 </div>

 


