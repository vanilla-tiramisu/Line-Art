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

window.addEventListener("resize", ()=>{
    if (window.innerWidth>=900&&MENU.classList.contains("--display")){
        toggleMenu()
    }
})

const NAV=document.querySelector('nav')
function showBackground(distance){
    let scrollPos=document.documentElement.scrollTop
    if(scrollPos>distance){
        NAV.classList.add("--background")
    }else if(scrollPos<=distance){
        NAV.classList.remove("--background")
    }
}


//page effect
function highlightSelected(query) {
    let selected=document.querySelector(query)
    selected.classList.add("--selected")
}

submitForm('form[name=login]', 'form[name=login] input[name=submit]', '../controllers/login.php', '.notice', "")
//login
//dialog boxes
const DIALOG_LOGIN = document.querySelector('.dialog-wrapper')
const LOGIN_CLOSE = document.querySelector('.dialog .__close')
const LOGIN = document.querySelector('nav .__login')
LOGIN_CLOSE.addEventListener('click', (() => {
        DIALOG_LOGIN.classList.remove('--display')
    })
)
LOGIN.addEventListener('click', (() => {
    DIALOG_LOGIN.classList.add('--display')
}))

//after login
const REGISTER = document.querySelector('nav .__register')
function hideAfterLogin() {
    LOGIN.remove()
    REGISTER.remove()
}
function hideBeforeLogin() {
    document.querySelector('nav .__cart').remove()
    document.querySelector('nav .__upload').remove()
    document.querySelector('nav .__self').remove()
    document.querySelector('nav .__logout').remove()
}
(async function () {
    if (document.cookie) {
        let result = await getSession()
        if (result.logged === true) {
            console.log("Welcome!")
            hideAfterLogin()
            //实现logout功能
            const LOGOUT=document.querySelector('nav .__logout')
            LOGOUT.onclick=clearSession
            return
        }
    }
    hideBeforeLogin()

})();
