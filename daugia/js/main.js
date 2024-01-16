(function ($) {
  // open ready function
  $(document).ready(function () {

    // slider banner
    $('.slider-banner').slick({
      dots: true,
      arrows: true,
      infinite: true,
      slidesToShow: 1,
      autoplay: true,
      autoplaySpeed: 4000,
      slidesToScroll: 1,
      fade: true
    });

    // slider assets coming soon tablet
    var slick_slider = $('.list-assets-coming');
    var settings_slider = {
      dots: false,
      arrows: false,
      infinite: false,
      slidesToShow: 3,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: false,
            arrows: false,
            autoplay: true,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]

    }
    slick_on_mobile(slick_slider, settings_slider);

    // slick on mobile
    function slick_on_mobile(slider, settings) {
      $(window).on('load resize', function () {
        if ($(window).width() > 1024) {
          if (slider.hasClass('slick-initialized')) {
            slider.slick('unslick');
          }
          return
        }
        if (!slider.hasClass('slick-initialized')) {
          return slider.slick(settings);
        }
      });
    };

    // slick slider product
    $('.img-prd-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      fade: true,
      asNavFor: '.img-prd-nav'
    });
    $('.img-prd-nav').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: '.img-prd-for',
      dots: true,
      centerMode: false,
      focusOnSelect: true,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: false,
            arrows: false,
            autoplay: true,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]

    });

    // toggle menu bar
    $(document).on('click', '.nav-cat .nav-cat-bar', function () {
      $(this).toggleClass('open-menu');
    });

    // toggle menu bar mobile
    $(document).on('click', '.nav-bar-icon', function () {
      $('.nav-menu-mb').toggleClass('open-menu-mb');
    });

    // toggle sub menu mobile
    $(document).on('click', '.drop-sub-menu-mb', function () {
      $(this).parent().toggleClass('open-sub-mb');
    });
    
    // backtotop
    const backtotop = $('#backtotop-btn');
    
    $(window).on('scroll', function(){
       if ($(window).scrollTop() > 1000) {
        backtotop.addClass('show');
      } else {
        backtotop.removeClass('show');
      } 
    });
    backtotop.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '700');
    });
    
    
  });
  // end ready
})(jQuery)

// // animation button
// const mbtnAnimate = document.querySelectorAll('.mbtn-amt');
// mbtnAnimate.forEach(btn => {
//   btn.addEventListener('click', function (e) {

//     let x = e.clientX - e.target.offsetLeft;
//     let y = e.clientY - e.target.offsetTop;
//     console.log(e.target.offsetLeft + "   " + e.target.offsetTop + "   " + e.clientX + "   " + e.clientY);
//     let appendElm = document.createElement('span');
//     appendElm.style.left = x + 'px';
//     appendElm.style.top = y + 'px';
//     this.appendChild(appendElm);
//     setTimeout(() => {
//       appendElm.remove();
//     }, 1000);
//   })
// });

// tabs single product
const tabLinks = document.querySelectorAll('.tablinks');
const tabContent = document.querySelectorAll('.tabcontent');
tabLinks.forEach(btn => {
  btn.addEventListener('click', function (e) {
    tabContent.forEach(cten => {
      cten.style.display = "none";
    });
    tabLinks.forEach(element => {
      element.classList.remove('active');
    });
    e.target.className += " active";
    let idTabContent = e.target.dataset.tab;
    document.getElementById(idTabContent).style.display = "block";
  });
});

// zoom magnifier

const magnifierImgArea = document.querySelector('.item-img-full');
const magnifierImg = document.querySelector('.item-img-full.slick-active  a  img');
console.log(magnifierImgArea);