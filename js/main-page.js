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

// carousel
const CAROUSEL_IMAGES=document.querySelectorAll('.carousel__img-wrapper>img')
const CAROUSEL_LEFT=document.querySelector('.carousel__arrow.--left')
const CAROUSEL_RIGHT=document.querySelector('.carousel__arrow.--right')
let index=1;
CAROUSEL_LEFT.addEventListener('click',showLastPic)
CAROUSEL_RIGHT.addEventListener('click',showNextPic)
function PicIndex(num) {
    if(num<0)
        num+=CAROUSEL_IMAGES.length
    if(num>=CAROUSEL_IMAGES.length)
        num-=CAROUSEL_IMAGES.length
    return num
}
function showNextPic(e,against=false){
    CAROUSEL_IMAGES[PicIndex(index-1)].classList.remove('--last');
    CAROUSEL_IMAGES[PicIndex(index)].classList.remove('--current')
    CAROUSEL_IMAGES[PicIndex(index+1)].classList.remove('--next')
    if(against===false)
    index=PicIndex(index+1)
    else index=PicIndex(index-1)
    CAROUSEL_IMAGES[PicIndex(index-1)].classList.add('--last')
    CAROUSEL_IMAGES[PicIndex(index)].classList.add('--current')
    CAROUSEL_IMAGES[PicIndex(index+1)].classList.add('--next')
}
function showLastPic(){
    showNextPic(undefined,true)
}
window.onload=()=>{setInterval(showNextPic,5000)}

//ranking
const IMAGE_TAGS=document.querySelectorAll('.main__items>figure>.__tag');
for( let i=0;i <IMAGE_TAGS.length;i++){
    IMAGE_TAGS[i].firstChild.nodeValue=String(i+1);
}

//dialog boxes
const DIALOG_LOGIN=document.querySelector('.dialog-wrapper')
const LOGIN_CLOSE=document.querySelector('.dialog .__close')
const LOGIN=document.querySelector('.login')
LOGIN_CLOSE.addEventListener('click',(()=>{
        DIALOG_LOGIN.classList.remove('--display')
    })
)
LOGIN.addEventListener('click',(()=>{
    DIALOG_LOGIN.classList.add('--display')
}))