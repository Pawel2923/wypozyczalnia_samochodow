const movePlaceholder = (name) => {
    if (document.querySelector(`input[name="${name}"]`) != null) {
        if (document.querySelector(`input[name="${name}"`).value != '')
            document.querySelector(`.${name} label`).classList.remove('form-label-transform-start');
        else 
            document.querySelector(`.${name} label`).classList.add('form-label-transform-start');

        document.querySelector(`form input[name="${name}"]`).addEventListener('focus',() => {
            document.querySelector(`.${name} label`).classList.add('form-label-transform');
        });
        document.querySelector(`form input[name="${name}"]`).addEventListener('focusout',() => {
            if (document.querySelector(`input[name="${name}"`).value == 0) {
                document.querySelector(`.${name} label`).classList.remove('form-label-transform');
                document.querySelector(`.${name} label`).classList.add('form-label-transform-end');
            }
        });
    }
};

window.onload = () => {
    movePlaceholder('login');
    movePlaceholder('password');
    movePlaceholder('password-confirm');
};

const passwdCheck = () => {
    const passwd = document.querySelector('form input[name="password"]');
    const passwdConfirm = document.querySelector('form input[name="password-confirm"]');

    if (passwd != null) {
        passwd.addEventListener('invalid', () => {
            (passwd.value.length < 4) ? passwd.setCustomValidity("Hasło powinno mieć przynajmniej 4 znaki") : passwd.setCustomValidity("");
        });
        
        passwd.addEventListener('valid', () => {
            passwd.setCustomValidity("");
        });
    
        if (passwdConfirm != null) {
            passwdConfirm.addEventListener('keyup', () => {
                if (passwd.value != passwdConfirm.value) {
                    passwd.setCustomValidity("Hasła nie są zgodne");
                    passwdConfirm.setCustomValidity("Hasła nie są zgodne");
                }
                else {
                    passwd.setCustomValidity("");
                    passwdConfirm.setCustomValidity("");
                }
            });
        }
    }
}

const checkInput = (name) => {
    if (name != null) {
        name.addEventListener('invalid', () => {
            name.classList.add('subscription-input-invalid2');
        });
        name.addEventListener('keyup', () => {
            name.classList.remove('subscription-input-invalid2');
        });
    }
};
checkInput(document.querySelector('form input[name="login"]'));
checkInput(document.querySelector('form input[name="password"]'));
checkInput(document.querySelector('form input[name="password-confirm"]'));