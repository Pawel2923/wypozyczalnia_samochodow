const viewMode = document.querySelector('select[name="view-mode"]');
viewMode.addEventListener("change", () => {
  viewMode.form.submit();
});

const changeView = (mode) => {
  document
    .querySelector('main select option[value="' + mode + '"]')
    .setAttribute("selected", "selected");
  if (mode == "list")
    document.querySelector(".cars").classList.add("cars-list");
};

const mode = document
  .querySelector("script[src='js/viewMode.js']")
  .getAttribute("value");

changeView(mode);
