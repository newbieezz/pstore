$(document).ready(function(){

    //removing the active class on nav-item in sidebar
    //$(".nav-item").removeClass("active");
    //$(".nav-link").removeClass("active");

    // call dataTables class
    $('#sections').DataTable();
    $('#categories').DataTable();
    $('#brands').DataTable();
    $('#products').DataTable();
    $('#banners').DataTable();
    $('#filters').DataTable();
    // Check if the Admin Password is correct or not
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        //check the value
       // alert(current_password);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            //the check-current-password will be routed in web.php
            url:'/admin/check-admin-password',
            data:{current_password:current_password},
            success:function(resp){
                if(resp=="false"){
                    $('#check_password').html("<font color='red'>Current Password is Incorrect!</font>");
                }else if(resp=="true"){
                    $('#check_password').html("<font color='green'>Current Password is Correct!</font>");
                }
            }, error:function(){
                     alert('Error');
                }
        });

    })

    //update admin status
    $(document).on("click",".updateAdminStatus",function(){
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-admin-status',
            data: {status:status,admin_id:admin_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#admin-"+admin_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#admin-"+admin_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //update section status
    $(document).on("click",".updateSectionStatus",function(){
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-section-status',
            data: {status:status,section_id:section_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#section-"+section_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#section-"+section_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //update product status
    $(document).on("click",".updateProductStatus",function(){
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-product-status',
            data: {status:status,product_id:product_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#product-"+product_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#product-"+product_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });
    // confirm deletion alert
    $(document).on("click",".confirmDelete",function(){
        var module =  $(this).attr('module');
        var moduleid = $(this).attr('moduleid'); 
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              window.location = "/admin/delete-" +module+"/"+moduleid;
            }
          })
    });

    //update category status
    $(document).on("click",".updateCategoryStatus",function(){
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-category-status',
            data: {status:status,category_id:category_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#category-"+category_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#category-"+category_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    // Append categories Level, show all the categories under the same selection
   // Append Categories level
	$("#section_id").change(function(){
		var section_id = $(this).val();
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'get',
			url:'/admin/append-categories-level',
			data:{section_id:section_id},
			success:function(resp){
				$("#appendCategoriesLevel").html(resp);
			},error:function(){
				alert("Error");
			}
		})
	});

    //update brand status
    $(document).on("click",".updateBrandStatus",function(){
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-brand-status',
            data: {status:status,brand_id:brand_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#brand-"+brand_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#brand-"+brand_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });
    
    //for add-edit Products attributes
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div></div><div style="height:10px;"></div><input type="text" name="size[]"  placeholder="Size" style="width:120px;"/>&nbsp;<input type="text" name="weight[]"  placeholder="Weight" style="width:120px;"/>&nbsp;<input type="text" name="sku[]"  placeholder="SKU-Code" style="width:120px;"/>&nbsp;<input type="text" name="price[]"  placeholder="Price" style="width:120px;"/>&nbsp;<input type="text" name="stock[]"  placeholder="Stock" style="width:120px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    //update Attribute Status
    $(document).on("click",".updateAttributeStatus",function(){
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-attribute-status',
            data: {status:status,attribute_id:attribute_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#attribute-"+attribute_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#attribute-"+attribute_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //update Image Status
    $(document).on("click",".updateImageStatus",function(){
        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-image-status',
            data: {status:status,image_id:image_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#image-"+image_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#image-"+image_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //update banner status
    $(document).on("click",".updateBannerStatus",function(){
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-banner-status',
            data: {status:status,banner_id:banner_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#banner-"+banner_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#banner-"+banner_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //update filter status
    $(document).on("click",".updateFilterStatus",function(){
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-filter-status',
            data: {status:status,filter_id:filter_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#filter-"+filter_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#filter-"+filter_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //update filter value status
    $(document).on("click",".updateFilterValueStatus",function(){``
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/update-filter-value-status',
            data: {status:status,filter_id:filter_id},
            success:function(resp){
                //alert(resp);
                if(resp['status']==0){ //update the value in the html
                    $("#filter-"+filter_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle-outline' status='Inactive'> </i> ");
                } else if(resp['status']==1){ //update the value in the html
                    $("#filter-"+filter_id).html("<i style='font-size:30px;' class='mdi mdi-check-circle' status='Active'> </i> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    });
    
    //show filters on selection of category
    //if the user select the category we will select the id 
    $("#category_id").on('change',function(){
        var category_id = $(this).val();
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'category-filters',
            data:{category_id:category_id},
            success:function(resp){
                $(".loadFilters").html(resp.view);
            }
        });
    });
});