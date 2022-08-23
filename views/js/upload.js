//修改or上传
let Update = false
let Url = "../controllers/upload.php"
if (response.msg !== 'new item') {
    //判断是否有权限。
    try {
        (async function () {
            let UserResponse = await getUsername()
            let CurrentUser = UserResponse.msg
            if (CurrentUser === response.msg.user) {
                //有权限，则填入已有信息。
                Update = true
                Url="../controllers/update.php?id="+response.msg.id;
                document.querySelector(".upload .__pic").innerHTML =
                `<img src=../img/${response.msg.filename} alt="${response.msg.filename}">`;
                document.querySelector(".upload h1").innerHTML = "UPDATE";
                document.querySelector(".upload input[name=title]").value = response.msg.title;
                document.querySelector(".upload input[name=artist]").value = response.msg.artist;
                document.querySelector(".upload input[name=genre]").value = response.msg.genre;
                let real_num=Number(response.msg.create_date)
                if (real_num<0){
                    document.querySelector(".upload input[name=creation]").value = 0-real_num;
                    document.querySelector(".upload input[name=BC]").setAttribute('checked','true')
                }else if (real_num===9999){
                    document.querySelector(".upload input[name=creation]").value = '';
                }
                else {
                    document.querySelector(".upload input[name=creation]").value = real_num
                }
                document.querySelector(".upload input[name=height]").value = response.msg.height;
                document.querySelector(".upload input[name=width]").value = response.msg.width;
                if(response.msg.length_unit==='px') {
                    document.querySelector(".upload select[name=unit]").innerHTML=`<option value="cm">cm</option>
                <option value="px" selected>px</option>`
                }
                document.querySelector(".upload input[name=price]").value = response.msg.price;
                document.querySelector(".upload textarea[name=description]").value = response.msg.description;
                document.querySelector(".upload button[value=submit]").innerHTML = "save";

            } else {
                sendNotice(".notice", "Sorry, you don't have the access right to this page")
            }
        })();
    } catch (e) {
        sendNotice(".notice", "Oops! Something went wrong...")
    }

}
//
const FileInput = document.querySelector("input[type=file]")
const Preview = document.querySelector("label[for=picfile]>img")
FileInput.addEventListener('change', updateImageDisplay)

function updateImageDisplay() {
    const curFiles = FileInput.files
    Preview.setAttribute("src", URL.createObjectURL(curFiles[0]))
}

//submit the form
const Button = document.querySelector('form.upload button[value=submit]');
const Form = document.querySelector('.upload')
Button.addEventListener('click', async () => {
    const noticeQuery = '.notice'
    if (Form.checkValidity()) {
        //如果通过，发送表单。
        try {
            let response = await fetch(Url,
                {
                    method: 'POST',
                    body: new FormData(Form),
                });
            let r = await response.json()
            sendNotice(noticeQuery, r.msg)
            if (r.status === "success") {
                setTimeout(() => {
                    window.location = "detail.php?id=" + r.id
                }, 1000);
            }
        } catch (error) {
            sendNotice(noticeQuery, "Request failed")
        }
    } else {
        sendNotice(noticeQuery, "Failed to pass validity check, please follow the instructions!")
    }
})


//
;(async function () {
    if (document.cookie) {
        let result = await getSession()
        if (result.logged === true) {
            return
        }
    }
    sendNotice('.notice', "Please log in to upload your file. ")
    setTimeout(() => {
        window.location = "index.html"
    }, 1000)
})();

highlightSelected("nav .__upload")
window.addEventListener("scroll", () => {
    showBackground(1)
})