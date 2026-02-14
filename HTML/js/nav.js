function onBarsPressed (e) {
  let smallNavCOntainer = document.querySelector(".small-nav-container");
  smallNavCOntainer.classList.add("small-nav-con-on");
};

function onCrossPressed(e){
  let smallNavCOntainer = document.querySelector(".small-nav-container");
  smallNavCOntainer.classList.remove("small-nav-con-on");
};

const onSmallDropPress = (e) => {
  let smallNavDrop = document.querySelector(".small-nav-dropdown");
  smallNavDrop.classList.toggle("small-nav-drop-on");
};

const removeNavDrop =(event)=>{
  let smallNavDrop = document.querySelector(".small-nav-dropdown");
  smallNavDrop.classList.remove("small-nav-con-on");

}
for (let i =0; i<5;i++ ){
    let myNav = document.querySelector(".sub-menu");
    let navItem = document.querySelectorAll(".menu-item");
    if(i==1 && navItem && myNav){
  
      navItem[i].addEventListener('mouseover', ()=>{
        console.log("enter")
        myNav.classList.add("nav-drop-on");
      
      })
      navItem[i].addEventListener('mouseout', ()=>{
        console.log("leave")
        myNav.classList.remove("nav-drop-on");
      
      })
    }
  }
 window.addEventListener("scroll", (e) => {
  if(window.scrollY > 150){
    const stickyNav = document.querySelector(".sticky-nav");
    stickyNav.classList.add("sticky-nav-on");
  }
  else{
    const stickyNav = document.querySelector(".sticky-nav");
    stickyNav.classList.remove("sticky-nav-on");
  }
});
  
