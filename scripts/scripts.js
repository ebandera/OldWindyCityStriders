var editor, html = '';


function initializeAdmin()
{
     $("#spNewItem").hide();
     $("#addNew").show();
    
}
function sortItem(pageId,contentId,direction,pageTitle)
{
  

  $.ajax({
        type: "POST",
        url: ".",
        data: { action: "reorderitem", pageId: pageId, contentId: contentId ,direction: direction,goto: pageTitle},
        success: function(data){
         
            var pageTextBetweenDelimiters = data.substring(data.indexOf("<jqueryloadmarkerstart />"),data.indexOf("<jqueryloadmarkerend />"));
              $("#mainHome").html(pageTextBetweenDelimiters);
             //window.location.assign(".?goto=AdminHome");
        }
    }).done(function( msg ) {
       initVSlider();
       initHSlider();
     
    });
 
}

function deleteItem(contentId,pageTitle)
{
  

  $.ajax({
        type: "POST",
        url: ".",
        data: { action: "deleteContentItem", contentId: contentId ,goto: pageTitle},
        success: function(data){
         
            var pageTextBetweenDelimiters = data.substring(data.indexOf("<jqueryloadmarkerstart />"),data.indexOf("<jqueryloadmarkerend />"));
              $("#mainHome").html(pageTextBetweenDelimiters);
             //window.location.assign(".?goto=AdminHome");
        }
    }).done(function( msg ) {
       initVSlider();
       initHSlider();
        //window.location.assign(".?goto=AdminHome");
    });
 
}

function updateItem(){
     var contentId = $("#updatingContentId").val();
     var pageTitle = $("#pageTitle").val();
     $.ajax({
        type: "POST",
        url: ".",
        data: { action: "updateContentItem", contentId: contentId, expiration: $("#expiration").val() ,heading:$("#heading").val(),caption: editor.getData()}
    }).done(function( msg ) {
        alert( "Data Saved!");
        window.location.assign('.?goto=' + pageTitle);
    });
    
}

function killCK(){
    //alert("killing");
     
       $("#spNewItem").hide();
       $("#addNew").show();
    if ( !editor )
				return;

			// Retrieve the editor contents. In an Ajax application, this data would be
			// sent to the server or used in any other way.
			document.getElementById( 'editorcontents' ).innerHTML = html = editor.getData();
			document.getElementById( 'contents' ).style.display = '';

			// Destroy the editor.
			editor.destroy();
			editor = null;
}

function makeCKInsert() {
   // alert("making");
   
   $("#spNewItem").show();
   $("#addNew").hide();
   $("#insertNewItemButton").show();
   $("#updateExistingItemButton").hide();
  
			if ( editor )
				return;

			// Create a new editor inside the <div id="editor">, setting its value to html
			var config = {};
			editor = CKEDITOR.appendTo( 'editor', config, html );
	
}
function makeCKUpdate(contentId)
{
     $("#spNewItem").show();
    $("#addNew").hide();
    $("#updateExistingItemButton").show();
    $("#insertNewItemButton").hide();
    
      $.ajax({
        type: "POST",
        url: ".",
        data: { action: "getItem", contentId: contentId},
        success: function(data){
         var contentObject = jQuery.parseJSON(data);
        //alert( contentObject.Id);
        //alert(data);
        if ( editor )
	return;
        var config = {};
	editor = CKEDITOR.appendTo( 'editor', config, contentObject.Caption );   
        $("#heading").val(contentObject.Heading);
        $("#expiration").val(contentObject.ExpirationDate);
        $("#updatingContentId").val(contentObject.Id);
        }
        
    }).done(function( msg ) {
        //alert( "Data Saved!");
        //window.location.assign('.?goto=' + pageTitle);
    });
  
  
		//	if ( editor )
			//	return;

			
		//	var config = {};
			//editor = CKEDITOR.appendTo( 'editor', config, 'hello' );
                      

}

function insertContentItem() {
    
    $.ajax({
        type: "POST",
        url: ".",
        data: { action: "insert", pageId: $("#pageId").val(), expiration: $("#expiration").val() ,heading:$("#heading").val(),caption: editor.getData()}
    }).done(function( msg ) {
        alert( "Data Saved!");
        window.location.assign('.?goto=' + $("#pageTitle").val());
    });
   
}
function updateContentAttribute(attribute,number,contentId,pageTitle){
    var width = '';
    var height='';
    if (attribute==='width'){width=number;}
        if (attribute==='height'){height=number;}
    
     $.ajax({
        type: "POST",
        url: ".",
        data: { action: "updateContentSize", width: width, height: height ,contentId:contentId,goto: pageTitle},
        success: function(data){
         
            var pageTextBetweenDelimiters = data.substring(data.indexOf("<jqueryloadmarkerstart />"),data.indexOf("<jqueryloadmarkerend />"));
              $("#mainHome").html(pageTextBetweenDelimiters);
             
        }
    }).done(function( msg ) {
        
       initVSlider();
       initHSlider();
        
        
    });
    
}

