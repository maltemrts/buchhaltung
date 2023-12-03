/* JavaScript-Funktionen für das Pop-up-Fenster */
function openPopup(formType) {
    document.querySelector('.popup-windows-container').style.display = 'block';
    if (formType === 'login') {
        document.getElementById('loginForm').style.display = 'block';
        document.getElementById('registerForm').style.display = 'none';
    } else if (formType === 'register') {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'block';
    }
}


function redirectToRegistration() {
        // Hier wird zur Registrierungsseite weitergeleitet
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'block';
    }
function redirectToLogin() {
        // Hier wird zur Registrierungsseite weitergeleitet
        document.getElementById('loginForm').style.display = 'block';
        document.getElementById('registerForm').style.display = 'none';
    }
function Logout(){
    window.location.href = "Homepage.html";
    alert("Sie werden abgemeldet");
}