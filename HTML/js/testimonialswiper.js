

var activitySwiper = new Swiper(".test-slider", {
    //   effect: "coverflow",
    //   grabCursor: true,
    //   centeredSlides: true,
    //   slidesPerView: "auto",
    slidesPerView: 1,
    spaceBetween: 30,
      loop: true,
      autoplay: {
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
        nextEl: '.test-swiper-button-next',
        prevEl: '.test-swiper-button-prev',
      },
      pagination: {
        el: ".test-swiper-pagination",
        clickable: true
      },
      breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 0
        },
        480: {
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 2000,

        },
        640: {
            slidesPerView: 1,
            spaceBetween: 30,
            speed: 2000,

        },
        768: {
          slidesPerView: 1,
          spaceBetween: 30
      },
        992: {
          slidesPerView: 1,
          spaceBetween: 30
      },
      1024: {
        slidesPerView: 1,
        spaceBetween: 30
    }
    }

    });

  