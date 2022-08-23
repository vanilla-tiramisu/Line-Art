async function getSession() {
    try {
        let response = await fetch('../controllers/sessionControl.php');
        return await response.json()
    } catch (error) {
        console.log('Request failed', error);
    }
}

async function clearSession() {
    try {
        let response = await fetch('../controllers/logout.php');
        // return await response.json()
    } catch (error) {
        console.log('Request failed', error);
    }
    location.reload()
}

async function getUsername() {
    try {
        let response = await fetch('../controllers/getUsername.php');
        return await response.json()
    } catch (error) {
        console.log('Request failed', error);
    }
}