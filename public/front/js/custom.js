$(document).ready(function(){
   
    //sort product
    $("#sort").on("change",function(){
        var sort = $("#sort").val();
        var url = $("#url").val();
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:'Post',
            data:{sort:sort,url:url},
            success:function(data){
                $('.filter_products').html(data);
            },error:function(){
                alert("Error");
            }
        });
    });

    $("#getPrice").change(function(){
        var size = $(this).val();
        var product_id = $(this).attr("product-id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-product-price',
            data:{size:size,product_id:product_id},
            type:'post',
            success:function(resp){
                //alert(resp['final_price']);
                if(resp['discount']>0){
                    $(".getAttributePrice").html("<div class='price'><h4>₱ "+resp['final_price']+"</h4></div><div class='original-price'><span>Original Price:</span><span>₱ "+resp['product_price']+"</span></div>");
                } else {
                    $(".getAttributePrice").html("<div class='price'><h4>₱ "+resp['final_price']+"</h4></div>");
                }
            }, error:function(){
                alert("Error");
            }
        });
    });

    //update cart items qty
    $(document).on('click','.updateCartItem',function(){
        if($(this).hasClass('plus-a')){//will tell if the user click or not
            //get the qty
            var quantity = $(this).data('qty');
            //if clicked qty increase by 1
            new_qty = parseInt(quantity) + 1 ;
        }
        if($(this).hasClass('minus-a')){//will tell if the user click or not
            //get the qty
            var quantity = $(this).data('qty');
            //check qty is atleast 1
            if(quantity <= 1) {
                alert("Item quantity must be 1 or greater!");
                return false;
            }
            //if clicked qty subtract by 1
            new_qty = parseInt(quantity) - 1 ;
        }
        var cartid = $(this).data('cartid'); //get the cart id
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{cartid:cartid,qty:new_qty},
            url:'/cart/update',
            type:'post',
            success:function(resp){
                if(resp.status==false){
                    alert(resp.message);
                }
                $("#appendCartItems").html(resp.view);
            },error:function(){
                alert("Error");
            }

        })
    });

    //delete cart item
    $(document).on('click','.deleteCartItem',function(){
        var cartid = $(this).data('cartid');
        var result = confirm("Are you sure to delete this Cart Item?");
        if(result){ //if user clicks yes
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{cartid:cartid},
                url:'/cart/delete',
                type:'post',
                success:function(resp){
                    $("#appendCartItems").html(resp.view);
                },error:function(){
                    alert("Error");
                }
            })
        }
        
    });

    //jquery function for register form validation
    $("#registerForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        $(".loader").show(); //show the loader 
        $.ajax({
            
            url:"/user/register",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                        //display all the errors in array used eachloop
                        $.each(resp.errors,function(i,error){ //loop the error in an array
                            $("#register-"+i).attr('style','color:red');
                            $("#register-"+i).html(error);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#register-"+i).css({'display':'none'});
                        },3000);
                    });
                } else if(resp.type=="success"){ //if success in validation
                    $(".loader").hide();
                    $("#register-success").attr('styel','color:green');
                    $("#register-success").html(resp.message);
                } 
            }, error:function(){
                alert("Error");
            }
        })
        
    });

    //jquery function for login form validation
    $("#loginForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        $.ajax({
            
            url:"/user/login",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                    //display all the errors in array used eachloop
                    $.each(resp.errors,function(i,error){ //loop the error in an array
                        $("#login-"+i).attr('style','color:red');
                        $("#login-"+i).html(error);
                    setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                        $("#login-"+i).css({'display':'none'});
                    },3000);
                 });
                } else if(resp.type=="success"){ //if success in validation move/redirerct to guard page
                    window.location.href = resp.url;
                } else if(resp.type=="incorrect"){ 
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                }  else if(resp.type=="inactive"){ 
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                }
            }, error:function(){
                alert("Error");
            }
        })
        
    });

    //jquery function for forgotpassword form validation
    $("#forgotpassForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        // $(".loader").show(); //show the loader 
        $.ajax({
            
            url:"/user/forgot-password",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                        //display all the errors in array used eachloop
                        $.each(resp.errors,function(i,error){ //loop the error in an array
                            $("#forgot-"+i).attr('style','color:red');
                            $("#forgot-"+i).html(error);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#forgot-"+i).css({'display':'none'});
                        },3000);
                    });
                } else if(resp.type=="success"){ //if success in validation
                    $(".loader").hide();
                    $("#forgot-success").attr('styel','color:green');
                    $("#forgot-success").html(resp.message);
                } 
            }, error:function(){
                alert("Error");
            }
        })
        
    });

    //jquery function for user Account form validation
    $("#accountForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        $(".loader").show(); //show the loader 
        $.ajax({
            url:"/user/account",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                    $(".loader").hide();
                        //display all the errors in array used eachloop
                        $.each(resp.errors,function(i,error){ //loop the error in an array
                            $("#account-"+i).attr('style','color:red');
                            $("#account-"+i).html(error);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#account-"+i).css({'display':'none'});
                        },3000);
                    });
                } else if(resp.type=="success"){ //if success in validation
                    $(".loader").hide();
                    $("#account-success").attr('styel','color:green');
                    $("#account-success").html(resp.message);
                    setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                        $("#account-success").css({'display':'none'});
                    },3000);
                } 
            }, error:function(){
                alert("Error");
            }
        })
        
    });

    //Update user password validation
    $("#passwordForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        $(".loader").show(); //show the loader 
        $.ajax({
            url:"/user/update-password",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                    $(".loader").hide();
                        //display all the errors in array used eachloop
                        $.each(resp.errors,function(i,error){ //loop the error in an array
                            $("#password-"+i).attr('style','color:red');
                            $("#password-"+i).html(error);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#password-"+i).css({'display':'none'});
                        },3000);
                    });
                } else if(resp.type=="incorrect"){ //validation fails
                    $(".loader").hide();
                        //display all the errors in array used eachloop
                            $("#password-error").attr('style','color:red');
                            $("#password-error").html(resp.message);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#password-error").css({'display':'none'});
                        },3000);
                }else if(resp.type=="success"){ //if success in validation
                    $(".loader").hide();
                    $("#password-success").attr('styel','color:green');
                    $("#password-success").html(resp.message);
                    setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                        $("#password-success").css({'display':'none'});
                    },3000);
                } 
            }, error:function(){
                alert("Error");
            }
        })
        
    }); 
});

//required function to operate check box on the filter 
function get_filter(class_name){
    var filter = [];
    //check whenever the class name getchecked
    $('.'+class_name+':checked').each(function(){
        //push is to push the elements to the array
        filter.push($(this).val());
    });

    return filter;
}