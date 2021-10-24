<nav class="mobile-nav">
    <div class="open"><i class="fas fa-bars"></i></div>
    <div class="nav-wrapper">
        <div class="top-content">
            <div></div>
            <div class="close"><i class="fas fa-times"></i></div>
            <div class="user">
                <a href="login.php" class="login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="login-caption">Zaloguj się</span>
                </a>
                <a href="admin.php" class="logged">
                    <i class="fas fa-user"></i>
                    <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                </a>
            </div>
        </div>
        <div class="list-wrapper">
            <ul>
                <a href="index.php"><li>Strona główna</li></a>
                <a href="rezerwacja.php"><li>Rezerwacja online</li></a>
                <a href="wycena.php"><li>Uzyskaj wycenę</li></a>
                <a href="vehicles.php"><li>Nasze pojazdy</li></a>
                <a href="contact.php"><li>Kontakt</li></a>
            </ul>
        </div>
    </div>
</nav>
<nav class="desktop-nav">
    <div class="nav-header">
        <a href="index.php"><h2>Wypożyczalnia</h2></a>
    </div>
    <div class="list-wrapper">
        <div class="spacer"></div>
        <ul>
            <a href="index.php"><li>Strona główna</li></a>
            <a href="rezerwacja.php"><li>Rezerwacja online</li></a>
            <a href="wycena.php"><li>Uzyskaj wycenę</li></a>
            <a href="vehicles.php"><li>Nasze pojazdy</li></a>
            <a href="contact.php"><li>Kontakt</li></a>
        </ul>
        <div class="user">
            <a href="login.php" class="login">
                <i class="fas fa-sign-in-alt"></i>
                <span class="login-caption">Zaloguj się</span>
            </a>
            <a href="admin.php" class="logged">
                <i class="fas fa-user"></i>
                <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
            </a>
        </div>
    </div>
</nav>
<nav class="desktop-nav fixed-nav">
    <div class="list-wrapper">
        <div class="spacer"></div>
        <ul>
            <a href="index.php"><li>Strona główna</li></a>
            <a href="rezerwacja.php"><li>Rezerwacja online</li></a>
            <a href="wycena.php"><li>Uzyskaj wycenę</li></a>
            <a href="vehicles.php"><li>Nasze pojazdy</li></a>
            <a href="contact.php"><li>Kontakt</li></a>
        </ul>
        <div class="user">
            <a href="login.php" class="login">
                <i class="fas fa-sign-in-alt"></i>
                <span class="login-caption">Zaloguj się</span>
            </a>
            <a href="admin.php" class="logged">
                <i class="fas fa-user"></i>
                <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
            </a>
        </div>
    </div>
</nav>
<script>
    window.addEventListener('resize', () => {
        const nav = document.querySelectorAll('.desktop-nav');
        const navHeight = nav.innerHeight;
    });
    const nav = document.querySelectorAll('.desktop-nav');
    const navHeight = nav.innerHeight;
    if (window.innerWidth > 800) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > navHeight) {
                document.querySelector('.fixed-nav').style.transform = "translateY(0)";
            }
            else {
                document.querySelector('.fixed-nav').style.transform = "translateY(-100%)";
            }
        });
    }
</script>