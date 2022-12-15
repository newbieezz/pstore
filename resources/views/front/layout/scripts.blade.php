<?php 
    use App\Models\ProductsFilter; 
    $productFilters = ProductsFilter::productFilters();
    // dd($productFilters);
?>
<script>
$(document).ready(function(){
    //sort by filter
    $("#sort").on("change",function(){
        var size = get_filter('size');//get all the sizes
        var price = get_filter('price');
        var brands = get_filter('brands');
        var sort = $("#sort").val();
        var url = $("#url").val();
        @foreach($productFilters as $filters)
                //get the multiple value with the help of the function created (get_filter)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}'); //when calling the function it calls and gets the class_name value then check then push to array
        @endforeach
        //pass the ajax to the function
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:'Post',
            data:{
                    @foreach($productFilters as $filters)
                      {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    url:url,sort:sort,size:size,price:price,brands:brands},
            success:function(data){
                $('.filter_product').html(data);
            },error:function(){
                alert("Error");
            }
        });
    });

    //size filter
    $(".size").on("change",function(){
        //change if user select any option
        // this.form.submit();
        var size = get_filter('size');//get all the sizes
        var price = get_filter('price');
        var brands = get_filter('brands');
        var sort = $("#sort").val();
        var url = $("#url").val();
        @foreach($productFilters as $filters)
                //get the multiple value with the help of the function created (get_filter)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}'); //when calling the function it calls and gets the class_name value then check then push to array
        @endforeach
        //pass the ajax to the function
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:'Post',
            data:{
                    @foreach($productFilters as $filters)
                      {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    url:url,sort:sort,size:size,price:price,brands:brands},
            success:function(data){
                $('.filter_product').html(data);
            },error:function(){
                alert("Error");
            }
        });
    });
    //brand filter
    $(".brands").on("change",function(){
        //change if user select any option
        // this.form.submit();
        var size = get_filter('size');//get all the sizes
        var price = get_filter('price');
        var brands = get_filter('brands');
        var sort = $("#sort").val();
        var url = $("#url").val();
        @foreach($productFilters as $filters)
                //get the multiple value with the help of the function created (get_filter)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}'); //when calling the function it calls and gets the class_name value then check then push to array
        @endforeach
        //pass the ajax to the function
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:'Post',
            data:{
                    @foreach($productFilters as $filters)
                      {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    url:url,sort:sort,size:size,price:price,brands:brands},
            success:function(data){
                $('.filter_product').html(data);
            },error:function(){
                alert("Error");
            }
        });
    });
    //price filter
    $(".price").on("change",function(){
        //change if user select any option
        // this.form.submit();
        var size = get_filter('size');//get all the sizes
        var price = get_filter('price');
        var brands = get_filter('brands');
        var sort = $("#sort").val();
        var url = $("#url").val();
        @foreach($productFilters as $filters)
                //get the multiple value with the help of the function created (get_filter)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}'); //when calling the function it calls and gets the class_name value then check then push to array
        @endforeach
        //pass the ajax to the function
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:'Post',
            data:{
                    @foreach($productFilters as $filters)
                      {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    url:url,sort:sort,size:size,price:price,brands:brands},
            success:function(data){
                $('.filter_product').html(data);
            },error:function(){
                alert("Error");
            }
        });
    });


    //for the dynamic filters
    @foreach($productFilters as $filter) //will repeat for all the filter
        //jquery function onclick, whenever a class gets clicked then this executes
        $('.{{ $filter['filter_column'] }}').on('click',function(){
            var url = $("#url").val();
            var size = get_filter('size');//get all the sizes
            var price = get_filter('price');
            var brands = get_filter('brands');
            //get whatever the selectec option is checked
            var sort = $("#sort option:selected").val();
            @foreach($productFilters as $filters)
                //get the multiple value with the help of the function created (get_filter)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}'); //when calling the function it calls and gets the class_name value then check then push to array
            @endforeach

            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:url,
                method:'Post',
                data:{
                    @foreach($productFilters as $filters)
                      {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    url:url,sort:sort,size:size,price:price,brands:brands},
                    success:function(data){
                    $('.filter_product').html(data);
                },error:function(){
                    alert("Error");
                }
            });
        });
    @endforeach
});
</script>