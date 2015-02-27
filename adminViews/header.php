<!DOCTYPE html>
<html>
     <head>
        <link rel="stylesheet" href="styles/styles.css" /> 
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src ="ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src ="scripts/scripts.js"></script>
        <script type="text/javascript" src ="scripts/jquery-2.1.3.min.js"></script>
        
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
   <script>
  $(function(){initHSlider();initVSlider();$('#fileUploadObj').on('change', prepareUpload);});
  function init()
  {
      initHSlider();
      initVSlider();
      $('#fileUploadObj').change(function(e){prepareUpload();});
  }
  function initHSlider() {
      //alert("initializinHslider");
      $( ".hslider" ).slider({
            min: 20,
            max: 100                        
            });
    $(".hslider").each(function(){
        var tempId=$(this).parent().parent().attr('id');
        var hiddenWidthId = 'width' + tempId;
        var valueWidth = $("#" + hiddenWidthId).val();//document.getElementById(hiddenWidthId).value;
        $(this).slider("value", valueWidth);
        });
    $( ".hslider" ).slider({
            change: function( event, ui ) {
                updateContentAttribute('width',ui.value,ui.handle.parentNode.parentNode.parentNode.id,$("#pageTitle").val());
               
            },
            slide: function( event, ui ) {
                  //$( "#width" + ui.handle.parentNode.parentNode.parentNode.id" )
                   $("#swidth" + ui.handle.parentNode.parentNode.parentNode.id).html("width:" + ui.value + '%');
                    $("#" + ui.handle.parentNode.parentNode.parentNode.id ).css("width", ui.value + "%");
                    // .val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                    //get the right span element
               }
        });
    
    
    }
   
  function initVSlider() {
      //alert("itinializing Vertical Slider");
    $( ".vslider" ).slider({
            min: 10,
            max: 600,
            orientation: "vertical"              
            });
      
    $(".vslider").each(function(){
            //alert("how many");
            var tempId=$(this).parent().parent().attr('id');
            var hiddenHeightId = 'height' + tempId;
            valueHeight = $("#" + hiddenHeightId).val();
            $(this).slider("value", valueHeight);
            });
    $( ".vslider" ).slider({
            change: function( event, ui ) {
                updateContentAttribute('height',ui.value,ui.handle.parentNode.parentNode.parentNode.id,$("#pageTitle").val());              
            },
            slide: function( event, ui ) {
                  //$( "#width" + ui.handle.parentNode.parentNode.parentNode.id" )
                   $("#sheight" + ui.handle.parentNode.parentNode.parentNode.id).html("height:" + ui.value + 'px');
                   $("#" + ui.handle.parentNode.parentNode.parentNode.id ).css("height", ui.value + "px");
                    // .val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                    //get the right span element
               }
        });
        
    
  
    
    }
    
  
  </script>
     
        
        
     </head>
     <body id = "body">
         <div id="popupOuter"></div>
                <div id="popup">
                    <input type="button" id="popupButton"  /><br />
                    <table style="padding:10px;">
                        <tr>
                            <td id="imageSelector">
                                 Image or PDF (alt name): <br />
                                <select id="imageTagListbox" class = "listbox" name="sometext" size="5">
                                </select>
                            </td>
                            <td id="imageButtonArea">
                                <br />
                                <input class="buttonUpdate" id="previewButton" type="button" style="width:150px" value="Preview" /><br />
                                <input class="buttonUpdate" id="previewSave" type="button" style="width:150px" value="Save" /><br />
                                <input class="buttonUpdate" id="previewCancel" type="button" style="width:150px" value="Cancel" />
                                <input class="buttonUpdate" id="previewClear" type="button" style="width:150px" value="Clear Preview" />
                            </td>
                            <td rowspan="3" id="savedImageSelector">
                                Existing Image Directory:<br />
                                <select id="imageFileListbox" class = "listbox" name="sometext" size="15">
                                   
                                </select>
                            </td>
                        </tr>
                        <tr>
                            
                            <td colspan="2">
                                The Current Image Tag:<br />
                                <input type="text" id="htmlImageText" name="htmlImageText" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:right;">
                                <input class="buttonUpdate" type="button" onclick="deleteFile()" style="width:250px;" value="Delete Image (right)" /><br />
                                 <input type="file" style="width:250px" id="fileUploadObj" name="file1"  /><br />
                                <input class="buttonUpdate" type="button" onclick="uploadFile()" style="width:250px" value="Upload Image (right)" />
                            </td>
                        </tr>
                        <tr >
                            <td colspan="3" id="previewDisplay" style="background-color:#666666;height:400px;"></td>
                        </tr>
                    </table>
                    
                   
                </div>
         
         
         <div id="header">  
            
            <div id="navbar">
                <a class = "menuItemAnchor" href=".?goto=AdminHome"><div class="menuItem">Home</div></a>
                <a class = "menuItemAnchor"href=".?goto=AdminCalendar"><div class="menuItem">Calendar</div></a>
                <a class = "menuItemAnchor"href=".?goto=AdminNewspage"><div class="menuItem">Newspage</div></a>
                <a class = "menuItemAnchor"href=".?goto=AdminPhotos"><div class="menuItem">Photos</div></a>
                <a class = "menuItemAnchor"href=".?goto=AdminResults"><div class="menuItem">Results</div></a>
                <a class = "menuItemAnchor"href=".?goto=AdminBoard"><div class="menuItem">Board</div></a>
                <a class = "menuItemAnchor"href=".?goto=AdminJoin"><div class="menuItem">Join</div></a>
                <a class = "menuItemAnchor"href=".?goto=AdminLinks"><div class="menuItem">Links</div><a>
                <a class = "menuItemAnchor"href=".?goto=AdminSponsors"><div class="menuItem">Sponsors</div></a>
            </div>
             <a href=".?goto=Home"><img style="float:left" src="./images/windyCityLogo.png" /></a>
         </div>
         <div id="spacer"></div>
         
         
         
    
