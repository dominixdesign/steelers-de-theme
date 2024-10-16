import throttle from "lodash.throttle";
import { createApp } from "vue";
import GLightbox from "glightbox";
import Swiper, { Navigation, Autoplay } from "swiper";
import HomeSchedule from "./HomeSchedule.vue";
import HomeStandings from "./HomeStandings.vue";
// import FormApp from './FormApp.vue'
import { tinyDrawer } from "./TinyDrawer";
// import Vueform from '@vueform/vueform'
// import vueformConfig from './../../vueform.config'

createApp(HomeSchedule).mount("#homeschedule");
createApp(HomeStandings).mount("#homestandings");

// Form
// const formApp = createApp(FormApp)
// formApp.use(Vueform, vueformConfig)
// formApp.mount('#formApp')


//Slider

document.querySelectorAll(".swiper-news").forEach((el) => {
  new Swiper(el, {
    slidesPerView: 1,
    spaceBetween: 20,
    modules: [Navigation],
    navigation: {
      nextEl: ".swiper-button-right",
      prevEl: ".swiper-button-left",
    },
    breakpoints: {
      640: {
        slidesPerView: "auto",
      },
    },
  });
});
document.querySelectorAll(".swiper-home").forEach((el) => {
  new Swiper(el, {
    slidesPerView: 1,
    loop: true,
    modules: [Navigation, Autoplay],
    autoplay: {
      delay: 5000,
      pauseOnMouseEnter: true,
    },
    navigation: {
      nextEl: ".swiper-button-right",
      prevEl: ".swiper-button-left",
    },
  });
});

document.querySelectorAll(".swiper-shop").forEach((el) => {
  const nextEl = document.querySelector("#homeshop .swiper-button-right");
  const prevEl = document.querySelector("#homeshop .swiper-button-left");
  new Swiper(el, {
    gap: 0,
    slidesPerView: 1,
    modules: [Navigation],
    navigation: {
      nextEl,
      prevEl,
    },
    breakpoints: {
      500: {
        slidesPerView: 2,
      },
      1000: {
        slidesPerView: 3,
      },
    },
    on: {
      slideChangeTransitionEnd: function (swiper) {
        const href = swiper.el
          .querySelector(".swiper-slide-active a")
          .getAttribute("href");

        document.querySelector("#homeshop .buy-now").setAttribute("href", href);
      },
    },
  });
});

document.querySelectorAll(".swiper-gallery").forEach((el) => {
  new Swiper(el, {
    slidesPerView: "auto",
    spaceBetween: 20,
    modules: [Navigation],
    navigation: {
      nextEl: ".swiper-button-right",
      prevEl: ".swiper-button-left",
    },
  });
});

// Main Navigation
tinyDrawer();

