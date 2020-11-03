function openNav() {
    if (window.matchMedia("(min-width: 813px)").matches) {
        document.querySelector('.sideNav').style.width = "250px";
    } else {
        document.querySelector('.sideNav').style.width = "160px";
    }
    document.querySelector('.nav').style.display = "flex";
}

function closeNav() {
    document.querySelector('.sideNav').style.width = "0";
    document.querySelector('.nav').style.display = "none";
}

const burgerButton = document.querySelector('.openButton');
const closeButton = document.querySelector('.closeButton');

burgerButton.addEventListener('click',openNav);
closeButton.addEventListener('click',closeNav);