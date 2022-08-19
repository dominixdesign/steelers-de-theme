import throttle from "lodash.throttle";
import { createApp } from "vue";
import GLightbox from 'glightbox';
import HomeSchedule from "./HomeSchedule.vue";
import HomeStandings from "./HomeStandings.vue";

createApp(HomeSchedule).mount("#homeschedule");
createApp(HomeStandings).mount("#homestandings");

//Lightbox
const lightbox = GLightbox({
  touchNavigation: true,
  loop: false,
  autoplayVideos: false
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
    document.getElementById("container").style.paddingTop =
    sticky + "px";
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
  mainDiv = document.getElementById("main");

burger.addEventListener("click", function (e) {
  nav.classList.add("is-open");
  stickyNav[0].classList.add("opacity-0");
  stickyNav[1].classList.add("opacity-0");
  window.setTimeout(() => mainDiv.classList.add("hidden"), 275);
  document.body.classList.toggle("overflow-hidden");
});
burgerClose.addEventListener("click", function (e) {
  nav.classList.remove("is-open");
  mainDiv.classList.remove("hidden");
  stickyNav[0].classList.remove("opacity-0");
  stickyNav[1].classList.remove("opacity-0");
  window.setTimeout(
    () => document.body.classList.remove("overflow-hidden"),
    275
  );
});
