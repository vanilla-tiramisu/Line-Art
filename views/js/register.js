submitForm('form', 'form button[value=submit]', '../controllers/Register.php', '.notice', "index.html")

const Username = document.forms[0].elements["username"];
Username.addEventListener('keypress', (event) => {
    if (/[^\w-]+/.test(String.fromCharCode(event.charCode))) {
        event.preventDefault()
    }
})

Username.addEventListener('paste', (event) => {
    let text = event.clipboardData.getData("text")
    if (/[^\w-]+/.test(text)) {
        event.preventDefault()
    }
})

Username.addEventListener('blur', async (event) => {
    let msg = event.target.nextElementSibling
    //event.target就是被操作的元素本身
    let validType = event.target.validity
    msg.classList.add("--fail")

    if (validType.valueMissing) {
        msg.innerHTML = "Please fill in the blank!";
    } else if (validType.patternMismatch) {
        msg.innerHTML = "only letters, numbers, \"_\" and \"-\" are allowed!"
    } else if (validType.tooLong) {
        msg.innerHTML = "Username should be less than 17 characters!"
    } else {
        //查询后端数据库里有没有相同名称
        let result = await searchFromDb('../controllers/searchUsername.php', event.target.value, 'username')
        // console.log(result)
        if (result.status === "success") {
            msg.classList.remove("--fail")
            msg.innerHTML = result.msg
            event.target.setCustomValidity('')
        } else {
            msg.classList.add("--fail")
            msg.innerHTML = result.msg
            event.target.setCustomValidity(result.msg)
        }
    }
})
//Password
const Password = document.forms[0].elements["password"];
Password.addEventListener('keypress', (event) => {
    if (/[^\w.-]+/.test(String.fromCharCode(event.charCode))) {
        event.preventDefault()
    }
})

Password.addEventListener('paste', (event) => {
    let text = event.clipboardData.getData("text")
    if (/[^\w.-]+/.test(text)) {
        event.preventDefault()
    }
})

Password.addEventListener('blur', (event) => {
        let input = event.target
        let msg = input.nextElementSibling
        let validType = event.target.validity
        msg.classList.add("--fail")
        if (validType.valueMissing) {
            msg.innerHTML = "Please fill in the blank!";
        } else if (validType.patternMismatch) {
            msg.innerHTML = "only letters, numbers, \"_\", \"-\" and \".\" are allowed!"
        } else if (validType.tooShort || validType.tooLong) {
            msg.innerHTML = "Password should be 6-20 characters!"
        } else if (!(/\D+/.test(input.value))) {//all numbers
            msg.innerHTML = "Pure number serials are not allowed!"
        } else if (!(/\D+/.test(input.value))) {//all numbers
            msg.innerHTML = "Pure number serials are not allowed!"
            input.setCustomValidity("Pure number serials are not allowed!")
            msg.classList.add("--fail")
        } else {
            msg.innerHTML = "OK";
            input.setCustomValidity("")
            msg.classList.remove("--fail")

        }
    }
)
//confirmed password
const Confirm = document.forms[0].elements["confirmed-password"];
Confirm.addEventListener('keypress', (event) => {
    if (/[^\w.-]+/.test(String.fromCharCode(event.charCode))) {
        event.preventDefault()
    }
})

Confirm.addEventListener('paste', (event) => {
    let text = event.clipboardData.getData("text")
    if (/[^\w.-]+/.test(text)) {
        event.preventDefault()
    }
})

Confirm.addEventListener('blur', (event) => {
        let input = event.target
        let msg = input.nextElementSibling
        msg.classList.add("--fail")
        if (input.validity.valueMissing) {
            msg.innerHTML = "Please fill in the blank!";
        } else if (input.value !== Password.value) {//all numbers
            msg.innerHTML = "Please give same inputs!"
            input.setCustomValidity("Please give same inputs!")
            msg.classList.add("--fail")
        } else {
            msg.innerHTML = "OK";
            input.setCustomValidity("")
            msg.classList.remove("--fail")
        }
    }
)
//email
const Email = document.forms[0].elements["email"];
Email.addEventListener('blur', async (event) => {
    let msg = event.target.nextElementSibling
    let validType = event.target.validity
    msg.classList.add("--fail")

    if (validType.valueMissing) {
        msg.innerHTML = "Please fill in the blank!";
    } else if (validType.patternMismatch || validType.tooLong) {
        msg.innerHTML = "Please enter an available email!"
    } else {
        //查询后端数据库里有没有相同名称
        let result = await searchFromDb('../controllers/searchEmail.php', event.target.value, 'email')
        // console.log(result)
        if (result.status === "success") {
            msg.classList.remove("--fail")
            msg.innerHTML = result.msg
            event.target.setCustomValidity('')
        } else {
            msg.classList.add("--fail")
            msg.innerHTML = result.msg
            event.target.setCustomValidity(result.msg)
        }
    }
})
//phone
const Phone = document.forms[0].elements["phone"];
Phone.addEventListener('keypress', (event) => {
    if (/[^\d]+/.test(String.fromCharCode(event.charCode))) {
        event.preventDefault()
    }
})

Phone.addEventListener('paste', (event) => {
    let text = event.clipboardData.getData("text")
    if (/[^\d]+/.test(text)) {
        event.preventDefault()
    }
})

Phone.addEventListener('blur', (event) => {
        let input = event.target
        let msg = input.nextElementSibling
        let validType = event.target.validity
        msg.classList.add("--fail")
        if (validType.valueMissing) {
            msg.innerHTML = "Please fill in the blank!";
        } else if (!validType.valid) {
            msg.innerHTML = "Please enter an available phone number!"
        } else {
            msg.innerHTML = "OK";
            input.setCustomValidity("")
            msg.classList.remove("--fail")

        }
    }
)
//address
const Address = document.forms[0].elements["address"];
Address.addEventListener('blur', (event) => {
        let input = event.target
        let msg = input.nextElementSibling
        msg.classList.add("--fail")
        if (event.target.validity.valueMissing) {
            msg.innerHTML = "Please fill in the blank!";
        } else {
            msg.innerHTML = "OK";
            input.setCustomValidity("")
            msg.classList.remove("--fail")

        }
    }
)