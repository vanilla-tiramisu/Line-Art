//
highlightSelected("nav .__items")
window.addEventListener("scroll", () => {
    showBackground(1)
});
//
const Content = document.querySelector("main.detail")
console.log(response);

if (response.status === 'fail') {
    Content.innerHTML = "<section class=--full-height>" +
        "<h2 style='font-size: 1.5em'>" +
        "Oops! Something went wrong..." +
        "<br>" +
        "So take a break with the little duck :)" +
        "</h2>" +
        "<img src=../shared/img/6.gif alt=duck style='margin: 20% auto;display: block'>" +
        "</section>";

} else {
    const Img = document.querySelector("main.detail>.__img-wrapper>img")
    let msg = response.msg
    {
        if (msg.create_date === '9999') {
            msg.create_date = 'unknown'
        }
        if (msg.height === '0.00' || msg.width === '0.00') {
            msg.height = 'unknown';
            msg.width = 'unknown';
            msg.length_unit = ''
        }
    }
    {
        let imgSrc = "../img/" + msg.filename
        Img.setAttribute("src", imgSrc)
        const Price = document.querySelector("main.detail>.__price>.__value")
        Price.innerHTML = msg.price
        const Title = document.querySelector("main.detail>h2")
        const TitleAttr = document.querySelector(".detail__attr>.__title>.__value")
        Title.innerHTML = msg.title
        TitleAttr.innerHTML = msg.title
        document.title = msg.title + " - Line Art"
        const Artist = document.querySelector(".detail__attr>.__artist>.__value")
        Artist.innerHTML = msg.artist
        const Creation = document.querySelector(".detail__attr>.__create>.__value")
        Creation.innerHTML = msg.create_date
        const Height = document.querySelector(".detail__attr>.__height>.__value")
        Height.innerHTML = msg.height
        const HeightUnit = document.querySelector(".detail__attr>.__height>.__unit")
        HeightUnit.innerHTML = msg.length_unit
        const Width = document.querySelector(".detail__attr>.__width>.__value")
        Width.innerHTML = msg.width
        const WidthUnit = document.querySelector(".detail__attr>.__width>.__unit")
        WidthUnit.innerHTML = msg.length_unit
        const Genre = document.querySelector(".detail__attr>.__genre>.__value")
        Genre.innerHTML = msg.genre
        const Release = document.querySelector(".detail__attr>.__release>.__value")
        Release.innerHTML = msg.release_date
        const User = document.querySelector(".detail__attr>.__user>.__value")
        User.innerHTML = msg.user
        const Visit = document.querySelector(".detail__attr>.__visit>.__value")
        Visit.innerHTML = msg.visit
        const Description = document.querySelector(".detail__description")
        Description.innerHTML = msg.description;


    }
    //TODO:是自己发布的且尚未卖出，则将购买键换成编辑键。
    (async function () {
        let response = await getUsername()
        let CurrentUser = response.msg
        const FirstButton = document.querySelector(".detail__attr>button.--cart")
        const SecondButton = document.querySelector(".detail__attr>button.--buy")

        if (CurrentUser === msg.user && msg.sold === '0') {
            console.log("Your item & not sold")
            //给上下两个按钮添加监听器
            FirstButton.classList.remove("--cart");
            FirstButton.innerHTML='Edit'
            FirstButton.addEventListener('click',()=>{
                window.location = "upload.php?id="+msg.id
            })
            SecondButton.classList.remove("--buy","--success");
            SecondButton.innerHTML='Delete'
            SecondButton.addEventListener('click',()=>{
                //TODO: delete
                console.log("Deleted")
            })
        } else {
            //给上下两个按钮添加监听器
            FirstButton.addEventListener('click',()=>{
                //TODO: add to cart
                console.log("Added to cart")
            })
            SecondButton.addEventListener('click',()=>{
                //TODO: buy the item
                console.log("Buy it")
            })


        }
    })();
}