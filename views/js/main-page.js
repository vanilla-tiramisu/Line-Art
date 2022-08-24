// carousel
const CAROUSEL_FRAMES = document.querySelectorAll('.carousel__img-wrapper>a')
const CAROUSEL_LEFT = document.querySelector('.carousel__arrow.--left')
const CAROUSEL_RIGHT = document.querySelector('.carousel__arrow.--right')
let index = 0;
CAROUSEL_LEFT.addEventListener('click', showLastPic)
CAROUSEL_RIGHT.addEventListener('click', showNextPic)

function PicIndex(num) {
    if (num < 0)
        num += CAROUSEL_FRAMES.length
    if (num >= CAROUSEL_FRAMES.length)
        num -= CAROUSEL_FRAMES.length
    return num
}

function showNextPic(event, against = false) {
    CAROUSEL_FRAMES[PicIndex(index - 1)].classList.remove('--last');
    CAROUSEL_FRAMES[PicIndex(index)].classList.remove('--current')
    CAROUSEL_FRAMES[PicIndex(index + 1)].classList.remove('--next')
    if (against === false)
        index = PicIndex(index + 1)
    else index = PicIndex(index - 1)
    CAROUSEL_FRAMES[PicIndex(index - 1)].classList.add('--last')
    CAROUSEL_FRAMES[PicIndex(index)].classList.add('--current')
    CAROUSEL_FRAMES[PicIndex(index + 1)].classList.add('--next')
    updateDesc()
}

function showLastPic() {
    showNextPic(undefined, true)
}

// console.log(result[0])
let desc = new Array(5);
desc.fill({
    title: 'title',
    artist: 'unknown',
    price: 'unknown',
    release_date: 'unknown'
})
const CAROUSEL_DESC = document.querySelector(".carousel__description")

function updateDesc() {
    CAROUSEL_DESC.firstElementChild.innerHTML = desc[index].title
    CAROUSEL_DESC.firstElementChild.nextElementSibling.innerHTML = `
        <p><h5>Artist:</h5><span>${desc[index].artist}</span></p>
        <p><h5>Price:</h5><span>${desc[index].price}</span></p>
        <p><h5>Released in:</h5><span>${desc[index].release_date}</span></p>
    `
}

window.onload = () => {
    setInterval(() => {
        showNextPic()
    }, 5000)
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
window.addEventListener("scroll", () => {
    showBackground(window.innerHeight)
});


async function showLatest() {
    try {
        let response = await fetch('../controllers/getLatestItems.php');
        return await response.json();
    } catch (error) {
        console.log('Request failed', error);
    }
}

(async function () {
    let response = await showLatest();
    if (await response) {
        let result = await response.msg
        desc = result
        updateDesc()
        for (let i = 0; i < CAROUSEL_FRAMES.length && i < result.length; i++) {
            let imgsrc = "../img/" + result[i].filename;
            CAROUSEL_FRAMES[i].setAttribute("href", "detail.php?id=" + result[i].id)
            CAROUSEL_FRAMES[i].firstElementChild.setAttribute("src", imgsrc)
        }
    } else {
        sendNotice(".notice", "Network error")
    }
})();

async function showHottest() {
    try {
        let response = await fetch('../controllers/getHottestItems.php');
        return await response.json();
    } catch (error) {
        console.log('Request failed', error);
    }
}


const MainItemUrls = document.querySelectorAll(".main__items a");
(async function () {
    let response = await showHottest();
    if (await response) {
        let result = await response.msg
        console.log(result)
        updateDesc()
        for (let i = 0; i < MainItemUrls.length && i < result.length; i++) {
            let imgsrc = "../img/" + result[i].filename;
            console.log(imgsrc)
            MainItemUrls[i].setAttribute("href", "detail.php?id=" + result[i].id)
            MainItemUrls[i].firstElementChild.setAttribute("src", imgsrc)
            MainItemUrls[i].nextElementSibling.innerHTML = `
                    <h5>${result[i].title}</h5>
                    <p>Artist:${result[i].artist}</p>
                    <p>Price:${result[i].price}</p>
                    <p>visited:${result[i].visit} times</p>

            `
        }
    } else {
        sendNotice(".notice", "Network error")
    }
})();