

var activitySwiper = new Swiper(".cat-slider", {
    //   effect: "coverflow",
    //   grabCursor: true,
    //   centeredSlides: true,
      slidesPerView: 4,
    speed: 5000,

      loop: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
        },     
    //   coverflowEffect: {
    //     rotate: 50,
    //     stretch: 0,
    //     depth: 100,
    //     modifier: 1,
    //     slideShadows: true,
    //   },
      navigation: {
        nextEl: '.cat-swiper-button-next',
        prevEl: '.cat-swiper-button-prev',
      },
      pagination: {
        el: ".cat-swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        480: {
            slidesPerView: 1,
            spaceBetween: 20,
            // speed: 2000,

        },
        640: {
            slidesPerView: 2,
            spaceBetween: 30,
            // speed: 2000,

        },
        768: {
          slidesPerView: 2,
          spaceBetween: 30
      },
        992: {
          slidesPerView: 4,
          spaceBetween: 30
      }
    }

    });

  