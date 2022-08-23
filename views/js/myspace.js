//
;(async function () {
    if (document.cookie) {
        let result = await getSession()
        if (result.logged === true) {
            return
        }
    }
    sendNotice('.notice', "Please log in to visit myspace. ")
    setTimeout(() => {
        window.location = "index.html"
    }, 1000)
})();

window.addEventListener("scroll", () => {
    showBackground(1)
})