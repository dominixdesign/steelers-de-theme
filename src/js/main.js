import throttle from "lodash.throttle";
import { createApp } from "vue";
import Glide from "@glidejs/glide";
import GLightbox from "glightbox";
import HomeSchedule from "./HomeSchedule.vue";
import HomeStandings from "./HomeStandings.vue";
import HomeShop from "./HomeShop.vue";

createApp(HomeSchedule).mount("#homeschedule");
createApp(HomeStandings).mount("#homestandings");
createApp(HomeShop).mount("#homeshop");

//Slider
document.querySelectorAll(".glide-gallery").forEach((el) => {
  new Glide(el, {
    type: "carousel",
    gap: 20,
    rewind: false,
    perView: 6,
    breakpoints: {
      480: {
        perView: 1,
      },
      768: {
        perView: 2,
      },
      1024: {
        perView: 3,
      },
      1280: {
        perView: 4,
      },
      1536: {
        perView: 5,
      },
      1960: {
        perView: 6,
      },
    },
  }).mount();
});

var breakpoints = {};
var elementWidth = 340;

for (var i = 1920; i > 0; i -= 200 / 2) {
  if (Math.floor(i / elementWidth) <= 1) {
    breakpoints[i] = {
      perView: 1,
      peek: { before: 0, after: 0 },
    };
  } else {
    breakpoints[i] = {
      perView: Math.floor((i - 100) / elementWidth),
      peek: { before: 0, after: Math.floor((i - 100) % elementWidth) },
    };
  }
}

document.querySelectorAll(".glide-news").forEach((el) => {
  new Glide(el, {
    bound: true,
    perView: 6,
    gap: 20,
    peek: { before: 0, after: 110 },
    breakpoints,
  }).mount();
});
// document.querySelectorAll(".blaze-slider").forEach((el) => {
//   let config = {};
//   if (el.dataset.blazeconfig === "gallery") {
//     config = {
//       all: {
//         enableAutoplay: true,
//         autoplayInterval: 2000,
//         transitionDuration: 300,
//         slideGap: "0px",
//         slidesToShow: 6,
//       },
//       "(max-width: 1536px)": {
//         slidesToShow: 5,
//       },
//       "(max-width: 1280px)": {
//         slidesToShow: 4,
//       },
//       "(max-width: 1024px)": {
//         slidesToShow: 3,
//       },
//       "(max-width: 768px)": {
//         slidesToShow: 2,
//       },
//       "(max-width: 500px)": {
//         slidesToShow: 1,
//       },
//     };
//   }
//   new BlazeSlider(el, config);
// });

//Lightbox
const lightbox = GLightbox({
  touchNavigation: true,
  loop: false,
  autoplayVideos: false,
});

// eventlisteners
window.onscroll = function () {
  stickyNavFunc();
};

var stickyNav = document.getElementsByClassName("top-sticky-nav");
var sticky = 80;

// events
function stickyNavFunc() {
  if (window.pageYOffset > sticky) {
    document.body.classList.add("sticky");
    document.getElementById("container").style.paddingTop = sticky + "px";
  } else {
    document.body.classList.remove("sticky");
    document.getElementById("container").style.paddingTop = 0;
  }
}

function mouseMoveNav(evt) {
  stickyNav[0].style.setProperty("--mouse-x", evt.clientX + "px");
  stickyNav[1].style.setProperty("--mouse-x", evt.clientX + "px");
}

const mouseMoveAction = throttle(mouseMoveNav, 20);
stickyNav[0].addEventListener("mousemove", (evt) => {
  mouseMoveAction(evt);
});
stickyNav[1].addEventListener("mousemove", (evt) => {
  mouseMoveAction(evt);
});

// on boot
stickyNavFunc();

let burger = document.getElementById("burger"),
  burgerClose = document.getElementById("burger-close"),
  nav = document.getElementById("main-nav"),
  mainDiv = document.getElementById("main"),
  footer = document.getElementById("footer");

burger.addEventListener("click", function (e) {
  nav.classList.add("is-open");
  stickyNav[0].classList.add("opacity-0");
  stickyNav[1].classList.add("opacity-0");
  window.setTimeout(() => mainDiv.classList.add("hidden"), 275);
  window.setTimeout(() => footer.classList.add("hidden"), 275);
  document.body.classList.toggle("overflow-hidden");
});
burgerClose.addEventListener("click", function (e) {
  nav.classList.remove("is-open");
  mainDiv.classList.remove("hidden");
  footer.classList.remove("hidden");
  stickyNav[0].classList.remove("opacity-0");
  stickyNav[1].classList.remove("opacity-0");
  window.setTimeout(
    () => document.body.classList.remove("overflow-hidden"),
    275
  );
});
