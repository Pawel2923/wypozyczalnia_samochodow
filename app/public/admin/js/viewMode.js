const viewMode = document.querySelector('select[name="view-mode"]');
viewMode.addEventListener("change", () => {
  viewMode.form.submit();
});

const changeView = (mode) => {
  document
    .querySelector('main select option[value="' + mode + '"]')
    .setAttribute("selected", "selected");

  if (mode === "list") {
    document.querySelector(".cars").classList.add("cars-list");
  }

  if (mode === "table") {
    document.querySelector(".cars").classList.remove("cars");
  }
};
