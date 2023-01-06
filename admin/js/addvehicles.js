document.querySelector(".img-check").style.display = "block";
document.querySelector(".uploaded-wrapper").style.display = "block";
document.forms.vehicleImg.style.display = "none";

document
  .querySelector(".uploaded-wrapper > button")
  .addEventListener("click", () => {
    window.location.pathname = window.location.pathname.replace(
      "/addvehicles.php",
      "/deleteimg.php"
    );
  });
