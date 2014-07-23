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
		$(this).children().removeClass('glyphicon-heart');
		$(this).children().addClass('glyphicon-heart-empty');
	}
	else if($(this).children().hasClass('glyphicon-heart-empty'))
	{
		$(this).children().removeClass('glyphicon-heart-empty');
		$(this).children().addClass('glyphicon-heart');
	}
});

//Carousel functionality in friends page
$(document).ready(function(){
	$('.carousel').carousel({
		interval: 2000
	});
});

//jQuery based functionality to add jumbotron's children to the menubar
$(document).ready(function(){
            var name = $("#profile-name").children().clone().addClass("nav navbar-nav");
            var pic =  $("#profile-pic").clone().removeClass("pull-right img-responsive").addClass("nav navbar-nav img-circle")
                        .css("width", 50).css("height", 50).css("margin-right", 10);
            if(name.length == 0){
                name = $("#group-name").children().clone().addClass("nav navbar-nav").css("margin-top", 5);
                pic = $("#group-pic").clone().removeClass("pull-right img-responsive").addClass("nav navbar-nav img-circle")
                        .css("width", 50).css("height", 50).css("margin-right", 10);
            }
            var moreName = name.children().clone();
            name.children().remove();
            name.attr("data-toggle", "tooltip").attr("data-placement","bottom").attr("title", moreName.text())
            $("#menu-profile").append(pic);
            $("#menu-profile").append(name);
            $("#menu-profile").hide();
});

$(window).scroll(function() {
    if ($(".navbar").offset().top >= 100){
        if($("#menu-profile").is(":visible") == false){
            $("#menu-profile").show(animateUp);
        }
    } else if ($("#menu-profile").is(":visible") == true){
            $("#menu-profile").hide(animateUp);
    }
});

//jQuery Drag'n drop feature for uploading images
//1. Handling the drag'n drop
var obj = $('#profile-pic');
$('#profile-pic').on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '2px solid #0B85A1');
});
$('#profile-pic').on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
});
$('#profile-pic').on('drop', function (e) 
{
 
     $(this).css('border', '2px dotted #0B85A1');
     e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
 
     //Sending the image to the Database
     handleFileUpload(files,obj);
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
  obj.css('border', '2px dotted #0B85A1');
});
$(document).on('drop', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});

//3. Read the image dropped on the profile section
function handleFileUpload(files,obj)
{
   for (var i = 0; i < files.length; i++) 
   {
        var fd = new FormData();
        fd.append('file', files[i]);
 
        //var status = new createStatusbar(obj); //Using this we can set progress.
        //status.setFileNameSize(files[i].name,files[i].size);
        sendFileToServer(fd/*,status*/);
 		$('#profile-pic').attr('src', "userimgs/" + files.item(0).name);
   }
}
//4. jQuery AJAX API for actual uploading to the database (currently going to the server as a file):
function sendFileToServer(formData/*,status*/)
{
    var uploadURL ="upload/"; //Upload URL
    var extraData ={}; //Extra Data.
    var jqXHR=$.ajax({
            xhr: function() {
            var xhrobj = $.ajaxSettings.xhr();
            /*if (xhrobj.upload) {
                    xhrobj.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //Set progress
                        status.setProgress(percent);
                    }, false);
                }*/
            return xhrobj;
        },
        url: uploadURL,
        type: "POST",
        contentType:false,
        processData: false,
        cache: false,
        data: formData/*,
        success: function(data){
            status.setProgress(100);
 
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
        iter.css("border-top", "2px solid #1abc9c").css("border-color", "none");
        iter = iter.next();
        iter.css("border-top", "2px solid #2ecc71").css("border-color", "none");
        iter = iter.next();
        iter.css("border-top", "2px solid #3498db").css("border-color", "none");
        iter = iter.next();
        iter.css("border-top", "2px solid #e74c3c").css("border-color", "none");
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