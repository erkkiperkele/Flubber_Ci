//Standardized effects:
var animateDown = {
    effect: "drop",
    direction: "down",
    duration: 200,
    complete: function(){},
    easing: "easeInOutQuad"
};
var animateUp = {
    effect: "drop",
    direction: "up",
    duration: 200,
    complete: function(){},
    easing: "easeInOutQuad"
};
var animateLeft = {
    effect: "drop",
    direction: "left",
    duration: 200,
    complete: function(){},
    easing: "easeInOutQuad"
};
var animateRight = {
    effect: "drop",
    direction: "right",
    duration: 200,
    complete: function(){},
    easing: "easeInOutQuad"
};

//Setting and Unsetting hearts
$('.heart').click(function()
{
	if($(this).children().hasClass('glyphicon-heart'))
	{
		$(this).children().removeClass('glyphicon-heart').addClass('glyphicon-heart-empty');
	}
	else
	{
		$(this).children().removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
	}
});

//Carousel functionality in friends page
$(document).ready(function(){
	$('.carousel').carousel({
		interval: 2000
	});
});

$(window).scroll(function() {
    if ($(".navbar").offset().top >= 100){
        if($("#menu-profile").is(":visible") == false){
            $("#menu-profile").removeClass('hide').show(animateUp);
        }
    } else if ($("#menu-profile").is(":visible") == true){
            $("#menu-profile").hide(animateUp);
    }
});

//jQuery Drag'n drop feature for uploading images
//1. Handling the drag'n drop
var obj = $('#profile-pic, #profile-name');
obj.on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '2px dotted #0B85A1');
});
obj.on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
     $(this).css('border', '2px dotted #0B85A1');
});
obj.on('drop', function (e) 
{
 
     $(this).css('border', '2px dotted #0B85A1');
     e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
 
     //Sending the image to the Database
     handleFileUpload(files,obj, $(this).attr('id'));
     $(this).css('border', 'none');
}); 

//2. Block dropping outside the image area:
$(document).on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});
$(document).on('dragover', function (e) 
{
  e.stopPropagation();
  e.preventDefault();
});
$(document).on('drop', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});

//3. Read the image dropped on the profile section
function handleFileUpload(file,obj, elem)
{
    var fd = new FormData();
    fd.append('file', file[0]);

    //var status = new createStatusbar(obj); //Using this we can set progress.
    //status.setFileNameSize(files[i].name,files[i].size);
    sendFileToServer(fd, elem/*,status*/);
	$('#self').attr('src', baseURL + "index.php/assets/imgs/" + file.item(0).name);
}
//4. jQuery AJAX API for actual uploading to the database (currently going to the server as a file):
function sendFileToServer(formData, elem/*,status*/)
{
    var uploadURL = baseURL + "index.php/upload/file/" + elem; //Upload URL
    var extraData ={}; //Extra Data.
    var jqXHR=$.ajax({
            url: uploadURL,
            type: "POST",
            contentType:false,
            processData: false,
            cache: false,
            data: formData,
            success: function(data){
                if(elem === 'profile-pic')
                {
                    $('#'+elem).attr('src', data)
                    addProfileHeaderToMenuBar();
                }
                else
                {
                    $('#'+elem).css('background', 'url("' + data + '") no-repeat center');
                }

            }
                /*status.setProgress(100);
     
                //$("#status1").append("File upload Done<br>");           
            }*/
    }); 
 
    //status.setAbort(jqXHR);
}


