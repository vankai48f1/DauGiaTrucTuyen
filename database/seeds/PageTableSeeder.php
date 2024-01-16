<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = '{"top_nav": "1", "side_nav": "1", "side_nav_fixed": "0", "hide_breadcrumb": "1", "navigation_type": "2", "top_nav_transparent": "0", "logo_inversed_top_nav": "0", "logo_inversed_side_nav": "0"}';

        $input = [
            [
                'slug' => 'home',
                'title' => 'Home',
                'body' => '<section class="cmb_section" data-cmb-wrapper="cmb_section" data-cmb-id="1" data-cmb-element-type="static-layout">
<div class="section-overlay"><div class="cmb_slider" data-cmb-wrapper="cmb_slider" data-cmb-id="2" data-cmb-element-type="static-layout">
        <div class="cm-slider transparent-direction" data-in-transition="zoomIn" data-out-transition="flipOutX" data-display-interval="3000" data-transition-interval="1000" data-pause-active="y">
            <div class="cm-slide-container">
                <div class="cm-slide cmb_slide background-size-cover" data-cmb-wrapper="cmb_slide" data-cmb-element-type="static-layout" data-cmb-id="7">
                    <div class="cm-slide-inner">
                    <div class="cmb-slide-element cmb_slide_element_image default-slide-element-position" data-cmb-wrapper="cmb_slide_element_image" data-cmb-id="8" data-cmb-element-type="static-layout" data-x="6.69" data-y="18.03" data-animation="fadeIn" data-animation-duration="500" data-animation-delay="10">
<img src="/public/uploads/media/_31c62a27-b2b3-4260-85a3-7fd426ba8060_.png" alt="slider img" class="w-100 cm-slide-element-core">
</div><div class="cmb-slide-element cmb_slide_element_text default-slide-element-position font-weight-bold" data-cmb-wrapper="cmb_slide_element_text" data-cmb-id="9" data-cmb-element-type="static-layout" data-x="6.69" data-y="38.97" data-animation="fadeInDown" data-animation-duration="450" data-animation-delay="400"><span class="cmb-single-line-editable-text cm-slide-element-core" data-slide-element-font-size="4" style="font-size:4vw;">Best Auction<br>Management System<br></span></div><div class="cmb-slide-element cmb_slide_element_button default-slide-element-position" data-cmb-wrapper="cmb_slide_element_button" data-cmb-id="10" data-cmb-element-type="static-layout" data-x="6.54" data-y="65.91" data-animation="fadeInDownBigLinear" data-animation-duration="750" data-animation-delay="297">
<a class="btn lf-btn-primary" href="#"><span class="cmb-single-line-editable-text cm-slide-element-core" data-slide-element-font-size="1.2" style="font-size:1.2vw;">Go To Auction</span></a>
</div></div>
                </div><div class="cm-slide cmb_slide background-size-cover" data-cmb-wrapper="cmb_slide" data-cmb-id="3" data-cmb-element-type="static-layout">
    <div class="cm-slide-inner">
    <div class="cmb-slide-element cmb_slide_element_image default-slide-element-position" data-cmb-wrapper="cmb_slide_element_image" data-cmb-id="4" data-cmb-element-type="static-layout" data-x="6.92" data-y="15.70" data-animation="fadeInUp" data-animation-duration="10" data-animation-delay="500">
<img src="/public/uploads/media/_31c62a27-b2b3-4260-85a3-7fd426ba8060_.png" alt="slider img" class="w-100 cm-slide-element-core">
</div><div class="cmb-slide-element cmb_slide_element_text default-slide-element-position font-weight-bold" data-cmb-wrapper="cmb_slide_element_text" data-cmb-id="5" data-cmb-element-type="static-layout" data-x="7.00" data-y="37.03" data-animation="fadeInUp" data-animation-duration="298" data-animation-delay="450"><span class="cmb-single-line-editable-text cm-slide-element-core" data-slide-element-font-size="4.1" style="font-size:4.1vw;">Best Auction<br>Management System<br></span></div><div class="cmb-slide-element cmb_slide_element_button default-slide-element-position" data-cmb-wrapper="cmb_slide_element_button" data-cmb-id="6" data-cmb-element-type="static-layout" data-x="7.00" data-y="69.21" data-animation="fadeInUpBigLinear" data-animation-duration="600" data-animation-delay="300">
<a class="btn lf-btn-primary" href="#"><span class="cmb-single-line-editable-text cm-slide-element-core" data-slide-element-font-size="1.2" style="font-size:1.2vw;">Go To Auction</span></a>
</div></div>
</div>
            </div>

            <div class="cm-slider-timeline">
                <div class="cm-timeline-inner"></div>
            </div>
            <div class="cm-slider-direction cm-slider-direction-left"><i class="fa fa-caret-left"></i></div>
            <div class="cm-slider-direction cm-slider-direction-right"><i class="fa fa-caret-right"></i></div>
        </div>
</div></div>
</section>
    <section class="cmb_section mt-5 mb-5" data-cmb-wrapper="cmb_section" data-cmb-id="11" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="12">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="13">
                    <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="14">

                    <div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="16" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Latest</span> <span class="cmb-single-line-editable-text">Auctions</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="/auctions" class="cmb-title-link"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div></div>
                </div>
            <div data-cmb-wrapper="cmb_auction" data-cmb-id="15" data-cmb-element-type="dynamic-layout" class="cmb_auction" data-cmb-dynamic-values="name:short_code_auction_list|column:3|item:6|type:latest"></div></div>
            </div>
        </section><section class="cmb_section mt-5 mb-5" data-cmb-wrapper="cmb_section" data-cmb-id="17" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="18">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="19">
                    <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="20">

                    <div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="21" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">How It</span> <span class="cmb-single-line-editable-text">Works</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="#" class="cmb-title-link d-none"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div></div>
                </div>
            <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-id="22" data-cmb-element-type="static-layout">
                    <div class="cmb_column col-lg-3 col-sm-6" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="23">
                        <a class="cmb_img" data-cmb-wrapper="cmb_img" data-cmb-id="31" data-cmb-element-type="static-layout"><img class="img-fluid" src="/public/uploads/media/_792ccd8e-3bb8-4a45-a499-2a79a08e286b_.png" alt=""></a><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-element-type="static-layout" data-cmb-id="24"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><p>
  <b><span style="font-size:18px;">Register</span></b>
</p>
<p>Lorem ipsum dolor sit amet, consectetur  elit...</p>
</div></div></div>
                    </div><div class="cmb_column col-lg-3 col-sm-6" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="32">
                        <a class="cmb_img" data-cmb-wrapper="cmb_img" data-cmb-id="33" data-cmb-element-type="static-layout"><img class="img-fluid" src="/public/uploads/media/_2b70d0d5-b037-4659-a7e2-af47ce81d103_.png" alt=""></a><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-element-type="static-layout" data-cmb-id="34"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><p>
  <b><span style="font-size:18px;">Buy Or Bid</span></b>
</p>
<p>Lorem ipsum dolor sit amet, consectetur  elit...</p>
</div></div></div>
                    </div><div class="cmb_column col-lg-3 col-sm-6" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="28">
                        <a class="cmb_img" data-cmb-wrapper="cmb_img" data-cmb-id="29" data-cmb-element-type="static-layout"><img class="img-fluid" src="/public/uploads/media/_72c33549-536c-481a-934f-daf3a4da8597_.png" alt=""></a><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-element-type="static-layout" data-cmb-id="30"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><p>
  <b><span style="font-size:18px;">Submit A Bid</span></b>
</p>
<p>Lorem ipsum dolor sit amet, consectetur  elit...</p>
</div></div></div>
                    </div><div class="cmb_column col-lg-3 col-sm-6" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="25">
                        <a class="cmb_img" data-cmb-wrapper="cmb_img" data-cmb-id="26" data-cmb-element-type="static-layout"><img class="img-fluid" src="/public/uploads/media/_2dac7c40-5112-4649-aa6b-ed53dd702667_.png" alt=""></a><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-element-type="static-layout" data-cmb-id="27"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><p>
  <b><span style="font-size:18px;">Win</span></b>
</p>
<p>Lorem ipsum dolor sit amet, consectetur  elit...</p>
</div></div></div>
                    </div>



                </div></div>
            </div>
        </section><section class="cmb_section mt-5 mb-5" data-cmb-wrapper="cmb_section" data-cmb-id="35" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="36">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="37">
                    <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="38">

                    <div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="39" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Popular</span> <span class="cmb-single-line-editable-text">Auctions</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="/auctions" class="cmb-title-link"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div></div>
                </div>
            <div data-cmb-wrapper="cmb_auction" data-cmb-id="40" data-cmb-element-type="dynamic-layout" class="cmb_auction" data-cmb-dynamic-values="name:short_code_auction_list|column:3|item:6|type:popular"></div></div>
            </div>
        </section><section class="cmb_section mt-5 mb-5" data-cmb-wrapper="cmb_section" data-cmb-id="41" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="42">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="43">
                    <div class="cmb_column col-sm-12 cmb-temporary-min-padding" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="44">

                    <div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="45" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Customer</span> <span class="cmb-single-line-editable-text">Reviews</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="#" class="cmb-title-link d-none"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div></div>
                </div>
            <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-id="46" data-cmb-element-type="static-layout">
                    <div class="cmb_column col-md-4" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="47">

                    <div class="cmb_testimonial_item cmb-element" data-cmb-wrapper="cmb_testimonial_item" data-cmb-id="48" data-cmb-element-type="static-layout">
                <div class="cmb-testimonial-content">
                    <blockquote>
                        <i class="fa fa-quote-left"></i>
                        <span class="cmb-single-line-editable-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga iste officiis quam, recusandae sapiente soluta!</span>
                    </blockquote>
                </div>
                <div class="cmb-testimonial-client">
                    <div class="cmb-client-avatar">
                        <img src="/public/plugins/cm-visual-editor/images/avatar.jpg" alt="client" class="img-fluid">
                    </div>
                    <div class="cmb-client-info">
                        <h4 class="cmb-client-name"><span class="cmb-single-line-editable-text">MrClient Name</span></h4>
                        <p class="cmb-client-designation"><span class="cmb-single-line-editable-text">Web Designer</span></p>
                    </div>
                </div>
            </div></div><div class="cmb_column col-md-4" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="51">

                    <div class="cmb_testimonial_item cmb-element" data-cmb-wrapper="cmb_testimonial_item" data-cmb-id="52" data-cmb-element-type="static-layout">
                <div class="cmb-testimonial-content">
                    <blockquote>
                        <i class="fa fa-quote-left"></i>
                        <span class="cmb-single-line-editable-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga iste officiis quam, recusandae sapiente soluta!</span>
                    </blockquote>
                </div>
                <div class="cmb-testimonial-client">
                    <div class="cmb-client-avatar">
                        <img src="/public/plugins/cm-visual-editor/images/avatar.jpg" alt="client" class="img-fluid">
                    </div>
                    <div class="cmb-client-info">
                        <h4 class="cmb-client-name"><span class="cmb-single-line-editable-text">MrClient Name</span></h4>
                        <p class="cmb-client-designation"><span class="cmb-single-line-editable-text">Web Designer</span></p>
                    </div>
                </div>
            </div></div><div class="cmb_column col-md-4" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="49">

                    <div class="cmb_testimonial_item cmb-element" data-cmb-wrapper="cmb_testimonial_item" data-cmb-id="50" data-cmb-element-type="static-layout">
                <div class="cmb-testimonial-content">
                    <blockquote>
                        <i class="fa fa-quote-left"></i>
                        <span class="cmb-single-line-editable-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga iste officiis quam, recusandae sapiente soluta!</span>
                    </blockquote>
                </div>
                <div class="cmb-testimonial-client">
                    <div class="cmb-client-avatar">
                        <img src="/public/plugins/cm-visual-editor/images/avatar.jpg" alt="client" class="img-fluid">
                    </div>
                    <div class="cmb-client-info">
                        <h4 class="cmb-client-name"><span class="cmb-single-line-editable-text">MrClient Name</span></h4>
                        <p class="cmb-client-designation"><span class="cmb-single-line-editable-text">Web Designer</span></p>
                    </div>
                </div>
            </div></div>


                </div></div>
            </div>
        </section>',
                'settings' => $settings,
                'published_at' => now(),
                'is_home_page' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'slug' => 'auction-rules',
                'title' => 'Auction Rules',
                'body' => '<section class="cmb_section mt-5 mb-5" data-cmb-wrapper="cmb_section" data-cmb-id="1" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="2">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="3">
                    <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="4">

                    <div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="5" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Highest Bidder</span> <span class="cmb-single-line-editable-text">Auction</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="#" class="cmb-title-link d-none"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div></div>
                <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-id="6" data-cmb-element-type="static-layout">
    <div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-element-type="static-layout" data-cmb-id="7"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><p class="color-666">
  Highest bidder auction will be created by seller so the rest of auctions.
  Minimum bid amount will be given by auction creator. After creating auction
  any user who is
  <span class="color-default font-weight-bold">registered as a buyer</span> will
  be able to join in this auction before the given time is over. Bidding list
  will be displayed in the auction bidding history. Whenever buyer post an
  offer, no buyer will be allowed to post any lower amount. End of the auction
  the highest bidder
  <span class="color-default font-weight-bold">
    will be chosen as the winner</span>.
</p>
</div></div></div>
<ul class="list-unstyled cmb_checklist_box cmb-element" data-cmb-wrapper="cmb_checklist_box" data-cmb-id="8" data-cmb-element-type="static-layout">
        <li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="9">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Highest bidder will win the auction.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="10">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Seller will decide the starting bid amount / minimum bid amount.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="11">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">No one will be able to bid less amount than the existing highest bid amount.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="12">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Auction Creator will decide how many times a buyer will be able to bid</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="13">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Only <span class="color-default font-weight-bold">“Highest bidder amount”</span> and <span class="color-default font-weight-bold">“Number of bidder”</span> will be shown in bidding history.</span></span>
        </li>
    </ul></div></div>
            </div>
            </div>
        </section><section class="cmb_section mt-5 mb-5" data-cmb-wrapper="cmb_section" data-cmb-id="14" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="15">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="16">
                    <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="17">

                    <div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="18" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Blind Bidder</span> <span class="cmb-single-line-editable-text">Auction</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="#" class="cmb-title-link d-none"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div></div>
                <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-id="19" data-cmb-element-type="static-layout">
    <div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-element-type="static-layout" data-cmb-id="20"><div class="cmb-editable-text"><div class="cmb-editable-text-container">Blind Bidder is similar as highest bidder but
<span class="color-default font-weight-bold"> only difference </span> is bidding
amount will not be shown in bidding history of the auction.
<span class="color-default font-weight-bold"> Highest bidder </span> will win
the auction here also.
</div></div></div>
<ul class="list-unstyled cmb_checklist_box cmb-element" data-cmb-wrapper="cmb_checklist_box" data-cmb-id="21" data-cmb-element-type="static-layout">
        <li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="22">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Highest bidder will win the auction.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="23">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Seller will decide the starting bid amount / minimum bid amount.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="24">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Auction Creator will decide how many times a buyer will be able to bid</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="25">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Bidding history will stay hidden.</span></span>
        </li>
    </ul></div></div>
            </div>
            </div>
        </section><section class="cmb_section mt-5 mb-5" data-cmb-wrapper="cmb_section" data-cmb-id="26" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="27">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="28">
                    <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="29">

                    <div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="30" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Unique Bidder</span> <span class="cmb-single-line-editable-text">Auction</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="#" class="cmb-title-link d-none"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div></div>
                <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-id="31" data-cmb-element-type="static-layout">
    <div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-element-type="static-layout" data-cmb-id="32"><div class="cmb-editable-text"><div class="cmb-editable-text-container">Unique bidding also will not show the bidding history. The winner will be
selected by the specific rules of it.
<span class="color-default font-weight-bold">Lowest unique bidder</span> will
win the auction.
</div></div></div>
<ul class="list-unstyled cmb_checklist_box cmb-element" data-cmb-wrapper="cmb_checklist_box" data-cmb-id="33" data-cmb-element-type="static-layout">
        <li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="34">
            <span class="cmb-single-line-editable-text">
                                    <span class="bg-rules">Seller will announce minimum bidding amount. No one will able to bid less.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="35">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Bidding history will stay hidden.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="36">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">For second bid amount will be adjusted with last bids.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="37">
            <span class="cmb-single-line-editable-text">
                                    <span class="bg-rules">If bid is a set or multiple then the winner will be chosen from lowest multiple bidder the one who bid first.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="38">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">There will be no bid increment difference</span></span>
        </li>
    </ul></div></div>
            </div>
            </div>
        </section><section class="cmb_section mt-5 mb-5" data-cmb-wrapper="cmb_section" data-cmb-id="39" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="40">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="41">
                    <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="42">

                    <div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="43" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Vickrey</span> <span class="cmb-single-line-editable-text">Auction</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="#" class="cmb-title-link d-none"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div></div>
                <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-id="44" data-cmb-element-type="static-layout">
    <div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-element-type="static-layout" data-cmb-id="45"><div class="cmb-editable-text"><div class="cmb-editable-text-container">A Vickrey auction is a type of
<span class="color-default font-weight-bold">sealed-bid auction </span>. Bidders
submit written bids without knowing the bid of the other people in the auction.
The highest bidder wins but
<span class="color-default font-weight-bold">the price paid is the second-highest bid</span>.
</div></div></div>
<ul class="list-unstyled cmb_checklist_box cmb-element" data-cmb-wrapper="cmb_checklist_box" data-cmb-id="46" data-cmb-element-type="static-layout">
        <li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="47">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Highest bidder will win the auction.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="48">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Winner will pay the equal amount of the second highest bidder.</span></span>
        </li><li class="media cmb_checklist_item" data-cmb-wrapper="cmb_checklist_item" data-cmb-element-type="static-layout" data-cmb-id="49">
            <span class="cmb-single-line-editable-text">                                    <span class="bg-rules">Bidding history will stay hidden.</span></span>
        </li>
    </ul></div></div>
            </div>
            </div>
        </section>',
                'settings' => $settings,
                'published_at' => now(),
                'is_home_page' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'slug' => 'deposit-policy',
                'title' => 'Deposit Policy',
                'body' => '<section class="cmb_section" data-cmb-wrapper="cmb_section" data-cmb-id="1" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="2">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="3">
                    <div class="cmb_column col-12" data-cmb-wrapper="cmb_column" data-cmb-element-type="static-layout" data-cmb-id="4">
                        <div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="6" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Deposit</span> <span class="cmb-single-line-editable-text">Policy</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="#" class="cmb-title-link d-none"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-element-type="static-layout" data-cmb-id="5"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><div data-cmb-wrapper="cmb_editable_text" data-cmb-id="7" data-cmb-element-type="static-layout" class="cmb_editable_text">
  <div class="cmb-editable-text">
    <div class="cmb-editable-text-container">
      Lorem Ipsum is simply dummy text of the printing and typesetting industry.
      Lorem Ipsum has been the industry\'s standard dummy text ever since the
      1500s, when an unknown printer took a galley of type and scrambled it to
      make a type specimen book
    </div>
  </div>
</div>
<div data-cmb-wrapper="cmb_editable_text" data-cmb-id="6" data-cmb-element-type="static-layout" class="cmb_editable_text">
  <div class="cmb-editable-text">
    <div class="cmb-editable-text-container">
      <ol>
        <li>It has survived not only five centuries,</li>
        <li>but also the leap into electronic typesetting,</li>
        <li>remaining essentially unchanged.</li>
        <li>
    It was popularised in the 1960s with the release of Letraset sheets
          containing Lorem Ipsum
    </li>
        <li>passages, and more recently with desktop publishing s</li>
        <li>oftware like Aldus PageMaker including versions of Lorem Ipsum.</li>
      </ol>
    </div>
  </div>
</div>
<div data-cmb-wrapper="cmb_editable_text" data-cmb-id="8" data-cmb-element-type="static-layout" class="cmb_editable_text">
  <div class="cmb-editable-text">
    <div class="cmb-editable-text-container">
    Contrary to popular belief, Lorem Ipsum is not simply random text. It has
      roots in a piece of classical Latin literature from 45 BC, making it over
      2000 years old.
    </div>
  </div>
</div>
</div></div></div>
                    <div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="7" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><section data-cmb-wrapper="cmb_section" data-cmb-id="17" data-cmb-element-type="static-layout" class="cmb_section">
  <div class="section-overlay">
    <div data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="18" class="cmb_container container">
      <div data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="19" class="cmb_row row">
        <div data-cmb-wrapper="cmb_column" data-cmb-id="20" data-cmb-element-type="static-layout" class="cmb_column col-sm-12">

          <div data-cmb-wrapper="cmb_editable_text" data-cmb-id="13" data-cmb-element-type="static-layout" class="cmb_editable_text">
            <div class="cmb-editable-text">
              <div class="cmb-editable-text-container"><span class="st"><em>Lorem ipsum</em>, or lipsum as it is sometimes known, is dummy text used
  in laying out print, graphic or web designs. The passage is attributed to an
  unknown typesetter in the 15th century who is thought to have scrambled parts
  of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen
  book.</span>
</div>
            </div>
          </div>
          <div data-cmb-wrapper="cmb_editable_text" data-cmb-id="23" data-cmb-element-type="static-layout" class="cmb_editable_text">
            <div class="cmb-editable-text">
              <div class="cmb-editable-text-container">
                <ol>
                  <li>It has survived not only five centuries,</li>
                  <li>but also the leap into electronic typesetting,</li>
                  <li>remaining essentially unchanged.</li>
                  <li>
                    It was popularised in the 1960s with the release of Letraset
                    sheets containing Lorem Ipsum
                  </li>
                  <li>passages, and more recently with desktop publishing s</li>
                  <li>
                    oftware like Aldus PageMaker including versions of Lorem
                    Ipsum.
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div data-cmb-wrapper="cmb_editable_text" data-cmb-id="24" data-cmb-element-type="static-layout" class="cmb_editable_text">
            <div class="cmb-editable-text">
              <div class="cmb-editable-text-container">
                Contrary to popular belief, Lorem Ipsum is not simply random
                text. It has roots in a piece of classical Latin literature from
                45 BC, making it over 2000 years old.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</div></div></div></div>
                </div>
            </div>
            </div>
            </section>',
                'settings' => $settings,
                'published_at' => now(),
                'is_home_page' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'slug' => 'withdrawal-policy-page',
                'title' => 'Withdrawal Policy Page',
                'body' => '<section class="cmb_section" data-cmb-wrapper="cmb_section" data-cmb-id="1" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="2">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="3">

                <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-id="4" data-cmb-element-type="static-layout">

<div class="cmb-margin-bottom cmb_featured_title cmb-element" data-cmb-wrapper="cmb_featured_title" data-cmb-id="5" data-cmb-element-type="static-layout">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Withdrawal</span> <span class="cmb-single-line-editable-text">Policy</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="#" class="cmb-title-link d-none"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="7" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an
unknown printer took a galley of type and scrambled it to make a type specimen
book
</div></div></div><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="6" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><ol>
  <li>It has survived not only five centuries,</li>
  <li>but also the leap into electronic typesetting,</li>
  <li>remaining essentially unchanged.</li>
  <li>
    It was popularised in the 1960s with the release of Letraset sheets
    containing Lorem Ipsum
    </li>
  <li>passages, and more recently with desktop publishing s</li>
  <li>oftware like Aldus PageMaker including versions of Lorem Ipsum.</li>
</ol>
</div></div></div><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="8" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
in a piece of classical Latin literature from 45 BC, making it over 2000 years
old.
</div></div></div></div></div>
            </div>
            </div>
        </section><section class="cmb_section" data-cmb-wrapper="cmb_section" data-cmb-id="17" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="18">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="19">

                <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-id="20" data-cmb-element-type="static-layout">

<div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="22" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an
unknown printer took a galley of type and scrambled it to make a type specimen
book
</div></div></div><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="13" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><span class="st"><em>Lorem ipsum</em>, or lipsum as it is sometimes known, is dummy text used
  in laying out print, graphic or web designs. The passage is attributed to an
  unknown typesetter in the 15th century who is thought to have scrambled parts
  of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen
  book.</span>
</div></div></div><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="23" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><ol>
  <li>It has survived not only five centuries,</li>
  <li>but also the leap into electronic typesetting,</li>
  <li>remaining essentially unchanged.</li>
  <li>
    It was popularised in the 1960s with the release of Letraset sheets
    containing Lorem Ipsum
    </li>
  <li>passages, and more recently with desktop publishing s</li>
  <li>oftware like Aldus PageMaker including versions of Lorem Ipsum.</li>
</ol>
</div></div></div><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="24" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
in a piece of classical Latin literature from 45 BC, making it over 2000 years
old.
</div></div></div></div></div>
            </div>
            </div>
        </section><section class="cmb_section" data-cmb-wrapper="cmb_section" data-cmb-id="9" data-cmb-element-type="static-layout">
<div class="section-overlay">
            <div class="cmb_container container" data-cmb-wrapper="cmb_container" data-cmb-element-type="static-layout" data-cmb-id="10">
                <div class="cmb_row row" data-cmb-wrapper="cmb_row" data-cmb-element-type="static-layout" data-cmb-id="11">

                <div class="cmb_column col-sm-12" data-cmb-wrapper="cmb_column" data-cmb-id="12" data-cmb-element-type="static-layout">

<div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="14" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an
unknown printer took a galley of type and scrambled it to make a type specimen
book
</div></div></div><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="15" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container"><ol>
  <li>It has survived not only five centuries,</li>
  <li>but also the leap into electronic typesetting,</li>
  <li>remaining essentially unchanged.</li>
  <li>
    It was popularised in the 1960s with the release of Letraset sheets
    containing Lorem Ipsum
  </li>
  <li>passages, and more recently with desktop publishing s</li>
  <li>oftware like Aldus PageMaker including versions of Lorem Ipsum.</li>
</ol>
</div></div></div><div class="cmb_editable_text" data-cmb-wrapper="cmb_editable_text" data-cmb-id="16" data-cmb-element-type="static-layout"><div class="cmb-editable-text"><div class="cmb-editable-text-container">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
in a piece of classical Latin literature from 45 BC, making it over 2000 years
old.
</div></div></div></div></div>
            </div>
            </div>
        </section>',
                'settings' => $settings,
                'published_at' => now(),
                'is_home_page' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],

        ];
        DB::table('pages')->insert($input);
    }
}
