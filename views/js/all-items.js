highlightSelected("nav .__items")
window.addEventListener("scroll", ()=>{
    showBackground(1)
});
//
let style='byVisit'
//byVisit, byName, byPrice
let page=1
let keyword=''
let range='title'
let SearchParams=new URLSearchParams(location.search)
if (SearchParams.has("keyword")){
    keyword=SearchParams.get("keyword")
}
if (SearchParams.has("range")){
    range=SearchParams.get("range")
}
if (keyword!=='') {
    document.querySelector("main.items>h2").innerHTML=
        `You searched '${keyword}' from ${range}s.`
}

async function showResults() {
    try {
        let response = await fetch('../controllers/search.php?'+
            `style=${style}&page=${page}&keyword=${keyword}&range=${range}`);
        return await response.json();
    } catch (error) {
        console.log('Request failed', error);
    }
}
const picFrames=document.querySelectorAll(".items>article>a");

async function updateItems(response){
    if(await response){
        let result=await response.result
        if (result.length===0){
            document.querySelector("main.items>h2").nextElementSibling.innerHTML=
                "No result found. Maybe you can choose another keyword?"
            document.querySelector("main.items>.pager").remove()
        }
        for (const item of result){
            console.log(item)
        }
        for(let i=0;i<picFrames.length&&i<result.length;i++){
            let imgsrc="../img/"+result[i].filename;
            console.log(imgsrc)
            picFrames[i].setAttribute("href","detail.php?id="+result[i].id)
            let img=picFrames[i].firstElementChild.firstElementChild
            img.setAttribute("src",imgsrc)
            let detail=img.nextElementSibling
            detail.innerHTML=`<h5>${result[i].title}</h5>
                    <p>Artist:${result[i].artist}</p>
                    <p>Price:${result[i].price}</p>
                    <p>Visit:${result[i].visit}</p>
                    <br>
                    <p>${result[i].description}</p>`
        }
        for(let i=picFrames.length-1;i>=0&&i>=result.length;i--){
            picFrames[i].remove()
        }
    }else{
        sendNotice(".notice","Network error")
    }
}

document.addEventListener('DOMContentLoaded',async () => {
    await updateItems(await showResults())
})

const SelectBox=document.querySelector("main.items>label[for=style]>select")
SelectBox.addEventListener('change',async () => {
    style = SelectBox.value
    await updateItems(await showResults())
})