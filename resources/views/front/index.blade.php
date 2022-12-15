<?php use App\Models\Product;  ?>
@extends('front.layout.layout')
@section('content')
  
      <!-- Hero Area Start -->
      <div id="hero-area" class="hero-area-bg">
        <div class="container">      
          <div class="row">
            <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
              <div class="contents">
                <h2 class="head-title">Groceries are just one tap away!</h2>
                <p> Lorem ipsum dolor sit amet habeo aliquam ei donec antiopam audire in mauris imperdiet uonsetetur te mea insolens arcu his officiis eos facilisis per ei corrumpit facilisi graeci antiopam et duo vitae penatibus aenean assentior nullam consequat.</p>
                <div class="header-button">
                  <a rel="nofollow" href="" class="btn btn-common">Shop Now</a>
                  <a href="" class="btn btn-border video-popup">Register</a>
                </div>
              </div>
            </div>  
          </div> 
        </div> 
      </div>
      <!-- Hero Area End -->
    <!-- Latest Product Start -->
    <section id="services" class="section-padding">
      <div class="container">
        <div class="section-header text-center">
          <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Latest Products</h2>
          <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
        </div>
        <div class="row" >
            <!-- ForeachLoop of Array for the latest products to display -->
            @foreach($newProducts as $product)
            <!-- Fetching the Image to be displayed -->
            <?php $product_image_path ='front/images/product_images/small/'.$product['product_image']; ?>
            <div class="col" data-item="4">
                <!-- Latest item -->
                <div class="services-item wow fadeInRight" data-wow-delay="0.3s">
                <div class="icon">
                    <a  href="{{ url('product/'.$product['id']) }}">
                        <!-- Check if the file exist or not, if not then show dummy image -->
                        @if(!empty($product['product_image']) && file_exists($product_image_path))
                            <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                        @else
                            <img class="img-fluid" src="{{ asset('front/images/product_images/small/noimage.png') }}" alt="NoImage">
                        @endif
                    </a>
                </div>
                <div class="services-content">
                    <h6><a href="{{ url('product/'.$product['product_code']) }}">{{ $product['product_code'] }}</a></h6>
                    <h3><a href="{{ url('product/'.$product['product_name']) }}">{{ $product['product_name'] }}</a></h3>
                </div>
                    <!-- Call the dunction created inside the products model for the discounted price -->
                    <?php $getDiscountedPrice = Product::getDiscountedPrice($product['id']);  ?>
                    @if ($getDiscountedPrice > 0)
                        <div class="price-template">
                            <div class="item-new-price">
                               DP: ₱ {{ $getDiscountedPrice }} <br>
                               Discount: {{$product['product_discount']}} %
                            </div>
                            {{-- <div class="item-old-price">
                                ₱ {{ $product['product_price'] }}
                            </div> --}}
                        </div>
                    @else
                        <div class="price-template">
                            <div class="item-new-price">
                                ₱ {{ $product['product_price'] }}
                            </div>
                        </div>
                    @endif
                    </div>
              </div>@endforeach
          </div>
      </div>
    </section>
    <!--Latest Products End -->

    <!-- Best Selling Products Start -->
    <section id="services" class="section-padding">
      <div class="container">
        <div class="section-header text-center">
          <h2 class="section-title wow fadeInDown" data-wow-delay="0.6s">Discounted Products</h2>
          <div class="shape wow fadeInDown" data-wow-delay="0.6s"></div>
        </div>
        <div class="row" >
            <!-- ForeachLoop of Array for the latest products to display -->
            @foreach($discountedProds as $product)
            <!-- Fetching the Image to be displayed -->
            <?php $product_image_path ='front/images/product_images/small/'.$product['product_image']; ?>
            <div class="col" data-item="4">
                <!-- Latest item -->
                <div class="services-item wow fadeInRight" data-wow-delay="0.6s">
                <div class="icon">
                    <a  href="{{ url('product/'.$product['id']) }}">
                        <!-- Check if the file exist or not, if not then show dummy image -->
                        @if(!empty($product['product_image']) && file_exists($product_image_path))
                            <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                        @else
                            <img class="img-fluid" src="{{ asset('front/images/product_images/small/noimage.png') }}" alt="NoImage">
                        @endif
                    </a>
                </div>
                <div class="services-content">
                    <h6><a href="{{ url('product/'.$product['product_code']) }}">{{ $product['product_code'] }}</a></h6>
                    <h3><a href="{{ url('product/'.$product['product_name']) }}">{{ $product['product_name'] }}</a></h3>
                </div>
                    <!-- Call the dunction created inside the products model for the discounted price -->
                    <?php $getDiscountedPrice = Product::getDiscountedPrice($product['id']);  ?>
                    @if ($getDiscountedPrice > 0)
                        <div class="price-template">
                            <div class="item-new-price">
                               DP: ₱ {{ $getDiscountedPrice }} <br>
                               Discount: {{$product['product_discount']}} %
                            </div>
                            {{-- <div class="item-old-price">
                                ₱ {{ $product['product_price'] }}
                            </div> --}}
                        </div>
                    @else
                        <div class="price-template">
                            <div class="item-new-price">
                                ₱ {{ $product['product_price'] }}
                            </div>
                        </div>
                    @endif
                    </div>
              </div>@endforeach
          </div>
      </div>
    </section>
    <!--Best Selling Products  End -->

    <!-- stores Section End -->

    <!-- Call To Action Section Start -->
    {{-- <section id="cta" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-xs-12 wow fadeInLeft" data-wow-delay="0.3s">           
            <div class="cta-text">
              <h4>Get 30 days free trial</h4>
              <p>Praesent imperdiet, tellus et euismod euismod, risus lorem euismod erat, at finibus neque odio quis metus. Donec vulputate arcu quam. </p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-xs-12 text-right wow fadeInRight" data-wow-delay="0.3s">
            </br><a href="#" class="btn btn-common">Register Now</a>
          </div>
        </div>
      </div>
    </section> --}}
    <!-- Call To Action Section Start -->

    <!-- Contact Section Start -->
    {{-- <section id="contact" class="section-padding bg-gray">    
      <div class="container">
        <div class="section-header text-center">          
          <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Countact Us</h2>
          <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
        </div>
        <div class="row contact-form-area wow fadeInUp" data-wow-delay="0.3s">   
          <div class="col-lg-7 col-md-12 col-sm-12">
    <!-- Call To Action Section Start -->
    <section id="cta" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-xs-12 wow fadeInLeft" data-wow-delay="0.3s">           
            <div class="cta-text">
              <h4>You're Using Free Lite Version</h4>
              <h5>Please purchase full version of the template to get all features and facilities</h5>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-xs-12 text-right wow fadeInRight" data-wow-delay="0.3s">
            </br><a rel="nofollow" href="https://rebrand.ly/fusion-ud" class="btn btn-common">Purchase Now</a>
          </div>
        </div>
      </div>
    </section>  
    <!-- Call To Action Section Start -->
          </div>
          <div class="col-lg-5 col-md-12 col-xs-12">
            <div class="map">
              <object style="border:0; height: 280px; width: 100%;" data="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d34015.943594576835!2d-106.43242624069771!3d31.677719472407432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86e75d90e99d597b%3A0x6cd3eb9a9fcd23f1!2sCourtyard+by+Marriott+Ciudad+Juarez!5e0!3m2!1sen!2sbd!4v1533791187584"></object>
            </div>
          </div>
        </div>
      </div> 
    </section> --}}
    <!-- Contact Section End -->

    <!-- Go to Top Link -->
    <a href="#" class="back-to-top">
    	<i class="lni-arrow-up"></i>
    </a>

  @endsection

