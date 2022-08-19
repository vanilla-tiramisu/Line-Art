// carousel
const CAROUSEL_IMAGES = document.querySelectorAll('.carousel__img-wrapper>img')
const CAROUSEL_LEFT = document.querySelector('.carousel__arrow.--left')
const CAROUSEL_RIGHT = document.querySelector('.carousel__arrow.--right')
let index = 1;
CAROUSEL_LEFT.addEventListener('click', showLastPic)
CAROUSEL_RIGHT.addEventListener('click', showNextPic)

function PicIndex(num) {
    if (num < 0)
        num += CAROUSEL_IMAGES.length
    if (num >= CAROUSEL_IMAGES.length)
        num -= CAROUSEL_IMAGES.length
    return num
}

function showNextPic(event, against = false) {
    CAROUSEL_IMAGES[PicIndex(index - 1)].classList.remove('--last');
    CAROUSEL_IMAGES[PicIndex(index)].classList.remove('--current')
    CAROUSEL_IMAGES[PicIndex(index + 1)].classList.remove('--next')
    if (against === false)
        index = PicIndex(index + 1)
    else index = PicIndex(index - 1)
    CAROUSEL_IMAGES[PicIndex(index - 1)].classList.add('--last')
    CAROUSEL_IMAGES[PicIndex(index)].classList.add('--current')
    CAROUSEL_IMAGES[PicIndex(index + 1)].classList.add('--next')
}

function showLastPic() {
    showNextPic(undefined, true)
}

window.onload = () => {
    setInterval(showNextPic, 5000)
}

//ranking
const IMAGE_TAGS = document.querySelectorAll('.main__items>figure>.__tag');
for (let i = 0; i < IMAGE_TAGS.length; i++) {
    IMAGE_TAGS[i].firstChild.nodeValue = String(i + 1);
}

//discover more
const DISCOVER_MORE = document.querySelector('section.main__flow>button')
DISCOVER_MORE.addEventListener('click', () => {
    window.location.href = "items.html"
})

//
highlightSelected("nav .__home")
window.addEventListener("scroll", ()=>{
    showBackground(window.innerHeight)
})
