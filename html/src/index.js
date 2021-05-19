// Remove the following lines, if y

window.jQuery = $;
window.$ = $;

require("bootstrap");

// Remove this demo code, that's only here to show how the .env file works!
if (process.env["HELLO"]) {
  console.log(`Hello ${process.env.HELLO}!`);
}

// menu бургер
const iconMenu = document.querySelector('.menu__icon');
if (iconMenu) {
  const menuBody = document.querySelector('.menu__body');
  iconMenu.addEventListener('click', function (e) {
    document.body.classList.toggle('lock');
    iconMenu.classList.toggle('active');
    menuBody.classList.toggle('active');
  })
}

// прокрутка при клике
// const menuLinsk = document.querySelector('.menu__link[data-goto]');
// if(menuLinsk.length > 0) {
//
// }


// swiper slider
