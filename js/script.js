let navbar = document.querySelector('.header .navbar');

document.querySelector('#menu-btn').onclick = () => {
   navbar.classList.toggle('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
}

document.querySelectorAll('.contact .row .faq .box h3').forEach(faqBox => {
   faqBox.onclick = () =>{
      faqBox.parentElement.classList.toggle('active');
   }
});

document.querySelectorAll('input[type="number"]').forEach(inputNumbmer => {
   inputNumbmer.oninput = () =>{
      if(inputNumbmer.value.length > inputNumbmer.maxLength) inputNumbmer.value = inputNumbmer.value.slice(0, inputNumbmer.maxLength);
   }
});

var swiper = new Swiper(".home-slider", {
   loop:true,
   effect: "coverflow",
   spaceBetween: 30,
   grabCursor: true,
   coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: false,
   },
   navigation: {
     nextEl: ".swiper-button-next",
     prevEl: ".swiper-button-prev",
   },
});

var swiper = new Swiper(".gallery-slider", {
   loop:true,
   effect: "coverflow",
   slidesPerView: "auto",
   centeredSlides: true,
   grabCursor: true,
   coverflowEffect: {
      rotate: 0,
      stretch: 0,
      depth: 100,
      modifier: 2,
      slideShadows: true,
   },
   pagination: {
      el: ".swiper-pagination",
    },
});

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   slidesPerView: "auto",
   grabCursor: true,
   spaceBetween: 30,
   pagination: {
      el: ".swiper-pagination",
   },
   breakpoints: {
      768: {
        slidesPerView: 1,
      },
      991: {
        slidesPerView: 2,
      },
   },
});



//room js
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

hamburger.addEventListener("click", mobileMenu);

function mobileMenu()   {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
}

const navLink = document.querySelectorAll('.nav-link');
navLink.forEach((n) => n.addEventListener("click", closeMenu));

function closeMenu()    {
    hamburger.classList.remove("active");
    navMenu.classList.toggle("active");
}

let datePopup = document.getElementById("date-popup");
let roomPopup = document.getElementById("room-popup");
let ratesPopup = document.getElementById("rates-popup");

function dateOpenPopup()    {
    datePopup.classList.add("date-open-popup");
}
function dateClosePopup()    {
    datePopup.classList.remove("date-open-popup");
}

function roomOpenPopup()    {
    roomPopup.classList.add("room-open-popup");
}
function roomClosePopup()    {
    roomPopup.classList.remove("room-open-popup");
}

function ratesOpenPopup()    {
    ratesPopup.classList.add("rates-open-popup");
}
function ratesClosePopup()    {
    ratesPopup.classList.remove("rates-open-popup");
}


const picker = new easepick.create({
    element: "#datepicker",
    css: [
        "https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css"
    ],
    zIndex: 10,
    grid: 2,
    calendars: 2,
    inline: true,
    plugins: [
        "RangePlugin"
    ]
})

