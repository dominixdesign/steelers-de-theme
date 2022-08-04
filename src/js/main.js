import throttle from "lodash.throttle";
import { createApp } from "vue";
import HomeSchedule from "./HomeSchedule.vue";
import HomeStandings from "./HomeStandings.vue";

createApp(HomeSchedule).mount("#homeschedule");
createApp(HomeStandings).mount("#homestandings");

// eventlisteners
window.onscroll = function () {
  stickyNavFunc();
};

var stickyNav = document.getElementById("top-sticky-nav");
var sticky = 80;

// events
function stickyNavFunc() {
  if (window.pageYOffset > sticky) {
    document.body.classList.add("sticky");
    document.getElementById("container").style.paddingTop =
      stickyNav.offsetHeight + "px";
  } else {
    document.body.classList.remove("sticky");
    document.getElementById("container").style.paddingTop = 0;
  }
}

function mouseMoveNav(evt) {
  stickyNav.style.setProperty("--mouse-x", evt.clientX + "px");
}

const mouseMoveAction = throttle(mouseMoveNav, 20);
stickyNav.addEventListener("mousemove", (evt) => {
  mouseMoveAction(evt);
});

// on boot
stickyNavFunc();

let burger = document.getElementById("burger"),
  burgerClose = document.getElementById("burger-close"),
  nav = document.getElementById("main-nav"),
  main = document.getElementById("main");

burger.addEventListener("click", function (e) {
  nav.classList.add("is-open");
  stickyNav.classList.add("opacity-0");
  window.setTimeout(() => main.classList.add("hidden"), 275);
  document.body.classList.toggle("overflow-hidden");
});
burgerClose.addEventListener("click", function (e) {
  nav.classList.remove("is-open");
  main.classList.remove("hidden");
  stickyNav.classList.remove("opacity-0");
  window.setTimeout(
    () => document.body.classList.remove("overflow-hidden"),
    275
  );
});
