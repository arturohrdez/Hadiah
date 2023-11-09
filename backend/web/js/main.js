$(function(){
	//console.log("entra");
	
	/*** Action Button Add Form ***/
	if(("#btnAddForm").length > 0){
		$("#btnAddForm").on("click",function(e){
			$("#divEditForm").hide(function(e){});
			var url = $(this).attr('value');
			$.ajax({
	            'type'    :"GET",
	            'url'     : url,
	            'dataType': "html",
	            beforeSend: function(data){
	                $(".loading").html('<div class="spinner-border text-primary m-5" role="status"><span class="sr-only">Loading...</span></div>');
	            	$(".loading").fadeIn();
	            },
	            success:  function (data){
	                $("#btnAddForm").hide();
	                $("#divEditForm").html(data);
	                $("#divEditForm").slideDown();
	                $(".loading").html("");
	                $(".loading").fadeOut();
	                $('html, body').stop().animate({scrollTop:0},600,'swing',function(){});
	            }
	        });
		});
	}//end if

	/*** Action Button Edit Form ***/
	if((".btnUpdateForm").length > 0){
		$(".btnUpdateForm").on("click",function(e){
			$("#divEditForm").hide(function(e){});
			var url = $(this).attr('value');
			$.ajax({
	            'type'    :"GET",
	            'url'     : url,
	            'dataType': "html",
	            beforeSend: function(data){
	                $(".loading").html('<div class="spinner-border text-primary m-5" role="status"><span class="sr-only">Loading...</span></div>');
	            	$(".loading").fadeIn();
	            },
	            success:  function (data){
	                $("#divEditForm").html(data);
	                $("#divEditForm").slideDown();
	                $(".loading").html("");
	                $(".loading").fadeOut();
	                $('html, body').stop().animate({scrollTop:0},600,'swing',function(){});
	            }
	        });
		});
	}

	/*** Action Button View Form ***/
	if((".btnViewForm").length > 0){
		$(".btnViewForm").on("click",function(e){
			e.preventDefault();
			
			$("#divEditForm").hide(function(e){});
			var url = $(this).attr('value');
			$.ajax({
	            'type'    :"GET",
	            'url'     : url,
	            'dataType': "html",
	            beforeSend: function(data){
	                $(".loading").html('<div class="spinner-border text-primary m-5" role="status"><span class="sr-only">Loading...</span></div>');
	            	$(".loading").fadeIn();
	            },
	            success:  function (data){
	                $("#divEditForm").html(data);
	                $("#divEditForm").slideDown();
	                $(".loading").html("");
	                $(".loading").fadeOut();
	                $('html, body').stop().animate({scrollTop:0},600,'swing',function(){});
	            }
	        });
		});
	}

	
	//Custom Paginator GridView :: Widget
	if($(".pagination").length > 0){
		$(".pagination").addClass('float-right');
		$(".pagination > li").addClass('page-item');
		$(".pagination > li > a").addClass('page-link');
		$(".pagination > li > span").addClass('page-link');
	}//end if

});

/*** Function Button Close Form ***/
function closeForm(nameForm){
	$("#"+nameForm)[0].reset();
	$("#divEditForm").slideUp('slow');
	$("#btnAddForm").show(function(e){});
}


