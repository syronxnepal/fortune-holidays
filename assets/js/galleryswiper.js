var swiper = new Swiper(".gallerythumbnail", {
  loop: true,
  spaceBetween: 10,
  slidesPerView: 4,
  freeMode: true,
  watchSlidesProgress: true,
});
var swiper2 = new Swiper(".galleryswiper", {
  loop: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
    },
  spaceBetween: 10,
  navigation: {
    nextEl: ".gallery-button-next",
    prevEl: ".gallery-button-prev",
  },
  thumbs: {
    swiper: swiper,
  },
});
