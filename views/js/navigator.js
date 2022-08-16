const HAMBURGER = document.querySelector('nav>.__hamburger');
const MENU = document.querySelector('nav>.__menu');
const CLOSE_NAV = document.querySelector('nav .__close')

HAMBURGER.addEventListener("click", toggleMenu)
CLOSE_NAV.addEventListener('click', toggleMenu)


function toggleMenu() {
    MENU.classList.toggle("--display")
    HAMBURGER.classList.toggle("--display")
    CLOSE_NAV.classList.toggle("--display")
}

const NAV=document.querySelector('nav')
window.onscroll=showBackground;
function showBackground(){
    let scrollPos=document.documentElement.scrollTop
    let fullHeight=window.innerHeight
    if(scrollPos>fullHeight){
        NAV.classList.add("--background")
    }else if(scrollPos<=fullHeight){
        NAV.classList.remove("--background")
    }
}

submitForm('form[name=login]', 'form button[name=submit]', '../controllers/login.php', '.notice', "index.html")
