let keyword=''
let range='Title'
// 先给回车和点击绑定事件：这样的时候，执行函数，把参数投喂给items.html
const SearchInput=document.querySelector(".search-box input")
const SearchButton=document.querySelector(".search-box button")

SearchInput.addEventListener('keydown',(event)=>{
    if (event.keyCode===13){
        event.preventDefault()
        openSearchWindow()
    }
})

SearchButton.addEventListener('click',openSearchWindow)
function openSearchWindow() {
    keyword=SearchInput.value
    range=SearchInput.nextElementSibling.value
    SearchInput.value=''
    window.open("items.html?keyword="+keyword+"&range="+range)
}

highlightSelected("nav .__search")

