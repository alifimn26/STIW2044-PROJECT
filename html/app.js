const menu = document.querySelector('#mobile-menu');
const menuLinks = document.querySelector('.navbar__menu');

menu.addEventListener('click', function() {
  menu.classList.toggle('is-active');
  menuLinks.classList.toggle('active');
});

function validateform() {
  var tel = document.getElementById("phonenum").value;
  if (tel.length < 10) {
    alert("Phone number must be of at least 10 digits!");
    return false;
  } else if (isNaN(tel)) {
    alert("Phone number should not include characters!");
    return false;
  }
  return true;
}
