let menu = document.querySelector('#menu-icon');
let navbarun = document.querySelector('.navbarun');

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    navbarun.classList.toggle('open');
}

// Ketika halaman discroll
window.onscroll = function() {
    const header = document.querySelector('header');
    const fixedNav = header.offsetTop;

    if (window.pageYOffset > fixedNav) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
};