//Coloring the top borders of the ContentBoxes:
$(document).ready(function(){
    $(".content").each(function(){
        $(this).children().first().css("border-top", "2px solid #1EDA2D").css("border-color", "none");
        $(this).hide();
         });
    var delaytime = 50;
    for(var item = $(".content").first(); item.length > 0; item = item.next()){
        item.delay(delaytime).show(animateDown);
         if(delaytime < 100);
            delaytime += 50;
    }
    $(".content").first().show(animateDown);
});
 /* Coloring the top borders of the Interest boxes. 
    Kept as a loop to have separate colors for separate interests. 
    Supports upto 5 at the moment. Can add more later.*/
 $(document).ready(function(){
    var interests = $(".interests");
    for(var iter = interests.first(); iter.next().length > 0; iter = iter.next()){
        iter.css("border-top", "2px solid #e74c3c").css("border-color", "none");
        iter = iter.next();
        iter.css("border-top", "2px solid #2ecc71").css("border-color", "none");
        iter = iter.next();
        iter.css("border-top", "2px solid #3498db").css("border-color", "none");
        iter = iter.next();
        iter.css("border-top", "2px solid #1abc9c").css("border-color", "none");
        iter = iter.next();
        iter.css("border-top", "2px solid #34495e").css("border-color", "none");
    }
    interests.each(function(){
        $(this).hide();
         });
    var delaytime = 200;
    for(var item = interests.first(); item.length > 0; item = item.next()){
        item.delay(delaytime).show(animateDown);
         if(delaytime < 300);
            delaytime += 50;
    }
});

//Code to add privacy:
/*
    Usage:  Simply add a class called 'privacy' to each element that must have a privacy option:
*/
var privacyElement = $('.privacyElem');
$('.privacy').each(function(){
    $(this).prepend(privacyElement.clone().removeClass('hide').click(function (){
        if($(this).hasClass('fa-user')){
            $(this).removeClass('fa-user').addClass('fa-users').children().first().text(" Public");
            var privacy = $(this).text();
            var postId = $(this).parent().parent().attr('id');
            $.ajax({
                type: "post",
                url: baseURL + "index.php/profile/updatePostPrivacy/",
                data: "postId="+postId+"&privacy="+privacy,
                });
            //.click(function(){//ADD AJAX FOR PRIVACY UPDATING OF CONTENT})
        }else{
            $(this).removeClass('fa-users').addClass('fa-user').children().first().text(" Private");
        }
     }))
});


 //Code to make things editable:
 /*
    Usage:  1.  Add a class "editable" at the element where you want the button to show
            2.  Add a class "editText" to the element which you need to be editable. If necessary 
                cover it in a div element with the above mentioned class.
            3.  Make sure editable and editText are in elements that have a common parent! 
 */


var toEdit = $('.editable');
toEdit.each(function(){
  var editContent = $(this).parent().find('.editText');
  var id = $(this).parent().find('.panel-title').attr('id');
  var editInput;
//  $(this).prepend(editbtn.clone().removeClass('hide').click(function(){
    $(this).parent().find('.editbar-btn').click(function(){
    
    var editbox = $(this).parent().find('.editbar-input');
    if(editContent.hasClass('hide')){
      if(editInput.val() === ""){
        editInput.remove();
      } else {
        editContent.text(editInput.val());
        $.ajax({
            type: "post",
            url: baseURL + "index.php/profile/updatePost/",
            data: "id="+id+"&updatedPost="+editInput.val(),
        });
        editInput.remove();
      }
      editContent.removeClass('hide');
    } else {
      var content = editContent.text();
      editContent.parent().prepend(editInput = editbox.clone().removeClass('hide')
                 .attr('placeholder', content));
      editContent.addClass('hide');
    }
  })
});

// $('.list-group-item').bind('dblclick', function() {
//     $(this).attr('contentEditable', true);
// }).blur(function() {
//     //ADD AJAX FUNCTION FOR CONTENT UPDATING
//     $(this).attr('contentEditable', false);
// });
$('.memberEdit').bind('click', function() {
    $(this).attr('contentEditable', true);
}).blur(function() {
    $(this).attr('contentEditable', false);
    var changedInfo = $(this).text();
    var field = $(this).attr('id');
    $.ajax({
        type: "post",
        url: baseURL + "index.php/profile/updateMemberInfo/",
        data: "field="+field+"&changedInfo="+changedInfo,
        });

});