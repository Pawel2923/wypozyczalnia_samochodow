const selectTheme = (mode) => {
  document
    .querySelector('main select option[value="' + mode + '"]')
    .setAttribute("selected", "selected");
};

const mode = document.querySelector("script[src='js/theme.js']").getAttribute("value");

selectTheme(mode);
