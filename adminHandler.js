const optionContent = document.querySelectorAll('main .option-content');
const mainButtons = document.querySelectorAll('main .option-button');

const optionOpen = (open) => {
    optionContent[open].style.display = "block";
    optionContent[open].classList.add('visible-settings');
    let icon = '.' + mainButtons[open].classList[1] + ' .icon';
    document.querySelector(icon).style.transform = 'rotate(90deg)';
};

const optionClose = (close) => {
    optionContent[close].classList.remove('visible-settings');
    let icon = '.' + mainButtons[close].classList[1] + ' .icon';
    document.querySelector(icon).style.transform = 'rotate(0)';
    optionContent[close].style.display = 'none';
}

for (let i=0; i<mainButtons.length; i++) {
    mainButtons[i].addEventListener('click', () => {
        optionOpen(i);
    });
}
const settings = document.querySelectorAll('.all-settings>div');
for (let i=0; i<settings.length;i++) {
    settings[i].style.display = "none";
}
settings[0].classList.add('visible-settings');
settings[0].style.display = "block";

const changeSettings = (open) => {
    for (let i=0; i<optionContent.length; i++) {
        optionClose(i);
    }

    let close = 0;
    for (let i=0; i<settings.length; i++) {
        if (settings[i].className.indexOf('visible-settings') > -1)
            close = i;
    }

    if (open != close) {
        document.querySelector('body').style.overflow = "hidden";

        settings[close].classList.remove('visible-settings');
        setTimeout(() => {
            settings[close].style.display = "none";
        }, 200);
        
        settings[open].style.display = "block";
        setTimeout(() => {
            settings[open].classList.add('visible-settings');
            document.querySelector('body').style.overflow = "initial";
        }, 200);
    }
};

document.querySelector('nav.desktop-panel .veh-link').addEventListener('click', () => {
    changeSettings(0);
});
document.querySelector('nav.desktop-panel .users-link').addEventListener('click', () => {
    changeSettings(1);
});
document.querySelector('nav.desktop-panel .settings-link').addEventListener('click', () => {
    changeSettings(2);
});