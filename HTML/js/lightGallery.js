window.lightGallery(
  document.getElementById("portfolio-gallery"),
  {
    autoplayFirstVideo: false,
    pager: false,
    galleryId: "portfolio-gallery",
    plugins: [lgZoom, lgThumbnail],
    mobileSettings: {
      controls: false,
      showCloseIcon: false,
      download: false,
      rotate: false
    }
  }
);


jQuery("#Projects")
.justifiedGallery({
captions: false,
// lastRow: "hide",
rowHeight: 180,
margins: 5
})
.on("jg.complete", function () {
window.lightGallery(
  document.getElementById("Projects"),
  {
    autoplayFirstVideo: false,
    pager: false,
    galleryId: "Projects",
    plugins: [lgZoom, lgThumbnail],
    mobileSettings: {
      controls: false,
      showCloseIcon: false,
      download: false,
      rotate: false
    }
  }
);
});

jQuery("#Events")
.justifiedGallery({
captions: false,
// lastRow: "hide",
rowHeight: 180,
margins: 5
})
.on("jg.complete", function () {
window.lightGallery(
  document.getElementById("Events"),
  {
    autoplayFirstVideo: false,
    pager: false,
    galleryId: "Events",
    plugins: [lgZoom, lgThumbnail],
    mobileSettings: {
      controls: false,
      showCloseIcon: false,
      download: false,
      rotate: false
    }
  }
);
});
