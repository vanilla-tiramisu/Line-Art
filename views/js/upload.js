(async function () {
    if (document.cookie) {
        let result = await getSession()
        if (result.logged === true) {
            return
        }
    }
    sendNotice('.notice',"Please log in to upload your file. ")
    setTimeout(()=>{
        window.location="index.html"
    },1000)
})();

//
highlightSelected("nav .__upload")
window.addEventListener("scroll", ()=>{
    showBackground(1)
})