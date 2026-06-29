<!DOCTYPE html>
<html>
 
<head>
<title>Imoral</title>
    <link rel="icon" type="image/png" href="/assets/images/imoral_icon1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
 
<body>
    <nav id="home" class="navbar navbar-expand-lg navbar-dark bg-black py-3">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="/home">
                <img src="/assets/images/imoral_logo1_transp.png"
                alt="imoral_logo" 
                width="100" 
                style="height:30px; object-fit:cover;"
                class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Links de navegação -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="navbar-brand" href="/home">Home</a>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link" href="/pagina_em_construção">Customization</a>
                    </li>
                    -->
                    <li class="nav-item">
                        <a class="nav-link" href="/home#sobre">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <?php if (AuthMiddlewareWeb::isLogin()): ?>
                            <a class="nav-link" href="/users/<?= $_SESSION['token']['id']; ?>">
                                <img src="/<?= htmlspecialchars($_SESSION['token']['image'] ?: 'assets/images/users/user_icon.png') ?>"
                                alt="user_avatar" 
                                width="40" 
                                style="height:30px; object-fit:cover;"
                                class="d-inline-block align-text-top">
                            </a>
                        <?php else: ?>
                            <a class="nav-link" href="/login">
                                <img src="assets/images/users/user_icon.png"
                                alt="user_avatar" 
                                width="40" 
                                style="height:30px; object-fit:cover;"
                                class="d-inline-block align-text-top">
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>