//Lightbox
const lightbox = GLightbox({
  touchNavigation: true,
  loop: false,
  autoplayVideos: false,
});
const lightbox2 = GLightbox({
  selector: "data-lightbox",
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
}

const mouseMoveAction = throttle(mouseMoveNav, 20);
stickyNav[0].addEventListener("mousemove", (evt) => {
  mouseMoveAction(evt);
});

// on boot
stickyNavFunc();


/**
 * DSGVO Video Embed, v1.1.0
 * (c) 2021 Arndt von Lucadou
 * MIT License
 * https://github.com/a-v-l/dsgvo-video-embed
 */

(function() {
    // Config
    var text = {
        youtube: '<strong>Eingebettetes YouTube-Video</strong><div><p><b>Hinweis:</b> Dieses eingebettete Video wird von YouTube, LLC, 901 Cherry Ave., San Bruno, CA 94066, USA bereitgestellt.<br>Beim Abspielen wird eine Verbindung zu den Servern von YouTube hergestellt. Dabei wird YouTube mitgeteilt, welche Seiten Sie besuchen. Wenn Sie in Ihrem YouTube-Account eingeloggt sind, kann YouTube Ihr Surfverhalten Ihnen persönlich zuzuordnen. Dies verhindern Sie, indem Sie sich vorher aus Ihrem YouTube-Account ausloggen.</p><p>Wird ein YouTube-Video gestartet, setzt der Anbieter Cookies ein, die Hinweise über das Nutzerverhalten sammeln.</p><p>Wer das Speichern von Cookies für das Google-Ads-Programm deaktiviert hat, wird auch beim Anschauen von YouTube-Videos mit keinen solchen Cookies rechnen müssen. YouTube legt aber auch in anderen Cookies nicht-personenbezogene Nutzungsinformationen ab. Möchten Sie dies verhindern, so müssen Sie das Speichern von Cookies im Browser blockieren.</p><p>Weitere Informationen zum Datenschutz bei „YouTube“ finden Sie in der Datenschutzerklärung des Anbieters unter: <a href="https://www.google.de/intl/de/policies/privacy/" rel="noopener" target="_blank">https://www.google.de/intl/de/policies/privacy/</a></p></div><a class="video-link" href="https://youtu.be/%id%" rel="noopener" target="_blank" title="Video auf YouTube ansehen">Link zum Video: https://youtu.be/%id%</a><button title="Video auf dieser Seite ansehen">Video abspielen</button>',
        vimeo: '<strong>Eingebettetes Vimeo-Video</strong><div><p><b>Hinweis:</b> Dieses eingebettete Video wird von Vimeo, Inc., 555 West 18th Street, New York, New York 10011, USA bereitgestellt.<br>Beim Abspielen wird eine Verbindung zu den Servern von Vimeo hergestellt. Dabei wird Vimeo mitgeteilt, welche Seiten Sie besuchen. Wenn Sie in Ihrem Vimeo-Account eingeloggt sind, kann Vimeo Ihr Surfverhalten Ihnen persönlich zuzuordnen. Dies verhindern Sie, indem Sie sich vorher aus Ihrem Vimeo-Account ausloggen.</p><p>Wird ein Vimeo-Video gestartet, setzt der Anbieter Cookies ein, die Hinweise über das Nutzerverhalten sammeln.</p><p>Weitere Informationen zum Datenschutz bei „Vimeo“ finden Sie in der Datenschutzerklärung des Anbieters unter: <a href="https://vimeo.com/privacy" rel="noopener" target="_blank">https://vimeo.com/privacy</a></p></div><a class="video-link" href="https://vimeo.com/%id%" rel="noopener" target="_blank" title="Video auf Vimeo ansehen">Link zum Video: https://vimeo.com/%id%</a><button title="Video auf dieser Seite ansehen">Video abspielen</button>'
    };
    window.video_iframes=[];document.addEventListener("DOMContentLoaded",(function(){for(var video_frame,wall,video_platform,video_src,video_id,video_w,video_h,i=0,max=window.frames.length-1;i<=max;i+=1)video_src=(video_frame=document.getElementsByTagName("iframe")[0]).src||video_frame.dataset.src,console.log(video_src,!!video_frame.src),null!=video_src.match(/youtube|vimeo/)&&(video_iframes.push(video_frame),video_w=video_frame.getAttribute("width"),video_h=video_frame.getAttribute("height"),wall=document.createElement("article"),video_frame.src&&(void 0===window.frames[0].stop?setTimeout((function(){window.frames[0].execCommand("Stop")}),1e3):setTimeout((function(){window.frames[0].stop()}),1e3)),video_platform=null==video_src.match(/vimeo/)?"youtube":"vimeo",video_id=video_src.match(/(embed|video)\/([^?\s]*)/)[2],wall.setAttribute("class","video-wall"),wall.setAttribute("data-index",i),video_w&&video_h&&wall.setAttribute("style","width:"+video_w+"px;height:"+video_h+"px"),wall.innerHTML=text[video_platform].replace(/\%id\%/g,video_id),video_frame.parentNode.replaceChild(wall,video_frame),document.querySelectorAll(".video-wall button")[i].addEventListener("click",(function(){var video_frame=this.parentNode,index=video_frame.dataset.index;video_iframes[index].dataset.src&&(video_iframes[index].src=video_iframes[index].dataset.src,video_iframes[index].removeAttribute("data-src")),video_iframes[index].src=video_iframes[index].src.replace(/www\.youtube\.com/,"www.youtube-nocookie.com"),video_frame.parentNode.replaceChild(video_iframes[index],video_frame)}),!1))}))
})();
