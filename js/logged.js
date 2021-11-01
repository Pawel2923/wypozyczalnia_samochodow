const loginLink = document.querySelectorAll('.login');
const loggedLink = document.querySelectorAll('.logged');
for (let i=0; i<loginLink.length; i++) {
    loginLink[i].style.display = 'none';
}
for (let i=0; i<loggedLink.length; i++) {
    loggedLink[i].style.display = 'block';
}