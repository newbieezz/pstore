@extends('front.layout.layout')
@section('content')
<div class="page">
        <div class="sidebar">
            <h2 class="sidebar__title">Filters</h2>
        
            <div class="sidebar__category">
            <div class="sidebar__heading">Type <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up">
                <polyline points="18 15 12 9 6 15"></polyline>
                </svg></div>
            <div class="sidebar__options">
                <label class="check">
                <input type="checkbox" class="check__input">
                <span class="check__checkbox">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6.5L9 17.5L4 12.5" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <p class="check__text">Gift</p>
                </label>
                <label class="check">
                <input type="checkbox" class="check__input">
                <span class="check__checkbox">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6.5L9 17.5L4 12.5" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <p class="check__text">Indoor</p>
                </label>
                <label class="check">
                <input type="checkbox" class="check__input">
                <span class="check__checkbox">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6.5L9 17.5L4 12.5" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <p class="check__text">Outdoor</p>
                </label>
            </div>
            </div>
        
            <div class="sidebar__category">
            <div class="sidebar__heading">Size (3) <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up">
                <polyline points="18 15 12 9 6 15"></polyline>
                </svg></div>
            <div class="sidebar__options">
                <label class="check">
                <input type="checkbox" class="check__input" checked>
                <span class="check__checkbox">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6.5L9 17.5L4 12.5" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <p class="check__text">Small</p>
                </label>
                <label class="check">
                <input type="checkbox" class="check__input" checked>
                <span class="check__checkbox">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6.5L9 17.5L4 12.5" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <p class="check__text">Medium</p>
                </label>
                <label class="check">
                <input type="checkbox" class="check__input" checked>
                <span class="check__checkbox">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6.5L9 17.5L4 12.5" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <p class="check__text">Large</p>
                </label>
            </div>
            </div>
        
            <div class="sidebar__category">
            <div class="sidebar__heading">Color <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up">
                <polyline points="18 15 12 9 6 15"></polyline>
                </svg></div>
            <div class="sidebar__options">
                <div class="color" style="--hue: 0deg"></div>
                <div class="color" style="--hue: 30deg"></div>
                <div class="color" style="--hue: 60deg"></div>
                <div class="color" style="--hue: 90deg"></div>
                <div class="color" style="--hue: 120deg"></div>
                <div class="color" style="--hue: 150deg"></div>
                <div class="color" style="--hue: 180deg"></div>
                <div class="color" style="--hue: 210deg"></div>
                <div class="color" style="--hue: 240deg"></div>
                <div class="color" style="--hue: 270deg"></div>
                <div class="color" style="--hue: 300deg"></div>
                <div class="color" style="--hue: 330deg"></div>
            </div>
            </div>
        </div>
        
        
    <!-- MAIN -->
    <!-- ------------------------------------------------- -->
    <div class="main">
  
        <!-- PLANTS -->
        <!-- ------------------------------------------------- -->
        <h2 class="main__title">Product Filter</h2>
    
        <!-- FILTERS -->
        <!-- ------------------------------------------------- -->
  
          <!-- Toolbar Sorter 1  --> <p>Showing: {{ count($categoryProducts) }}</p>
          <form name="sortProducts" id="sortProducts" >
            <input type="hidden" name="url" id="url" value="{{ $url }}">
            <div class="toolbar-sorter">
                <div class="select-box-wrapper">
                    <label class="sr-only" for="sort-by">Sort By</label>
                    <select name="sort" id="sort" class="select-box" >
                        {{-- <option selected="selected" value="">Sort By: Best Selling</option> --}}
                        <option selected="">Select Sort</option>
                        <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']=="product_latest") selected="" @endif>
                            Sort By: Latest</option>
                        <option value="price_lowest" @if(isset($_GET['sort']) && $_GET['sort']=="price_lowest") selected="" @endif>
                            Sort By: Lowest Price</option>
                        <option value="price_highest" @if(isset($_GET['sort']) && $_GET['sort']=="price_highest") selected="" @endif>
                            Sort By: Highest Price</option>
                        <option value="name_a_z" @if(isset($_GET['sort']) && $_GET['sort']=="name_a_z") selected="" @endif>
                            Sort By: Name A - Z</option>
                        <option value="name_z_a" @if(isset($_GET['sort']) && $_GET['sort']=="name_z_a") selected="" @endif>
                            Sort By: Name Z - A</option>
                        {{-- <option value="">Sort By: Best Rating</option> --}}
                    </select>
                </div>
            </div>
          </form>
          
    
        <div class="filter_products">
            @include('front.products.product_listing')
        </div>
        <!-- PAGINATION -->
        @if(isset($_GET['sort']))
        <div> {{ $categoryProducts->appends(['sort'=>$_GET['sort']])->links() }}</div> <div>&nbsp;</div> 
    @else
        <div> {{ $categoryProducts->links() }}</div> <div>&nbsp;</div> 
    @endif
    <div class="desc"> {{ $categoryDetails['categoryDetails']['description'] }}</div>
    
    </div>

</div>
@endsection
