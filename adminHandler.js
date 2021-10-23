const mainButtons = document.querySelectorAll('main .option-button');

const settings = document.querySelectorAll('.all-settings>div');
for (let i=0; i<settings.length;i++) {
    settings[i].style.display = "none";
}
settings[0].classList.add('visible-settings');
settings[0].style.display = "block";

const changeSettings = (open) => {
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

const openMobileNav = () => {
    document.querySelector('nav.panel').style.transform = "translateX(0)";
    document.querySelector('.mobile-nav .overlay').style.display = "block";
    setTimeout(() => {                
        document.querySelector('.mobile-nav .overlay').style.opacity = 1;
    }, 2);
};

const closeMobileNav = () => {
    document.querySelector('nav.panel').style.transform = "translateX(-100%)";
    document.querySelector('.mobile-nav .overlay').style.opacity = 0;
    setTimeout(() => {                
        document.querySelector('.mobile-nav .overlay').style.display = "none";
    }, 200);
};

document.querySelector('nav.panel .veh-link').addEventListener('click', () => {
    changeSettings(1);
    if (window.innerWidth < 800) {
        closeMobileNav();
    }
});
document.querySelector('nav.panel .users-link').addEventListener('click', () => {
    changeSettings(2);
    if (window.innerWidth < 800) {
        closeMobileNav();
    }
});
document.querySelector('nav.panel .settings-link').addEventListener('click', () => {
    changeSettings(3);
    if (window.innerWidth < 800) {
        closeMobileNav();
    }
});

const homeSettings = () => {
    document.querySelector('.home .manage-veh').addEventListener('click', () => {
        changeSettings(1);
        window.location.hash = '#vehicles';
    });
    document.querySelector('.home .manage-users').addEventListener('click', () => {
        changeSettings(2);
        window.location.hash = '#users';
    });
    document.querySelector('.home .manage-settings').addEventListener('click', () => {
        changeSettings(3);
        window.location.hash = '#settings';
    });
};

if (window.location.hash == '#vehicles') {
    changeSettings(1);
}
if (window.location.hash == '#users') {
    changeSettings(2);
}
if (window.location.hash == '#settings') {
    changeSettings(3);
}

document.querySelector('.mobile-nav .open').addEventListener('click', () => {
    openMobileNav();
});
document.querySelector('.mobile-nav .overlay').addEventListener('click', () => {
    closeMobileNav();
});

window.addEventListener('resize', () => {
    if (window.innerWidth > 800) 
        document.querySelector('nav.panel').style.transform = "translateX(0)";
    else 
        closeMobileNav();
});

if (window.location.pathname.indexOf('admin.php') > -1)
    homeSettings();