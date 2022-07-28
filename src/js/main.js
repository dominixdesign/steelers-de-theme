import throttle from "lodash.throttle";

// eventlisteners
window.onscroll = function () {
  stickyNavFunc();
};

var stickyNav = document.getElementById("top-sticky-nav");
var body = document.getElementsByTagName("body");
var sticky = stickyNav.offsetTop;

// events
function stickyNavFunc() {
  if (window.pageYOffset > sticky) {
    body[0].classList.add("sticky");
    document.getElementById("container").style.paddingTop =
      stickyNav.offsetHeight + "px";
  } else {
    body[0].classList.remove("sticky");
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
