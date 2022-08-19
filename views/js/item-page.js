highlightSelected("nav .__items")
window.addEventListener("scroll", ()=>{
    showBackground(1)
});
//


async function showAll() {
    try {
        let response = await fetch('../controllers/search.php');
        return await response.json();
    } catch (error) {
        console.log('Request failed', error);
    }
}
const picFrames=document.querySelectorAll(".items>article>figure");


(async function(){
    let response=await showAll();
    let result=await response.result
    for (const item of result){
        console.log(item)
    }
    for(let i=0;i<picFrames.length&&i<result.length;i++){
        let src="../img/"+result[i].filename;
        console.log(src)
        console.log(picFrames[i].firstElementChild)
        picFrames[i].firstElementChild.setAttribute("src",src)
    }

})();