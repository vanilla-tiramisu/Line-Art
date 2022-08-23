/**
 * @param {string} formQuery querySelector for the form
 * @param {string} buttonQuery querySelector for submit button
 * @param {string} url the place to send the data to
 * @param {string} noticeQuery querySelector for the notice bar
 * @param {string} jump the url to jump to; empty value indicates reloading
 */
function submitForm(formQuery, buttonQuery, url, noticeQuery, jump) {
    const SUBMIT_BUTTON = document.querySelector(buttonQuery)
    SUBMIT_BUTTON.addEventListener('click', submit)
    const FORM = document.querySelector(formQuery)

    async function submit() {
        if (FORM.checkValidity()) {
            //如果通过，发送表单。
            let serialized = serialize(document.querySelector(formQuery))
            let jsonHeaders = new Headers({
                'Content-Type': 'application/json'
            });
            try {
                let response = await fetch(url,
                    {
                        method: 'POST',
                        body: serialized,
                        headers: jsonHeaders
                    });
                let r = await response.json()
                sendNotice(noticeQuery,r.msg)
                if (r.status === "success") {
                    setTimeout(() => {
                        window.location.href = jump
                        if (jump===''){
                            location.reload()
                        }
                    }, 1000);
                }
            } catch (error) {
                sendNotice(noticeQuery,"Request failed")
            }
        } else {
            sendNotice(noticeQuery,"Failed to pass validity check, please follow the instructions!")
        }
    }

}

/**
 *
 * @param noticeQuery
 * @param content
 */
function sendNotice(noticeQuery,content){
    let NOTICE = document.querySelector(noticeQuery)
    NOTICE.innerHTML = content
    NOTICE.classList.add('--display')
    setTimeout(() => {
        NOTICE.classList.remove('--display');
    }, 2000);
}
function serialize(form) {
    let parts = [];
    let optValue;
    for (let field of form.elements) {
        switch (field.type) {
            case "select-one":
            case "select-multiple":
                if (field.name.length) {
                    for (let option of field.options) {
                        if (option.selected) {
                            if (option.hasAttribute) {//only to see if the function exists
                                optValue = (option.hasAttribute("value") ?
                                    option.value : option.text)
                            } else {
                                optValue = (option.attributes["value"].specified ?
                                    option.value : option.text)
                            }
                            parts.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(optValue))
                        }
                    }
                }
                break;
            case undefined:
            case "file":
            case "submit":
            case "reset":
            case "button":
                break;
            case "radio":
            case "checkbox":
                if (!field.checked) {
                    break;
                }
            default:
                if (field.name.length) {
                    parts.push(`${encodeURIComponent(field.name)}=` + `${encodeURIComponent(field.value)}`)
                }
        }
    }
    return parts.join("&")
}

/**
 * @param {string} url the place to send the data to
 * @param {string} text content(get)
 * @param {string} type content name in db
 *
 */
async function searchFromDb(url, text, type) {
    try {
        let response = await fetch(url + `?${type}=${text}`);
        return await response.json()
    } catch (error) {
        console.log('Request failed', error);
    }
}