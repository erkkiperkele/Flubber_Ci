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
var obj = $('#profile-pic, #profile-name, #group-pic, #group-name, #addContentBox');
function stopPickingTextInContentBox(){$('#addContentBox').find('textarea').prop('disabled', true);}
function startPickingTextInContentBox(){$('#addContentBox').find('textarea').prop('disabled', false);}
var borderStyle = $(obj[2]).css('border');
obj.on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    stopPickingTextInContentBox();
    $(this).css('border', '2px dotted #0B85A1');
});
obj.on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
     stopPickingTextInContentBox();
     $(this).css('border', '2px dotted #0B85A1');
});
obj.on('drop', function (e) 
{
     e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
 
     //Sending the file to the Database
     handleFileUpload(files,obj, $(this).attr('id'));
     obj.css('border', borderStyle);
     startPickingTextInContentBox();
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
    startPickingTextInContentBox();
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
    if(elem === 'addContentBox')
        uploadURL = uploadURL + '/' + $('#'+elem).find('#profileId').val();
    else
        uploadURL = uploadURL + '/' + $('#'+elem).attr('index');
    var jqXHR=$.ajax({
            url: uploadURL,
            type: "POST",
            contentType:false,
            processData: false,
            cache: false,
            data: formData,
            success: function(data){
                data = eval (data);
                if(typeof data != 'undefined' && typeof data[0] != 'undefined' && 
                    ($('#'+elem).attr('index') === data[0] || elem === 'addContentBox')){
                    if(elem === 'profile-pic' || elem == 'group-pic')          //profilePicture or groupProfilePicture
                    {
                        $('#'+elem).attr('src', data[1])
                        $('#menu-profile').children().first().attr('src', data[1]);
                    }
                    else if(elem == 'profile-name' || elem == 'group-name')     //coverPicture or groupCoverPicture
                    {
                        $('#'+elem).css('background', 'url("' + data[1] + '") no-repeat center');
                    }
                    else if(elem == 'addContentBox')
                    {
                        if(data[1] !="")
                        {
                            var addContentBox = $('#addContentBox');
                            addContentBox.find('#updatedStatus').val(data[1]);
                            if(data[1].match(/mp4$/) == "mp4")
                                addContentBox.find('#contentType').val('video');
                            else
                                addContentBox.find('#contentType').val('image');
                            addContentBox.find('button').click();
                        }
                    }
                }

            }
    }); 
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
        if(!iter.next())
            break;
        iter = iter.next();
        iter.css("border-top", "2px solid #2ecc71").css("border-color", "none");
        if(!iter.next())
            break;
        iter = iter.next();
        iter.css("border-top", "2px solid #3498db").css("border-color", "none");
        if(!iter.next())
            break;
        iter = iter.next();
        iter.css("border-top", "2px solid #1abc9c").css("border-color", "none");
        if(!iter.next())
            break;
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
//Coloring the top borders of the Description boxes:
$(document).ready(function(){
    $(".description").each(function(){
        $(this).children().first().css("border-top", "2px solid #FFCC00").css("border-color", "none");
        $(this).hide();
         });
    var delaytime = 50;
    for(var item = $(".description").first(); item.length > 0; item = item.next()){
        item.delay(delaytime).show(animateDown);
         if(delaytime < 100);
            delaytime += 50;
    }
    $(".description").first().show(animateDown);
});

//Coloring the top borders of the Message boxes:
$(document).ready(function(){
    $(".message").each(function(){
        $(this).children().first().css("border-top", "2px solid #6C2DC7").css("border-color", "none");
        $(this).hide();
         });
    var delaytime = 50;
    for(var item = $(".message").first(); item.length > 0; item = item.next()){
        item.delay(delaytime).show(animateDown);
         if(delaytime < 100);
            delaytime += 50;
    }
    $(".message").first().show(animateDown);
});

//Coloring the top borders of the Request boxes:
$(document).ready(function(){
    $(".request").each(function(){
        $(this).children().first().css("border-top", "2px solid #E67E22").css("border-color", "none");
        $(this).hide();
         });
    var delaytime = 50;
    for(var item = $(".request").first(); item.length > 0; item = item.next()){
        item.delay(delaytime).show(animateDown);
         if(delaytime < 100);
            delaytime += 50;
    }
    $(".request").first().show(animateDown);
});

//Code to add privacy:
/*
    Usage:  Simply add a class called 'privacy' to each element that must have a privacy option:
*/
$('.privacy').each(function(){
    $(this).removeClass('hide').click(function (){
        if($(this).hasClass('fa-user')){
            $(this).removeClass('fa-user').addClass('fa-users').children().first().text(" Public");
            updatePrivacy($(this).parent().parent().attr('id'), "public");
        }else{
            $(this).removeClass('fa-users').addClass('fa-user').children().first().text(" Private");
            updatePrivacy($(this).parent().parent().attr('id'), "private")
        }
     });
});

function updatePrivacy(postId, privacy){
    $.ajax({
            type: "post",
            url: baseURL + "index.php/profile/updatePostPrivacy/",
            data: "postId="+postId+"&privacy="+privacy,
        });
}

 //Code to make things editable:
 /*
    Usage:  1.  Add a class "editable" at the element where you want the button to show
            2.  Add a class "editText" to the element which you need to be editable. If necessary 
                cover it in a div element with the above mentioned class.
            3.  Make sure editable and editText are in elements that have a common parent! 
 */


var toEdit = $('.comment-editable');
toEdit.each(function(){
    var postId = $(this).parent().parent().parent().find('.panel-title').attr('id');
    var profileId = $(this).parent().find('.profilePic').attr('id');
    var commentId = $(this).attr('id');
    $(this).parent().find('.comment-del-btn').click(function()      //delete function
    {
        var me = $(this);
        $.ajax(
        {
            type: "delete",
            url: baseURL + "index.php/profile/deleteComment/"+postId+"/"+profileId+"/"+commentId,
            success: function(data)
            {
                me.parent().parent().hide(animateUp);
            }  
        });
    })
});


var toEdit = $('.editable');
toEdit.each(function(){
    var editContent = $(this).parent().find('.editText');
    var postId = $(this).parent().find('.panel-title').attr('id');
    var editbox = $(this).parent().find('.editbar-input');
    var profileId = $(this).parent().find('.profilePic').attr('id');
    $(this).parent().find('.editbar-del-btn').click(function()      //delete function
    {
        var me = $(this);
        $.ajax(
        {
            type: "post",
            url: baseURL + "index.php/profile/deletePost/"+postId,
            data: "profileId="+profileId,
            success: function(data)
            {
                me.parent().parent().hide(animateRight);
            }  
        });
    })
    $(this).parent().find('.editbar-btn').click(function()          //edit function
    {
    if(editContent.hasClass('hide'))
    {
      if(editbox.val() === "")
      {
        editbox.addClass('hide');
      } 
      else 
      {
        editContent.text(editbox.val());
        $.ajax(
        {
            type: "post",
            url: baseURL + "index.php/profile/updatePost/",
            data: "id="+postId
                    +"&profileId="+profileId
                    +"&updatedPost="+editbox.val(),
        });
        editbox.addClass('hide');
      }
      editContent.removeClass('hide');
    } 
    else 
    {
      var content = editContent.text();
      editContent.parent().prepend(editbox.removeClass('hide')
                 .attr('placeholder', content));
      editContent.addClass('hide');
    }
  })
});

var toGroupEdit = $('.groupeditable');
toGroupEdit.each(function(){
	var groupId = $(this).attr('id');
    var editContent = $(this).parent().find('.editText');
    var postId = $(this).parent().find('.panel-title').attr('id');
    var editbox = $(this).parent().find('.editbar-input');
    $(this).parent().find('.editbar-del-btn').click(function()      //delete function
    {
		var me = $(this);
        $.ajax(
        {
            type: "post",
            url: baseURL + "index.php/groups/deleteGroupPost/"+postId,
            data: "groupId="+groupId,
            success: function(data)
            {
                me.parent().parent().hide(animateLeft);
            }
        });
    })
    $(this).parent().find('.editbar-btn').click(function()          //edit function
    {
    if(editContent.hasClass('hide'))
    {
      if(editbox.val() === "")
      {
        editbox.addClass('hide');
      } 
      else 
      {
        editContent.text(editbox.val());
        $.ajax(
        {
            type: "post",
            url: baseURL + "index.php/groups/updateGroupPost/",
            data: "id="+postId
                    +"&groupId="+groupId
					+"&updatedPost="+editbox.val(),
        });
        editbox.addClass('hide');
      }
      editContent.removeClass('hide');
    } 
    else 
    {
      var content = editContent.text();
      editContent.parent().prepend(editbox.removeClass('hide')
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

$('.groupEdit').bind('click', function() {
    $(this).attr('contentEditable', true);
}).blur(function() {
    $(this).attr('contentEditable', false);
    var changedInfo = $(this).text();
    var field = $(this).attr('id');
	var groupId = $(this).parent().attr('id');
    $.ajax({
        type: "post",
        url: baseURL + "index.php/groups/updateGroupInfo/",
        data: "field="+field+"&changedInfo="+changedInfo+"&groupId="+groupId,
        });

});
$(document).ready(function(){
    var addInterestBox = $('.addInterest');
    addInterestBox.hide();
    addInterestBox.each(function(){
        $(this).parent().parent().find('.add-interests-btn').click(function(){
            var icon = $(this).children().first();
            if(icon.hasClass('glyphicon-chevron-down')){
                icon.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                $(this).parent().parent().find('.addInterest').show(animateUp);
            } else {
                icon.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                $(this).parent().parent().find('.addInterest').hide(animateDown);
            }
        });
    });
});