function popupDisplay()
{
   
	
	//var theButton=$("#popupButton");
	//alert(theButton);
    $("#popupButton").bind("click",function(){hidePopup();return;});
    $("#previewButton").bind("click",function(){preview();return;});
    $("#previewClear").bind("click",function(){startImageWindow(m_contentId);return;});
    $("#previewSave").bind("click",function(){previewSave();return;});
    $("#previewCancel").bind("click",function(){hidePopup();return;});
      
	//theButton.onclick=function(){alert("hidey");hidePopup();return;};

    var theDiv=document.getElementById('popup');
    var theOuterDiv=document.getElementById('popupOuter');
  
   
    theDiv.style.display='table-cell';
    theOuterDiv.style.display='block';
    
}
function hidePopup()
{

    //var theDiv=document.getElementById('popup');  //consider changing to jquery
    //var theOuterDiv=document.getElementById('popupOuter');
    //theDiv.style.display='none';
   // theOuterDiv.style.display='none';
    var pageTitle = $("#pageTitle").val();
     window.location.assign('.?goto=' + pageTitle);
}
var m_contentId;
function startImageWindow(contentId)
{
    m_contentId=contentId;
    clearImageWindow();  //make sure that there are no old items in the listboxes, so that it can be reloaded fresh
    $.ajax({
        type: "POST",
        url: ".",
        data: { action: "displayImageWindow", contentId: contentId},
        success: function(data){
        
            var contentObject = jQuery.parseJSON(data);
            //alert("yo");
            sessionStorage.workingCaption = contentObject.Caption;
            var tempReturn = returnArrayWithImageTagsFromCaption(contentObject.Caption);
            if(tempReturn!==null)
            {
      
                for(i=0;i<tempReturn.length;i++)
                {
                    $('#imageTagListbox').append('<option value="' + tempReturn[i][1] + '">' + tempReturn[i][1] + '</option>'); //using the "alt" items in the 0 index is the image tag
           
                }
                for(i=0;i<contentObject.Files.length;i++)
                {
            
                    $('#imageFileListbox').append('<option value="' + contentObject.Files[i].Path + '">' + contentObject.Files[i].DisplayName + '</option>');
                }
                $("#previewDisplay").html(contentObject.Caption);  //set the preview;
                popupDisplay();
	       
            }
        }
        
    }).done(function( msg ) {
      
    });
    
    
}
function clearImageWindow()
{
    $('#imageTagListbox').empty();
    $('#imageFileListbox').empty();
}

function returnArrayWithImageTagsFromCaption(caption)
{
    //alert(caption);
    var match = caption.match(/<img.*?\/>/g);
    if(match!==null)
    {
        var dict=[];
    //alert(match.length);
        for(i=0;i<match.length;i++)
        {
            dict[i]= [];
            dict[i][0]=match[i];
            dict[i][1]=returnAltValueFromImageTag(match[i]);
        }
        return dict;
    }
    else
    {
        alert('There are no images to edit!  Enter an image using the "e" button, and then insert later.');
        return null;
    }
    
    
}
function returnAltValueFromImageTag(imageTag)
{
   
    var match=/alt="([^"]+)"/.exec(imageTag);
    return match[1];
}
function imageTagIsImage(imageTag)
{
    
}
var files;
function uploadFile(event)
{

    // START A LOADING SPINNER HERE

    // Create a formdata object and add the files
    var data = new FormData();
    //prepare the post data, but be sure to add the action for the controller
   
    data.append('action','uploadImageFile');
   //alert("uploadingFile");
    $.each(files, function(key, value)
    {
        data.append(key, value);
    });

    $.ajax({
        url: 'index.php',
        type: 'POST',
        data: data,
        cache: false,
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data)
        {
            //alert('gotHere9');
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                //reload the form
                startImageWindow(m_contentId);
                
            }
            else
            {
                // Handle errors here
                //console.log('ERRORS: ' + data.error);
                alert(data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus);
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });
}


function prepareUpload(event)
{
 
  files = event.target.files;
}

function preview()
{
    var selectedLeftAlt = $('#imageTagListbox').find(":selected").val();
    var selectedRightPath = $('#imageFileListbox').find(":selected").val();
  
    var tempContent = returnUpdatedContentItemForImage(selectedLeftAlt,selectedRightPath);
    sessionStorage.workingCaption = tempContent;
    $("#previewDisplay").html(tempContent);
}

function returnUpdatedContentItemForImage(leftAlt,rightPath)
{
    
    //step 1.  Retreive caption
    var tempCaptionFull = sessionStorage.workingCaption;
   
    //step 2. get all the image tags
    var imgTagArray = returnArrayWithImageTagsFromCaption(tempCaptionFull);  //2 dimensional array 0 is full 1 is the alt
    
    var strBeginningWorkingImgTag='';
   
    if(imgTagArray!==null)  //assuming there is at least one image tag
    {
        for(i=0;i<imgTagArray.length;i++) //go through each tag
        {
            if(leftAlt==imgTagArray[i][1])//if the alt's match
            {
                
                strBeginningWorkingImgTag=imgTagArray[i][0];
            }
        }
        var updatedImageTag= imgReplaceSrcWithNew(strBeginningWorkingImgTag,rightPath);
        
        return tempCaptionFull.replace(strBeginningWorkingImgTag, updatedImageTag);
        
        
    }
    else
    {
    return null;
    }
    
    
}
function imgReplaceSrcWithNew(imageTag,src)
{
   
    var myreturn = imageTag.replace(/(<img.*?src=")(.*?)(".*?\/>)/,"$1"+src+"$3");
    
     return myreturn;
}  
function previewSave()
{          //  sessionStorage.workingCaption = contentObject.Caption;

    $.ajax({
        type: "POST",
        url: ".",
        data: { action: "updateContentItem", contentId: m_contentId, caption: sessionStorage.workingCaption}
    }).done(function( msg ) {
        alert( "Data Saved!");
      
    });
   
}
    



