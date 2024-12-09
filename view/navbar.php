<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../images/icons/logoBlackOutline.png" alt="Meal Fusion Logo" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                <a class="nav-link" href="submit.php">Submit</a>
                <a class="nav-link" href="contact.php">Contact</a>
                <a class="nav-link hideAdmin" id="admin" href="adminHome.php">Admin</a>
                <a class="nav-link showLogin" id="login" data-bs-toggle="offcanvas" href="#offcanvasLogin">Login</a>
                <a class="nav-link hideLogout" id="logout" onclick="logout()">Logout</a>
            </div>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasLogin">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <form method="post" id="loginForm">
        <div class="offcanvas-body">
            <div class="errorMessage">
            </div>
            <div class="form-floating">
                    <input type="text" class="form-control" id="inUsername" name="inUsername" placeholder="Username">
                    <label for="inUsername">Username</label>
            </div>
            <br>
            <div class="form-floating">
                    <input type="password" class="form-control" id="inPassword" name="inPassword" placeholder="Password">
                    <label for="inPassword">Password</label>
            </div>
            <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
        </div>
    </form>
</div>