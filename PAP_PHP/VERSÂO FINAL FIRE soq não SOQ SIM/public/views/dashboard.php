<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imoral - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script src="models/Utilizador.js" defer></script>
    <script src="models/Produto.js" defer></script>
    <script src="models/Post.js" defer></script>
    <script>
    function navegarPara(id) {
        document.querySelectorAll('.menu-item').forEach(function(l) {
            l.classList.remove('active');
        });
        event.currentTarget.classList.add('active');

        document.querySelectorAll('#mainTabContent > .tab-pane').forEach(function(pane) {
            pane.classList.remove('show', 'active');
        });

        var pane = document.getElementById(id);
        if (pane) {
            pane.classList.add('show', 'active');
        }
    }

    function mudarTab(btnClicado, targetId) {
        var tabList = btnClicado.closest('[role="tablist"]');
        if (tabList) {
            tabList.querySelectorAll('button').forEach(function(btn) {
                btn.classList.remove('active');
            });
            btnClicado.classList.add('active');
        }

        var target = document.querySelector(targetId);
        if (!target) return;

        var content = target.parentElement;
        content.querySelectorAll('.tab-pane').forEach(function(pane) {
            pane.classList.remove('show', 'active');
        });

        target.classList.add('show', 'active');
    }
    </script>
</head>
<body> 

<?php
require_once __DIR__ . '/../../app/config/Database.php';
require_once __DIR__ . '/../../app/dao/DashboardDAO.php';
require_once __DIR__ . '/../../app/dao/UserDAO.php';
require_once __DIR__ . '/../../app/dao/ProductDAO.php';
require_once __DIR__ . '/../../app/dao/ProductPaiDAO.php';
require_once __DIR__ . '/../../app/dao/PostDAO.php';

$dashboardDAO = new DashboardDAO();

$salesToday       = $dashboardDAO->salesToday();
$salesYesterday   = $dashboardDAO->salesYesterday();
$salesPercent     = $dashboardDAO->calcPercentage($salesToday, $salesYesterday);

$customersToday     = $dashboardDAO->customersToday();
$customersYesterday = $dashboardDAO->customersYesterday();
$customersPercent   = $dashboardDAO->calcPercentage($customersToday, $customersYesterday);

$tshirtsToday     = $dashboardDAO->tshirtsSoldToday();
$tshirtsYesterday = $dashboardDAO->tshirtsSoldYesterday();
$tshirtsPercent   = $dashboardDAO->calcPercentage($tshirtsToday, $tshirtsYesterday);

$pantsToday     = $dashboardDAO->pantsSoldToday();
$pantsYesterday = $dashboardDAO->pantsSoldYesterday();
$pantsPercent   = $dashboardDAO->calcPercentage($pantsToday, $pantsYesterday);

$totalUsers            = $dashboardDAO->totalUsers();
$totalUsersYesterday   = $dashboardDAO->totalUsersYesterday();
$totalUsersPercent     = $dashboardDAO->calcPercentage($totalUsers, $totalUsersYesterday);

$usersToday            = $dashboardDAO->usersRegisteredToday();
$usersTodayYesterday   = $dashboardDAO->usersRegisteredYesterday();
$usersTodayPercent     = $dashboardDAO->calcPercentage($usersToday, $usersTodayYesterday);

$activeAccounts           = $dashboardDAO->activeAccounts();
$activeAccountsYesterday  = $dashboardDAO->activeAccountsYesterday();
$activeAccountsPercent    = $dashboardDAO->calcPercentage($activeAccounts, $activeAccountsYesterday);

$inactiveAccounts          = $dashboardDAO->inactiveAccounts();
$inactiveAccountsYesterday = $dashboardDAO->inactiveAccountsYesterday();
$inactiveAccountsPercent   = $dashboardDAO->calcPercentage($inactiveAccounts, $inactiveAccountsYesterday);
$inactiveByPeriod = $dashboardDAO->inactiveUsersByPeriod();

$deletedAccounts = $dashboardDAO->deletedAccounts();
$deletedAccountsYesterday = $dashboardDAO->deletedAccountsYesterday();
$deletedAccountsPercent = $dashboardDAO->calcPercentage($deletedAccounts, $deletedAccountsYesterday);

$topProducts = $dashboardDAO->topSellingProducts();

$userDAO = new UserDAO();
$users = $userDAO->arrayUsersDAO(); 

$camposvisiveis = ['image', 'id', 'username', 'email', 'is_admin', 'estado','created_at', 'deleted_at'];
$camposEditaveis = ['username', 'email'];

$productPaiDAO = new ProductPaiDAO();
$produtosPai = $productPaiDAO->getAllProductsPaiComStats();

$camposvisiveisProdutosPai = ['image', 'id', 'nome', 'tipo', 'cor', 'preco_venda', 'stock_total', 'sales_total', 'revenue_total'];
$camposEditaveisProdutosPai = ['nome', 'tipo', 'cor', 'preco_venda'];

$productDAO = new ProductDAO();
$products = $productDAO->getAllProductsComStats();

$camposvisiveisProdutos = ['image', 'id', 'nome', 'tipo', 'cor', 'tamanho', 'peso', 'preco_venda', 'preco_custo', 'stock', 'sales', 'revenue'];
$camposEditaveisProdutos = ['tamanho', 'peso', 'preco_custo', 'stock'];

$posts = new PostDAO();
$posts = $posts->getAllPosts();

$camposvisiveisPosts = ['id', 'username', 'image', 'texto_post', 'like_count', 'comment_count', 'created_at', 'updated_at', 'deleted_at'];
$camposEditaveisPosts = ['image', 'texto_post'];
?>

<?php if(isset($_SESSION['toast'])): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast show" role="alert">
            <div class="toast-body <?= $_SESSION['toast']['type'] === 'error' ? 'bg-danger' : 'bg-success' ?> text-white">
                <?= htmlspecialchars($_SESSION['toast']['message']) ?>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['toast']); ?>
<?php endif; ?>
<style>

    /* 1. Estilo padrão do item (em repouso) */
    .menu-item {
        background-color: transparent !important; /* Fundo transparente */
        color: white !important;                 /* Texto branco */
        border: 1px solid #444 !important;       /* Borda cinza escura */
        transition: all 0.3s ease;               /* Deixa a mudança suave */
        width: 200px;
        text-align: center;
    }

    /* 2. Estilo de HOVER (Ao passar o mouse) */
    .menu-item:hover {
        background-color: rgba(255, 255, 255, 0.1) !important; /* Fundo levemente branco */
        color: #ffc107 !important;                            /* Texto fica amarelo */
        border-color: #ffc107 !important;                     /* Borda fica amarela */
    }

    /* 3. Estilo de ACTIVE (Quando clicado/selecionado) */
    /* O Bootstrap usa a classe .active para marcar o item atual */
    .menu-item.active {
        background-color: #ffc107 !important; /* Fundo amarelo vivo */
        color: black !important;             /* Texto preto para contrastar */
        border-color: #ffc107 !important;
        font-weight: bold;
    }

    footer {
        margin-left: 300px;
    }
</style>

<!-- Símbolos SVG reutilizáveis -->
<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="home" viewBox="0 0 16 16">
        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"></path>
    </symbol>
    <symbol id="people" viewBox="0 0 16 16">
        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
    </symbol>
    <symbol id="financesvg" viewBox="0 0 16 16">
        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm.25 4a.75.75 0 0 1 .75.75v2h2a.75.75 0 0 1 0 1.5h-2v2a.75.75 0 0 1-1.5 0v-2h-2a.75.75 0 0 1 0-1.5h2v-2A.75.75 0 0 1 8.25 4z"/>
    </symbol>
    <symbol id="box" viewBox="0 0 16 16">
        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
    </symbol>
    <symbol id="cart" viewBox="0 0 16 16">
        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
    <symbol id="comunity-icon" viewBox="0 0 16 16">
        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm.25 4a.75.75 0 0 1 .75.75v2h2a.75.75 0 0 1 0 1.5h-2v2a.75.75 0 0 1-1.5 0v-2h-2a.75.75 0 0 1 0-1.5h2v-2A.75.75 0 0 1 8.25 4z"/>
    </symbol>
    <symbol id="marketing-icon" viewBox="0 0 16 16">
        <path d="M3 2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H3zm9.5 2a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zM8.5 4a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zM6.5 6a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0v-4A.5.5 0 0 1 6.5 6z"/>
    </symbol>
</svg>

<div class="container-fluid">
    <div class="row">  
        <!-- Sidebar fixa -->
        <div class="col-md-3 col-lg-2 d-md-block bg-black sidebar vh-100 p-3 position-fixed" style="width: 300px; margin-right: 70px;">
            <!-- Logo -->
            <div class="mb-4 text-center">
                <img src="assets/images/imoral_logo1.png" alt="logo_imoral" class="mb-3" style="width: 200px;">
            </div>
            
            <!-- menu de navegação -->
            <div class="list-group d-flex flex-column gap-3 align-items-center" role="tablist">
                <ul class="list-unstyled">
                    <li>
                        <a class="list-group-item list-group-item-action menu-item border rounded px-4 mb-2 text-center active" style="width: 200px; background-color: black; cursor: pointer;" onclick="navegarPara('dashboard')">
                            <svg class="me-2" width="16" height="16" style="fill: white;"><use xlink:href="#home"></use></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="list-group-item list-group-item-action menu-item border rounded px-4 mb-2 text-center" style="width: 200px; background-color: black; cursor: pointer;" onclick="navegarPara('users')">
                            <svg class="me-2" width="16" height="16" style="fill: white;"><use xlink:href="#people"></use></svg>
                            Users
                        </a>
                    </li>
                    <li>
                        <a class="list-group-item list-group-item-action menu-item border rounded px-4 mb-2 text-center" style="width: 200px; background-color: black; cursor: pointer;" onclick="navegarPara('finance')">
                            <svg class="me-2" width="16" height="16" style="fill: white;"><use xlink:href="#financesvg"></use></svg>
                            Finance
                        </a>
                    </li>
                    <li>
                        <a class="list-group-item list-group-item-action menu-item border rounded px-4 mb-2 text-center" style="width: 200px; background-color: black; cursor: pointer;" onclick="navegarPara('products')">
                            <svg class="me-2" width="16" height="16" style="fill: white;"><use xlink:href="#box"></use></svg>
                            Products
                        </a>
                    </li>
                    <li>
                        <a class="list-group-item list-group-item-action menu-item border rounded px-4 mb-2 text-center" style="width: 200px; background-color: black; cursor: pointer;" onclick="navegarPara('orders')">
                            <svg class="me-2" width="16" height="16" style="fill: white;"><use xlink:href="#cart"></use></svg>
                            Orders
                        </a>
                    </li>
                    <li>
                        <a class="list-group-item list-group-item-action menu-item border rounded px-4 mb-2 text-center" style="width: 200px; background-color: black; cursor: pointer;" onclick="navegarPara('comunity')">
                            <svg class="me-2" width="16" height="16" style="fill: white;"><use xlink:href="#comunity-icon"></use></svg>
                            Community
                        </a>
                    </li>
                    <li>
                        <a class="list-group-item list-group-item-action menu-item border rounded px-4 mb-2 text-center" style="width: 200px; background-color: black; cursor: pointer;" onclick="navegarPara('marketing')">
                            <svg class="me-2" width="16" height="16" style="fill: white;"><use xlink:href="#marketing-icon"></use></svg>
                            Marketing
                        </a>
                    </li>
                </ul>  
            </div>
        </div>
        <!-- Inclui o header do dashboard -->
        <?php include __DIR__ . "/../includes/header.php"; ?>
        <!-- Conteúdo principal -->
        <div id="mainPage" class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 300px; padding-bottom: 80px;">
            <div class="tab-content" id="mainTabContent">
                <!-- ==================== DASHBOARD ==================== -->
                <div class="tab-pane fade show active" id="dashboard" role="tabpanel" style="margin-left: 70px;">
                    <h1 class="text-center mt-5">Dashboard</h1>
                    <p class="text-center">Here you can manage the main aspects of your business.</p>
                    <div>
                        <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                            <div class="col-md-5" style="min-width: 300px;">
                                <div class="card card-stats">
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                                <p class="h5 card-title text-uppercase mb-0" style="color: black; font-weight: bold;">Sales Today</p>
                                                <span class="h2 mb-0" style="color: black;"><?= $salesToday ?></span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                    📈
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-0 text-muted text-sm">
                                            <span class="<?= str_starts_with($salesPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?= $salesPercent ?></span>
                                            <span class="text-nowrap">from yesterday</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5" style="min-width: 300px;">
                                <div class="card card-stats">
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                                <p class="h5 card-title text-uppercase mb-0" style="color: black; font-weight: bold;">Customers Today</p>
                                                <span class="h2 mb-0" style="color: black;"><?= $customersToday ?></span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                    🧑‍🤝‍🧑
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-0 text-muted text-sm">
                                            <span class="<?= str_starts_with($customersPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?= $customersPercent ?></span>
                                            <span class="text-nowrap">from yesterday</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5" style="min-width: 300px;">
                                <div class="card card-stats">
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                                <p class="h5 card-title text-uppercase mb-0" style="color: black; font-weight: bold;">T-Shirt Sold Today</p>
                                                <span class="h2 mb-0" style="color: black;"><?= $tshirtsToday ?></span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                    👕
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-0 text-muted text-sm">
                                            <span class="<?= str_starts_with($tshirtsPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?= $tshirtsPercent ?></span>
                                            <span class="text-nowrap">from yesterday</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5" style="min-width: 300px;">
                                <div class="card card-stats">
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                                <p class="h5 card-title text-uppercase mb-0" style="color: black; font-weight: bold;">Pants Sold Today</p>
                                                <span class="h2 mb-0" style="color: black;"><?= $pantsToday ?></span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                    👖
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-0 text-muted text-sm">
                                            <span class="<?= str_starts_with($pantsPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?= $pantsPercent ?></span>
                                            <span class="text-nowrap">from yesterday</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== USERS ==================== -->
                <div class="tab-pane fade" id="users" role="tabpanel" style="margin-left: 70px;">
                    <h1 class="text-center mt-5">Users</h1>
                    <p class="text-center">Here is the users management section.</p>
                    <ul class="nav nav-tabs" id="usersMainTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="users-maininfo-tab" onclick="mudarTab(this, '#users-maininfo')" type="button" role="tab">Main Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="users-list-tab" onclick="mudarTab(this, '#users-usersList')" type="button" role="tab">Users List</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="usersMainTabContent">
                        <!-- Main Tab -->
                        <div class="tab-pane fade show active" id="users-maininfo" role="tabpanel" aria-labelledby="users-maininfo-tab">
                            <h1 class="mt-5">Users 👥</h1>
                            <button class="btn btn-outline-secondary mb-3" data-bs-toggle="collapse" data-bs-target="#userscontent">
                                View Details
                            </button>
                            <div id="userscontent" class="collapse">
                                <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px;">
                                    <div class="col-md-5" style="min-width: 300px;">
                                        <div class="card card-stats">
                                            <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase mb-0" style="color: black;">Total Registered Users</h5>
                                                        <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $totalUsers; ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                            👥
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted text-sm">
                                                    <span class="<?= str_starts_with($totalUsersPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $totalUsersPercent; ?></span>
                                                    <span class="text-nowrap">from yesterday</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5" style="min-width: 300px;">
                                        <div class="card card-stats">
                                            <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase mb-0" style="color: black;">Users Registered Today</h5>
                                                        <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $usersToday; ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                            👤
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted text-sm">
                                                    <span class="<?= str_starts_with($usersTodayPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $usersTodayPercent; ?></span>
                                                    <span class="text-nowrap">from yesterday</span>
                                                </p>
                                                <!-- colocar uma barra para dizer o maximo de registrados por dia-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5" style="min-width: 300px;">
                                        <div class="card card-stats">
                                            <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase mb-0" style="color: black;">Active Accounts</h5>
                                                        <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $activeAccounts; ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                            ✔
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted text-sm">
                                                    <span class="<?= str_starts_with($activeAccountsPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $activeAccountsPercent; ?></span>
                                                    <span class="text-nowrap">from yesterday</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5" style="min-width: 300px;">
                                        <div class="card card-stats">
                                            <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase mb-0" style="color: black;">Inactive Accounts</h5>
                                                        <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $inactiveAccounts; ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                            😴
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted text-sm">
                                                    <span class="<?= str_starts_with($inactiveAccountsPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $inactiveAccountsPercent; ?></span>
                                                    <span class="text-nowrap">from yesterday</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="mt-4"> 
                                <section class="mb-4">
                                    <h3 class="mb-3">Deleted Accounts ❌</h3>
                                    <button class="btn btn-outline-secondary mb-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStart">
                                        View Details
                                    </button>
                                </section>
                                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasStart">
                                    <div class="offcanvas-header">
                                        <h5 class="offcanvas-title">Deleted Accounts Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <div class="col-md-5" style="min-width: 300px;">
                                            <div class="card card-stats">
                                                <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="card-title text-uppercase mb-0" style="color: black;">Deleted Accounts</h5>
                                                            <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $deletedAccounts; ?></span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                                ❌
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-0 text-muted text-sm">
                                                        <span class="<?= str_starts_with($deletedAccountsPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $deletedAccountsPercent; ?></span>
                                                        <span class="text-nowrap">from yesterday</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h3 class="mb-3">Users Registered Today 🕓</h3>
                                <div class="col-md-5" style="min-width: 300px;">
                                    <div class="card card-stats">
                                        <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase mb-0" style="color: black;">Users Registered Today</h5>
                                                    <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $usersToday; ?></span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                        👤
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                <span class="<?= str_starts_with($usersTodayPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $usersTodayPercent; ?></span>
                                                <span class="text-nowrap">from yesterday</span>
                                            </p>
                                            <!-- colocar uma barra para dizer o maximo de registrados por dia-->
                                            <div class="progress mt-2" role="progressbar" aria-label="Users Today" 
                                                 aria-valuenow="<?= $usersToday ?>" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar" style="width: <?= min($usersToday, 100) ?>%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-secondary mt-3" data-bs-toggle="collapse" data-bs-target="#userstodaycontent">
                                    View Details
                                </button>
                                <div id="userstodaycontent" class="collapse mt-3">
                                    <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px;">
                                        <div class="col-md-5" style="min-width: 300px;">
                                            <div class="card card-stats">
                                                <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="card-title text-uppercase mb-0" style="color: black;">Total Registered Users</h5>
                                                            <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $totalUsers; ?></span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                                👥
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-0 text-muted text-sm">
                                                        <span class="<?= str_starts_with($totalUsersPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $totalUsersPercent; ?></span>
                                                        <span class="text-nowrap">from yesterday</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5" style="min-width: 300px;">
                                            <div class="card card-stats">
                                                <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="card-title text-uppercase mb-0" style="color: black;">Users Registered Today</h5>
                                                            <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $usersToday; ?></span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                                👤
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-0 text-muted text-sm">
                                                        <span class="<?= str_starts_with($usersTodayPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $usersTodayPercent; ?></span>
                                                        <span class="text-nowrap">from yesterday</span>
                                                    </p>
                                                    <!-- colocar uma barra para dizer o maximo de registrados por dia-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5" style="min-width: 300px;">
                                            <div class="card card-stats">
                                                <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="card-title text-uppercase mb-0" style="color: black;">Active Accounts</h5>
                                                            <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $activeAccounts; ?></span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                                ✔
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-0 text-muted text-sm">
                                                        <span class="<?= str_starts_with($activeAccountsPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $activeAccountsPercent; ?></span>
                                                        <span class="text-nowrap">from yesterday</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5" style="min-width: 300px;">
                                            <div class="card card-stats">
                                                <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="card-title text-uppercase mb-0" style="color: black;">Inactive Accounts</h5>
                                                            <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $inactiveAccounts; ?></span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                                😴
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-0 text-muted text-sm">
                                                        <span class="<?= str_starts_with($inactiveAccountsPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $inactiveAccountsPercent; ?></span>
                                                        <span class="text-nowrap">from yesterday</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <h1 class="mt-5">Retention Rate</h1>
                            <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px;">
                                <div class="col-md-5" style="min-width: 300px;">
                                    <div class="card card-stats">
                                        <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                            <div class="row">
                                                <div class="col">
                                                    <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $totalUsers; ?></span>
                                                    <p class="card-title text-uppercase mb-0" style="color: black;">Total Registered Users</p>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                        👥
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-3">
                                                    <canvas id="donutChart" width="200" height="200"></canvas>
                                                </div>
                                                <div class="col-9">
                                                    <div class="row">
                                                        <div class="col">
                                                            <p class="card-title text-uppercase mb-0" style="color: black; font-size: 12px; font-weight: bold;">Active Accounts</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <span class="h2 font-weight-bold mb-0" style="color: black; font-size: 30px;"><?php echo $activeAccounts; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p class="card-title text-uppercase mb-0" style="color: black; font-size: 12px; font-weight: bold;">Inactive Accounts</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <span class="h2 font-weight-bold mb-0" style="color: black; font-size: 30px;"><?php echo $inactiveAccounts; ?></span>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5" style="min-width: 300px;">
                                    <div class="card card-stats">
                                        <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase mb-0" style="color: black;">Deleted Accounts</h5>
                                                    <span class="h2 font-weight-bold mb-0" style="color: black;"><?php echo $deletedAccounts; ?></span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                        ❌
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                <span class="<?= str_starts_with($deletedAccountsPercent, '+') ? 'text-success' : 'text-danger' ?> me-2"><?php echo $deletedAccountsPercent; ?></span>
                                                <span class="text-nowrap">from yesterday</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="card card-stats mt-3">
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                                <ul class="nav nav-tabs" id="retentionTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="retention-rate-tab" onclick="mudarTab(this, '#retention-rate')" type="button" role="tab">Retention</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="retention-inactive-tab" onclick="mudarTab(this, '#retention-inactive')" type="button" role="tab">Inactive</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="retention-deleted-tab" onclick="mudarTab(this, '#retention-deleted')" type="button" role="tab">Deleted</button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="retentionTabContent">
                                                    <div class="tab-pane fade show active" id="retention-rate" role="tabpanel" aria-labelledby="retention-rate-tab">
                                                        <table class="table mt-3">
                                                            <thead>
                                                                <tr>
                                                                    <th>Retention Rate</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>85%</td>
                                                                    <td>2024-01-15</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>85%</td>
                                                                    <td>2024-01-15</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>               
                                                    <div class="tab-pane fade" id="retention-inactive" role="tabpanel" aria-labelledby="retention-inactive-tab">
                                                        <table class="table mt-3">
                                                            <thead>
                                                                <tr>
                                                                    <th>Retention Rate</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>40%</td>
                                                                    <td>2024-01-15</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>40%</td>
                                                                    <td>2024-01-15</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="retention-deleted" role="tabpanel" aria-labelledby="retention-deleted-tab">
                                                        <table class="table mt-3">
                                                            <thead>
                                                                <tr>
                                                                    <th>Retention Rate</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>25%</td>
                                                                    <td>2024-01-15</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>25%</td>
                                                                    <td>2024-01-15</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5" style="width: 450px;">
                                <div class="card card-stats">
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                               <p class="h2" style="font-weight: bold;">Inactive Users by Period</p>
                                            </div>
                                        </div>
                                        <div class="my-3" style="width: 400px;">
                                            <canvas id="chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion for reasons of account deletion - Como não temos o suficiente para finalizar fica comentado
                            <div class="mt-5">
                                <p class="h2 mt-5" style="font-weight: bold;">Reasons for Account Deletion</p>
                                <div class="card card-stats mt-3">
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <p class="h3 mb-3">Feedbacks: 4</p>
                                            <div class="col">
                                                <div class="overflow-auto" style="height: 182px;">
                                                    <div class="accordion" id="clientsAccordion">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                                    Clients Name - Title - date/date/date
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#clientsAccordion">
                                                                <div class="accordion-body">
                                                                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                    Clients Name - Title - date/date/date
                                                                </button>
                                                            </h2>
                                                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#clientsAccordion">
                                                                <div class="accordion-body">
                                                                    <strong>This is the second item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            -->
                        </div>
                        <!-- Users List -->
                        <div class="tab-pane fade" id="users-usersList" role="tabpanel" aria-labelledby="users-list-tab">
                            <div class="mt-3">
                                <div class="card card-stats mt-3">
                                    <div class="card-header">
                                        <ul class="nav nav-tabs" id="usersListTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="usersList-hide-tab" onclick="mudarTab(this, '#usersList-hide')" type="button" role="tab">Hide</button>  
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="usersList-insert-tab" onclick="mudarTab(this, '#usersList-insert')" type="button" role="tab">Insert</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="usersList-search-tab" onclick="mudarTab(this, '#usersList-search')" type="button" role="tab">Search</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                                <div class="tab-content" id="usersListTabContent">
                                                    <!-- Tab para esconder actions -->
                                                    <div class="tab-pane fade show active" id="usersList-hide" role="tabpanel" aria-labelledby="usersList-hide-tab">  
                                                    </div>
                                                    <!-- Botão para abrir o modal de inserção de utilizadores -->
                                                    <div class="tab-pane fade show" id="usersList-insert" role="tabpanel" aria-labelledby="usersList-insert-tab">
                                                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#insertUserModal">
                                                            Add Utilizador
                                                        </button>
                                                    </div>
                                                    <!-- Barra de pesquisa e filtros -->
                                                    <div class="tab-pane fade" id="usersList-search" role="tabpanel" aria-labelledby="usersList-search-tab">
                                                        <div class="card mb-3">
                                                          <div class="card-body">
                                                            <div class="row g-2">
                                                              <div class="col-md-10">
                                                                <input type="text" id="searchUsersInput" class="form-control" placeholder="🔍 Search Users...">
                                                              </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-primary mb-3 w-100" id="btnLimparFiltrosUsers">
                                                                        Clear
                                                                    </button>   
                                                                </div> 
                                                              <div class="col-md-3">
                                                                <label class="form-label">Role</label>
                                                                <select id="filterRole" class="form-select">
                                                                    <option value="">All</option>
                                                                    <option value="Admin">Admin</option>
                                                                    <option value="User">User</option>
                                                                </select>
                                                              </div>
                                                              <div class="col-md-3">
                                                                <label class="form-label">Status</label>
                                                                <select id="filterStatus" class="form-select">
                                                                    <option value="">All</option>
                                                                    <option value="Active">Active</option>
                                                                    <option value="Inactive">Inactive</option>
                                                                    <option value="Suspended">Suspended</option>
                                                                    <option value="Deleted">Deleted</option>
                                                                    <option value="Banned">Banned</option>
                                                                </select>
                                                              </div>
                                                              <div class="col-md-6">
                                                                <label class="form-label">Account Creation Date</label>
                                                                <div class="d-flex gap-1">
                                                                  <input type="date" id="filterAccountCreationDateMin" class="form-control">
                                                                  <input type="date" id="filterAccountCreationDateMax" class="form-control">
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title mb-0">Users</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <?php foreach($camposvisiveis as $campo): ?>
                                                                                <th><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $campo))) ?></th>
                                                                            <?php endforeach; ?>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="corpoTabelaUsersDB">
                                                                        <?php foreach($users as $row): ?>
                                                                        <tr>
                                                                            <?php foreach($camposvisiveis as $campo): ?>
                                                                                <?php $estado = $userDAO->usersEstado($row['id']); ?> 
                                                                                <?php if ($campo === 'is_admin'): ?>
                                                                                    <td><?= $row[$campo] == 1 ? 'Admin' : 'User' ?></td>
                                                                                <?php elseif (in_array($campo, $camposEditaveis)): ?>
                                                                                    <td data-campo="<?= htmlspecialchars($campo) ?>"
                                                                                        data-id="<?= (int)$row['id'] ?>">
                                                                                        <?= htmlspecialchars($row[$campo]) ?>
                                                                                    </td>
                                                                                <?php elseif ($campo === 'image'): ?>
                                                                                    <td>
                                                                                        <img src="/<?= htmlspecialchars($row[$campo] ?? 'assets/images/users/user_icon.png') ?>" 
                                                                                             alt="user_avatar" 
                                                                                             width="40" 
                                                                                             style="height:30px; object-fit:cover;"
                                                                                             class="d-inline-block align-text-top"/>
                                                                                    </td>
                                                                                <?php elseif ($campo === 'estado'): ?>
                                                                                    <td class="estadoCell"><?= htmlspecialchars((string)$estado) ?></td>
                                                                                <?php elseif ($campo === 'deleted_at'): ?>
                                                                                    <td class="deletedAtCell"><?= htmlspecialchars((string)($row[$campo] ?? '')) ?></td>
                                                                                <?php else: ?>
                                                                                    <td><?= htmlspecialchars($row[$campo]) ?></td>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                            <td>
                                                                                <div class="row">
                                                                                    <div class="col-md-6 d-flex">
                                                                                        <button class="btn btn-sm btn-warning btnUpdateUser" data-bs-toggle="modal" data-bs-target="#editUserModal-<?= $row['id'] ?>" style="width: 80px;"> Update </button>
                                                                                    </div>
                                                                                    <div class="col-md-6 d-flex divDeleteUser <?= !empty($row['deleted_at']) ? 'd-none' : '' ?>">
                                                                                        <button class="btn btn-sm btn-danger btnDeleteUser" style="width: 80px;">Delete</button>
                                                                                    </div>
                                                                                    <div class="col-md-6 d-flex divUnbanUser <?= empty($row['deleted_at']) ? 'd-none' : '' ?>">
                                                                                        <button class="btn btn-sm btn-success btnUnbanUser" style="width: 80px;">Unban</button>
                                                                                    </div>
                                                                                    <div class="col-md-6 d-flex">
                                                                                        <button class="btn btn-sm btn-primary btnActivateUser" style="width: 80px;">Activate</button>
                                                                                    </div>
                                                                                    <div class="col-md-6 d-flex">
                                                                                        <button class="btn btn-sm btn-danger btnSuspendUser" style="width: 80px;">Suspend</button>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== FINANCE ==================== -->
                <div class="tab-pane fade" id="finance" role="tabpanel" style="margin-left: 70px;">
                    <h1 class="text-center mt-5">Finance</h1>
                    <h3>Revenue - Receita</h3>
                    <div class="row">
                        <div class="col-md-5" style="min-width: 300px;">
                            <div class="card card-stats">
                                <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase mb-0" style="color: black;">Revenue</h5>
                                            <span class="h2 font-weight-bold mb-0" style="color: black;">10,000€</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-dark text-white rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                💰
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-muted text-sm">
                                        <span class="text-success me-2">+20%</span>
                                        <span class="text-nowrap">from yesterday</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3>Sales - Vendas</h3>
                    <h3>Profit - Lucro</h3>
                    <h3>Expenses - Despesas</h3>
                    <h3>Product Manufacturing Cost - Custo de fabricação do produto</h3>
                    <h3>Average Order Value - Ticket Medio</h3>
                    <h3>Claimed Coupons - Cupons Resgatados</h3>
                    <h3>Impact of discounts on revenue - Impacto dos descontos na receita</h3>
                </div>

                <!-- ==================== PRODUCTS ==================== -->
                <div class="tab-pane fade" id="products" role="tabpanel" style="margin-left: 70px;">
                    <h1 class="text-center mt-5">Products</h1>
                    <p class="text-center">Here is the products management section.</p>
                    <!-- Sub-tabs dos products -->
                    <ul class="nav nav-tabs" id="productsMainTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="products-maininfo-tab" onclick="mudarTab(this, '#products-maininfo')" type="button" role="tab">Main Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="products-pai-tab" onclick="mudarTab(this, '#products-productsPaiList')" type="button" role="tab">Products Pai List</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="products-list-tab" onclick="mudarTab(this, '#products-productsList')" type="button" role="tab">Products List</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="productsMainTabContent">
                        <!-- Main Tab -->
                        <div class="tab-pane fade show active" id="products-maininfo" role="tabpanel" aria-labelledby="products-maininfo-tab">
                            <div class="d-flex justify-content-center mt-4">
                                <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; max-width: 950px;">
                                    <!-- Top Selling Products Table -->
                                    <div class="col-md-12" style="min-width: 300px;">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Top Selling Products</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Image</th>
                                                                <th>Product</th>
                                                                <th>Category</th>
                                                                <th>Price</th>
                                                                <th>Sales</th>
                                                                <th>Revenue</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($topProducts as $row): ?>
                                                            <tr>
                                                                <td><img src="<?= htmlspecialchars($row['image'] ?? '') ?>" alt="product image" style="width: 40px; height: 40px; object-fit: cover;"></td>
                                                                <td><span><?= htmlspecialchars($row['nome']) ?></span></td>
                                                                <td><?= htmlspecialchars($row['tipo']) ?></td>
                                                                <td>€<?= number_format((float)$row['preco_venda'], 2) ?></td>
                                                                <td><?= (int)$row['total_vendido'] ?></td>
                                                                <td>€<?= number_format((float)$row['receita'], 2) ?></td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ProductsPai List Tab -->                       
                        <div class="tab-pane fade" id="products-productsPaiList" role="tabpanel" aria-labelledby="productspai-list-tab">
                            <div class="mt-3">
                                <div class="card card-stats mt-3">
                                    <!-- Sub-tabs dos products list -->
                                    <div class="card-header">
                                        <ul class="nav nav-tabs" id="productsListPaiTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="productsPaiList-hide-tab" onclick="mudarTab(this, '#productsPaiList-hide')" type="button" role="tab">Hide</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="productsPaiList-insert-tab" onclick="mudarTab(this, '#productsPaiList-insert')" type="button" role="tab">Insert</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="productsPaiList-search-tab" onclick="mudarTab(this, '#productsPaiList-search')" type="button" role="tab">Search</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                                <div class="tab-content" id="productsPaiListTabContent">
                                                    <!-- Tab for hiding actions -->
                                                    <div class="tab-pane fade show active" id="productsPaiList-hide" role="tabpanel" aria-labelledby="productsPaiList-hide-tab">
                                                    </div>
                                                    <!-- Botão para abrir o modal -->
                                                    <div class="tab-pane fade show active" id="productsPaiList-insert" role="tabpanel" aria-labelledby="productsPaiList-insert-tab">
                                                        <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#insertProdutoPaiModal">
                                                            Add ProdutoPai
                                                        </button>       
                                                    </div>
                                                    <!-- Barra de pesquisa e filtros -->
                                                    <div class="tab-pane fade" id="productsPaiList-search" role="tabpanel" aria-labelledby="productsPaiList-search-tab">

                                                        <div class="card mb-3">
                                                          <div class="card-body">
                                                            <div class="row g-2">
                                                              <div class="col-md-10">
                                                                <input type="text" id="searchProduct" class="form-control" placeholder="🔍 Search Products...">
                                                              </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-primary mb-3 w-100" id="btnLimparFiltros">
                                                                        Clear
                                                                    </button>   
                                                                </div> 
                                                              <div class="col-md-3">
                                                                <label class="form-label">Category</label>
                                                                <select id="filterCategory" class="form-select">
                                                                  <option value="">All</option>
                                                                  <option value="T-Shirts">T-Shirts</option>
                                                                  <option value="Pants">Pants</option>
                                                                  <option value="Jackets">Jackets</option>
                                                                </select>
                                                              </div>
                                                              <div class="col-md-3">
                                                                <label class="form-label">Price (€)</label>
                                                                <div class="d-flex gap-1">
                                                                  <input type="text" id="filterPriceMin" class="form-control" placeholder="Min">
                                                                  <input type="text" id="filterPriceMax" class="form-control" placeholder="Max">
                                                                </div>
                                                              </div>
                                                              <div class="col-md-3">
                                                                <label class="form-label">Sales</label>
                                                                <div class="d-flex gap-1">
                                                                  <input type="text" id="filterSalesMin" class="form-control" placeholder="Min">
                                                                  <input type="text" id="filterSalesMax" class="form-control" placeholder="Max">
                                                                </div>
                                                              </div>
                                                              <div class="col-md-3">
                                                                <label class="form-label">Revenue (€)</label>
                                                                <div class="d-flex gap-1">
                                                                  <input type="text" id="filterRevenueMin" class="form-control" placeholder="Min">
                                                                  <input type="text" id="filterRevenueMax" class="form-control" placeholder="Max">
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mt-4">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <?php foreach($camposvisiveisProdutosPai as $campo): ?>
                                                                                <th><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $campo))) ?></th>
                                                                            <?php endforeach; ?>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="corpoTabelaProdutosPaiDB">
                                                                        <?php foreach($produtosPai as $row): ?>
                                                                        <tr>
                                                                            <?php foreach($camposvisiveisProdutosPai as $campo): ?>
                                                                                <?php if ($campo === 'image'): ?>
                                                                                    <td><img src="<?= htmlspecialchars($row[$campo] ?? '') ?>" style="width:40px;height:40px;object-fit:cover;"></td>
                                                                                <?php elseif (in_array($campo, ['preco_venda', 'revenue_total'])): ?>
                                                                                    <td<?= in_array($campo, $camposEditaveisProdutosPai) ? ' data-campo="' . htmlspecialchars($campo) . '" data-id="' . (int)$row['id'] . '"' : '' ?>>
                                                                                        €<?= number_format((float)$row[$campo], 2) ?>
                                                                                    </td>
                                                                                <?php elseif (in_array($campo, $camposEditaveisProdutosPai)): ?>
                                                                                    <td data-campo="<?= htmlspecialchars($campo) ?>" data-id="<?= (int)$row['id'] ?>">
                                                                                        <?= htmlspecialchars((string)($row[$campo] ?? '')) ?>
                                                                                    </td>
                                                                                <?php else: ?>
                                                                                    <td><?= htmlspecialchars((string)($row[$campo] ?? '')) ?></td>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                            <td>
                                                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProdutoPaiModal-<?= $row['id'] ?>">Update</button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Products List Tab -->                       
                        <div class="tab-pane fade" id="products-productsList" role="tabpanel" aria-labelledby="products-list-tab">
                            <div class="mt-3">
                                <div class="card card-stats mt-3">
                                    <!-- Sub-tabs dos products list -->
                                    <div class="card-header">
                                        <ul class="nav nav-tabs" id="productsListTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="productsList-hide-tab" onclick="mudarTab(this, '#productsList-hide')" type="button" role="tab">Hide</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="productsList-insert-tab" onclick="mudarTab(this, '#productsList-insert')" type="button" role="tab">Insert</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="productsList-search-tab" onclick="mudarTab(this, '#productsList-search')" type="button" role="tab">Search</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                                <div class="tab-content" id="productsListTabContent">
                                                    <!-- Tab for hiding actions -->
                                                    <div class="tab-pane fade show active" id="productsList-hide" role="tabpanel" aria-labelledby="productsList-hide-tab">
                                                    </div>
                                                    <!-- Botão para abrir o modal -->
                                                    <div class="tab-pane fade show active" id="productsList-insert" role="tabpanel" aria-labelledby="productsList-insert-tab">   
                                                        <button id="addProduct" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#insertProductModal">
                                                            Add Product
                                                        </button>
                                                    </div>
                                                    <!-- Barra de pesquisa e filtros -->
                                                    <div class="tab-pane fade" id="productsList-search" role="tabpanel" aria-labelledby="productsList-search-tab">
                                                        <div class="card mb-3">
                                                          <div class="card-body">
                                                            <div class="row g-2">
                                                              <div class="col-md-10">
                                                                <input type="text" id="searchProduct" class="form-control" placeholder="🔍 Search Products...">
                                                              </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-primary mb-3 w-100" id="btnLimparFiltros">
                                                                        Clear
                                                                    </button>   
                                                                </div> 
                                                              <div class="col-md-3">
                                                                <label class="form-label">Category</label>
                                                                <select id="filterCategory" class="form-select">
                                                                  <option value="">All</option>
                                                                  <option value="T-Shirts">T-Shirts</option>
                                                                  <option value="Pants">Pants</option>
                                                                  <option value="Jackets">Jackets</option>
                                                                </select>
                                                              </div>
                                                              <div class="col-md-3">
                                                                <label class="form-label">Price (€)</label>
                                                                <div class="d-flex gap-1">
                                                                  <input type="text" id="filterPriceMin" class="form-control" placeholder="Min">
                                                                  <input type="text" id="filterPriceMax" class="form-control" placeholder="Max">
                                                                </div>
                                                              </div>
                                                              <div class="col-md-3">
                                                                <label class="form-label">Sales</label>
                                                                <div class="d-flex gap-1">
                                                                  <input type="text" id="filterSalesMin" class="form-control" placeholder="Min">
                                                                  <input type="text" id="filterSalesMax" class="form-control" placeholder="Max">
                                                                </div>
                                                              </div>
                                                              <div class="col-md-3">
                                                                <label class="form-label">Revenue (€)</label>
                                                                <div class="d-flex gap-1">
                                                                  <input type="text" id="filterRevenueMin" class="form-control" placeholder="Min">
                                                                  <input type="text" id="filterRevenueMax" class="form-control" placeholder="Max">
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mt-4">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <?php foreach($camposvisiveisProdutos as $campo): ?>
                                                                                <th><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $campo))) ?></th>
                                                                            <?php endforeach; ?>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="corpoTabelaProdutosDB">
                                                                        <?php foreach($products as $row): ?>
                                                                        <tr>
                                                                            <?php foreach($camposvisiveisProdutos as $campo): ?>
                                                                                
                                                                                <?php if ($campo === 'image'): ?>
                                                                                    <td><img src="<?= htmlspecialchars($row[$campo] ?? '') ?>" style="width:40px;height:40px;object-fit:cover;"></td>
                                                                                
                                                                                <?php elseif (in_array($campo, ['preco_venda', 'revenue'])): ?>
                                                                                    <td<?= in_array($campo, $camposEditaveisProdutos) ? ' data-campo="' . htmlspecialchars($campo) . '" data-id="' . (int)$row['id'] . '"' : '' ?>>
                                                                                        €<?= number_format((float)($row[$campo] ?? 0), 2) ?>
                                                                                    </td>
                                                                                <?php elseif (in_array($campo, $camposEditaveisProdutos)): ?>
                                                                                    <td data-campo="<?= htmlspecialchars($campo) ?>" data-id="<?= (int)$row['id'] ?>">
                                                                                        <?= htmlspecialchars((string)($row[$campo] ?? '')) ?>
                                                                                    </td>
                                                                                
                                                                                <?php else: ?>
                                                                                    <td><?= htmlspecialchars((string)($row[$campo] ?? '')) ?></td>
                                                                                
                                                                                <?php endif; ?>
                                                                                
                                                                            <?php endforeach; ?>
                                                                            <td>
                                                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProdutoModal-<?= $row['id'] ?>">Update</button>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProduto-<?= $row['id'] ?>">Delete</button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== ORDERS ==================== -->
                <div class="tab-pane fade" id="orders" role="tabpanel" style="margin-left: 70px">
                    <h1 class="text-center mt-5">Orders</h1>
                    <p class="text-center">Here you can manage the site orders.</p>
                </div>

                <!-- ==================== COMUNITY ==================== -->
                <div class="tab-pane fade" id="comunity" role="tabpanel" style="margin-left: 70px;">
                    <h1 class="text-center mt-5">Comunity</h1>
                    <p class="text-center">Here is the comunity management section.</p>
                    <ul class="nav nav-tabs" id="comunityMainTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="comunity-maininfo-tab" onclick="mudarTab(this, '#comunity-maininfo')" type="button" role="tab">Main Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="comunity-list-tab" onclick="mudarTab(this, '#comunity-postList')" type="button" role="tab">Post List</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="comunityMainTabContent">
                        <!-- Main Tab -->
                        <div class="tab-pane fade show active" id="comunity-maininfo" role="tabpanel" aria-labelledby="comunity-maininfo-tab">

                        </div>
                        <!-- Post List -->
                        <div class="tab-pane fade" id="comunity-postList" role="tabpanel" aria-labelledby="post-list-tab">
                            <div class="mt-3">
                                <div class="card card-stats mt-3">
                                    <div class="card-header">
                                        <ul class="nav nav-tabs" id="postListTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="postList-hide-tab" onclick="mudarTab(this, '#postList-hide')" type="button" role="tab">Hide</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="postList-insert-tab" onclick="mudarTab(this, '#postList-insert')" type="button" role="tab">Insert</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="postList-search-tab" onclick="mudarTab(this, '#postList-search')" type="button" role="tab">Search</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 10px;">
                                        <div class="row">
                                            <div class="col">
                                                <div class="tab-content" id="postListTabContent">
                                                    <!-- Conteúdo da aba Hide -->
                                                    <div class="tab-pane fade show active" id="postList-hide" role="tabpanel" aria-labelledby="postList-hide-tab">
                                                    </div>
                                                    <!-- Botão para abrir o modal -->
                                                    <div class="tab-pane fade" id="postList-insert" role="tabpanel" aria-labelledby="postList-insert-tab">
                                                        <button id="addPost" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#insertPostModal">
                                                            Add Post
                                                        </button>       
                                                    </div>
                                                    <!-- Barra de pesquisa e filtros -->
                                                    <div class="tab-pane fade" id="postList-search" role="tabpanel" aria-labelledby="postList-search-tab">
                                                        <div class="card mb-3">
                                                            <div class="card-body">
                                                                <div class="row g-2">
                                                                    <div class="col-md-10">
                                                                        <input type="text" id="searchPostsInput" class="form-control" placeholder="🔍 Search Posts...">
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button class="btn btn-primary mb-3 w-100" id="btnLimparFiltrosPosts">
                                                                            Clear
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Tabela Posts -->
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title mb-0">Posts</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <?php foreach($camposvisiveisPosts as $campo): ?>
                                                                                <th><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $campo))) ?></th>
                                                                            <?php endforeach; ?>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="corpoTabelaPostsDB">
                                                                        <?php foreach($posts as $row): ?>
                                                                        <tr>
                                                                            <?php foreach($camposvisiveisPosts as $campo): ?>
                                                                                <?php if (in_array($campo, $camposEditaveisPosts)): ?>
                                                                                    <td data-campo="<?= htmlspecialchars($campo) ?>"
                                                                                        data-id="<?= (int)$row['id'] ?>">
                                                                                        <?= htmlspecialchars($row[$campo] ?? '') ?>
                                                                                    </td>
                                                                                <?php elseif ($campo === 'username'): ?>
                                                                                    <td>
                                                                                        <a href="/users/<?= (int)$row['id_utilizador'] ?>">
                                                                                            <?= htmlspecialchars($row[$campo] ?? '') ?>
                                                                                        </a>
                                                                                    </td>
                                                                                <?php else: ?>
                                                                                    <td><?= htmlspecialchars($row[$campo] ?? '') ?></td>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                            <td>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 d-flex">
                                                                                        <button class="btn btn-sm btn-warning btnUpdatePost" data-bs-toggle="modal" data-bs-target="#editPostModal-<?= $row['id'] ?>" style="width: 80px;"> Update </button>
                                                                                    </div>
                                                                                    <div class="col-md-12 d-flex">
                                                                                        <button class="btn btn-sm btn-danger btnDeletePost" style="width: 80px;">Delete</button>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== MARKETING ==================== -->
                <div class="tab-pane fade" id="marketing" role="tabpanel" style="margin-left: 70px;">
                    <h1 class="text-center mt-5">Marketing</h1>
                    <p class="text-center">Here you can manage the site marketing campaigns.</p>
                </div>
            </div>  
        </div>
        <!-- end-conteudo -->
        
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>

<!-- Modais -->

<!-- Modal de criar utilizador -->
<div class="modal fade" id="insertUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Criar Utilizador</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
    <form method="post" id="formInsertUser">
        <div class="modal-body">
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="hidden" name="password" value="temp">
            <input type="hidden" name="confirm_password" value="temp">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <?php if (AuthMiddlewareWeb::isAdmin()): ?>
            <button type="submit" class="btn btn-primary">Guardar</button>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal de update utilizador -->
<?php foreach($users as $row): ?>
<div class="modal fade" id="editUserModal-<?= $row['id'] ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar <?= htmlspecialchars($row['username']) ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <form method="post" id="formEditUser-<?= $row['id'] ?>">
        <div class="modal-body">
          <input type="text" name="username" value="<?= htmlspecialchars($row['username']) ?>" class="form-control mb-2" placeholder="Username" required>
          <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control mb-2" placeholder="Email" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <?php if (AuthMiddlewareWeb::canEditProfile($row['id'])): ?>
            <button type="submit" class="btn btn-primary">Guardar</button>
          <?php endif; ?>
        </div>
    </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- Modal de criar produto pai -->
<div class="modal fade" id="insertProdutoPaiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New ProdutoPai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formInsertProdutoPai">
                <div class="modal-body">
                    <label class="form-label">Nome *</label>
                    <input type="text" name="nome" class="form-control mb-2" required>
                    <label class="form-label">Tipo *</label>
                    <input type="text" name="tipo" class="form-control mb-2" required>
                    <label class="form-label">Cor</label>
                    <input type="text" name="cor" class="form-control mb-2">
                    <label class="form-label">Image URL</label>
                    <input type="text" name="image" class="form-control mb-2">
                    <label class="form-label">Preço Venda (€) *</label>
                    <input type="number" step="0.01" name="preco_venda" class="form-control mb-2" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div> 

<!-- Modal de update produto pai -->
<?php foreach($produtosPai as $row): ?>
<div class="modal fade" id="editProdutoPaiModal-<?= $row['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar <?= htmlspecialchars($row['nome']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" id="formEditProdutoPai-<?= $row['id'] ?>">
                <div class="modal-body">
                    <input type="text" name="nome" value="<?= htmlspecialchars($row['nome']) ?>" class="form-control mb-2" placeholder="Nome" required>
                    <input type="text" name="tipo" value="<?= htmlspecialchars($row['tipo']) ?>" class="form-control mb-2" placeholder="Tipo" required>
                    <input type="text" name="cor" value="<?= htmlspecialchars($row['cor'] ?? '') ?>" class="form-control mb-2" placeholder="Cor">
                    <input type="number" step="0.01" name="preco_venda" value="<?= htmlspecialchars($row['preco_venda']) ?>" class="form-control mb-2" placeholder="Preço Venda">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal de criar produto -->
<div class="modal fade" id="insertProductModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Produto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" id="formInsertProduto">
        <div class="modal-body">
          <select name="id_produto_pai" class="form-control mb-2" required>
            <option value="">Selecione o Produto Pai</option>
            <?php foreach($produtosPai as $pai): ?>
              <option value="<?= $pai['id'] ?>"><?= htmlspecialchars($pai['nome']) ?></option>
            <?php endforeach; ?>
          </select>
          <input type="text" name="tamanho" class="form-control mb-2" placeholder="Tamanho" required>
          <input type="number" step="0.01" name="peso" class="form-control mb-2" placeholder="Peso" required>
          <input type="number" step="0.01" name="preco_custo" class="form-control mb-2" placeholder="Preço Custo" required>
          <input type="number" name="stock" class="form-control mb-2" placeholder="Stock" value="0">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Criar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal de update produto -->
<?php foreach($products as $row): ?>
<div class="modal fade" id="editProdutoModal-<?= $row['id'] ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Produto #<?= $row['id'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" id="formEditProduto-<?= $row['id'] ?>">
        <div class="modal-body">
          <input type="text" name="tamanho" value="<?= htmlspecialchars($row['tamanho']) ?>" class="form-control mb-2" placeholder="Tamanho" required>
          <input type="number" step="0.01" name="peso" value="<?= htmlspecialchars($row['peso']) ?>" class="form-control mb-2" placeholder="Peso">
          <input type="number" step="0.01" name="preco_custo" value="<?= htmlspecialchars($row['preco_custo']) ?>" class="form-control mb-2" placeholder="Preço Custo">
          <input type="number" name="stock" value="<?= htmlspecialchars($row['stock']) ?>" class="form-control mb-2" placeholder="Stock">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- Modal de delete produto -->
<?php foreach($products as $row): ?>
<div class="modal fade" id="deleteProduto-<?= $row['id'] ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar Produto #<?= $row['id'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Tens a certeza que queres eliminar este produto? Esta ação não pode ser revertida.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger btnConfirmDeleteProduto" data-id="<?= $row['id'] ?>">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ============================================================
     Todos os scripts no final do body, após o Bootstrap JS
     ============================================================ -->
<script>
    // ---- Donut Chart (Retention Rate) ----
    const ctxDonut = document.getElementById('donutChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [<?php echo $activeAccounts; ?>, <?php echo $inactiveAccounts; ?>],
                backgroundColor: ['#3b82f6', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            hover: { mode: null }
        }
    });

    // ---- Bar Chart (Inactive Users by Period) ----
    new Chart(document.getElementById('chart'), {
        type: 'bar',
        data: {
            labels: ['< 1 mês', '1-2 meses', '2-3 meses', '3-6 meses', '6 meses +'],
            datasets: [{
                data: [
                    <?= $inactiveByPeriod['Menos de 1 mês'] ?? 0 ?>,
                    <?= $inactiveByPeriod['1 a 2 meses'] ?? 0 ?>,
                    <?= $inactiveByPeriod['2 a 3 meses'] ?? 0 ?>,
                    <?= $inactiveByPeriod['3 a 6 meses'] ?? 0 ?>,
                    <?= $inactiveByPeriod['Mais de 6 meses'] ?? 0 ?>
                ],
                backgroundColor: ['#f4c95d', '#f4a541', '#e06c3a', '#c0392b', '#8b0000'],
                borderRadius: 4,
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // ---- Criar utilizador / Add User ----
    const formInsertUser = document.getElementById('formInsertUser');
    if (formInsertUser) {
        formInsertUser.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            const res = await fetch('/admin/users/create', {
                method: 'POST',
                body: formData
            });

            if (res.redirected || res.ok) {
                bootstrap.Modal.getInstance(document.getElementById('insertUserModal')).hide();
                location.reload();
            }
        });
    }

    // ---- Update User ----
    document.querySelectorAll('[id^="formEditUser-"]').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const userId = this.id.replace('formEditUser-', '');
            const formData = new FormData(this);

            const res = await fetch('/users/' + userId + '/update', {
                method: 'POST',
                body: formData
            });

            if (res.ok) {
                bootstrap.Modal.getInstance(document.querySelector('.modal.show')).hide();

                const usernameInput = form.querySelector('[name="username"]');
                const emailInput = form.querySelector('[name="email"]');
                const linha = document.querySelector(`[data-id="${userId}"]`)?.closest('tr');

                if (linha) {
                    linha.querySelector('[data-campo="username"]').textContent = usernameInput.value;
                    linha.querySelector('[data-campo="email"]').textContent = emailInput.value;
                }
            }
        });
    });

    // ---- Activate, Suspend, Delete e Unban de users ----
    const corpoTabelaUsersDB = document.getElementById('corpoTabelaUsersDB');
    if (corpoTabelaUsersDB) {
        corpoTabelaUsersDB.addEventListener('click', async function(e) {
            const linha = e.target.closest('tr');
            if (!linha) return;
            const userId = linha.querySelector('[data-id]')?.dataset.id;

            if (e.target.classList.contains('btnActivateUser')) {
                await fetch('/users/' + userId + '/activate', { method: 'POST' });
                linha.querySelector('.estadoCell').textContent = 'Conta Ativa';
            }

            if (e.target.classList.contains('btnSuspendUser')) {
                await fetch('/users/' + userId + '/suspend', { method: 'POST' });
                linha.querySelector('.estadoCell').textContent = 'Conta Suspensa';
            }

            if (e.target.classList.contains('btnDeleteUser')) {
                const resposta = await fetch('/users/' + userId + '/delete', { method: 'POST' });
                const dados = await resposta.json();

                linha.querySelector('.estadoCell').textContent = 'Conta Banida';

                const deletedAtCell = linha.querySelector('.deletedAtCell');
                if (deletedAtCell) deletedAtCell.textContent = dados.deleted_at;

                linha.querySelector('.divDeleteUser').classList.add('d-none');
                linha.querySelector('.divUnbanUser').classList.remove('d-none');
            }

            if (e.target.classList.contains('btnUnbanUser')) {
                await fetch('/users/' + userId + '/unban', { method: 'POST' });

                linha.querySelector('.estadoCell').textContent = 'Conta Ativa';

                const deletedAtCell = linha.querySelector('.deletedAtCell');
                if (deletedAtCell) deletedAtCell.textContent = '';

                linha.querySelector('.divUnbanUser').classList.add('d-none');
                linha.querySelector('.divDeleteUser').classList.remove('d-none');
            }
        });
    }

    // ---- Criar ProdutoPai / Add ProductPai ----
    const formInsertProdutoPai = document.getElementById('formInsertProdutoPai');
    if (formInsertProdutoPai) {
        formInsertProdutoPai.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            const res = await fetch('/produtospai/create', {
                method: 'POST',
                body: formData
            });

            const dados = await res.json();

            if (!dados.success) {
                alert(dados.message || 'Erro ao criar ProdutoPai.');
                return;
            }

            const novaLinha = `
                <tr>
                    <td><img src="${dados.image || ''}" style="width:40px;height:40px;object-fit:cover;"></td>
                    <td>${dados.id}</td>
                    <td data-campo="nome" data-id="${dados.id}">${dados.nome}</td>
                    <td data-campo="tipo" data-id="${dados.id}">${dados.tipo}</td>
                    <td data-campo="cor" data-id="${dados.id}">${dados.cor ?? ''}</td>
                    <td data-campo="preco_venda" data-id="${dados.id}">€${Number(dados.preco_venda).toFixed(2)}</td>
                    <td>0</td>
                    <td>0.00</td>
                    <td>€0.00</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProdutoPaiModal-${dados.id}">Update</button>
                    </td>
                </tr>`;

            const corpo = document.getElementById('corpoTabelaProdutosPaiDB');
            if (corpo) corpo.innerHTML += novaLinha;

            bootstrap.Modal.getInstance(document.getElementById('insertProdutoPaiModal')).hide();
            this.reset();
        });
    }

    // ---- Editar ProdutoPai / Update ProductPai ----
    document.querySelectorAll('[id^="formEditProdutoPai-"]').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = this.id.replace('formEditProdutoPai-', '');
            const formData = new FormData(this);

            const res = await fetch('/productspai/' + id + '/update', {
                method: 'POST',
                body: formData
            });

            if (res.ok) {
                bootstrap.Modal.getInstance(document.querySelector('.modal.show')).hide();
                ['nome', 'tipo', 'cor', 'preco_venda'].forEach(campo => {
                    const td = document.querySelector(`[data-campo="${campo}"][data-id="${id}"]`);
                    if (td) {
                        const val = formData.get(campo);
                        td.textContent = campo === 'preco_venda' ? '€' + parseFloat(val).toFixed(2) : val;
                    }
                });
            }
        });
    });

    // ---- Criar Produto / Add Product ----
    const formInsertProduto = document.getElementById('formInsertProduto');
    if (formInsertProduto) {
        formInsertProduto.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            const res = await fetch('/products/create', {
                method:  'POST',
                body: formData
            });

            const dados = await res.json();

            if (!dados.success) {
                alert(dados.message || 'Erro ao criar produto.');
                return;
            }

            const novaLinha = `
                <tr>
                    <td data-campo="tamanho" data-id="${dados.id_produto}">${dados.tamanho}</td>
                    <td data-campo="peso" data-id="${dados.id_produto}">${dados.peso}</td>
                    <td data-campo="preco_custo" data-id="${dados.id_produto}">${dados.preco_custo}</td>
                    <td data-campo="stock" data-id="${dados.id_produto}">${dados.stock}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProdutoModal-${dados.id_produto}">Update</button>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProduto-${dados.id_produto}">Delete</button>
                    </td>
                </tr>`;

            const corpo = document.getElementById('corpoTabelaProdutosDB');
            if (corpo) corpo.innerHTML += novaLinha;

            bootstrap.Modal.getInstance(document.getElementById('insertProductModal')).hide();
            this.reset();
        });
    }

    // ---- Editar produto / Update Product ----
    document.querySelectorAll('[id^="formEditProduto-"]').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = this.id.replace('formEditProduto-', '');
            const formData = new FormData(this);

            const res = await fetch('/products/' + id + '/update', {
                method: 'POST',
                body: formData
            });

            if (res.ok) {
                bootstrap.Modal.getInstance(document.querySelector('.modal.show')).hide();
                ['tamanho', 'peso', 'preco_custo', 'stock'].forEach(campo => {
                    const td = document.querySelector(`[data-campo="${campo}"][data-id="${id}"]`);
                    if (td) td.textContent = formData.get(campo);
                });
            }
        });
    });

    // ---- Eliminar produto / Delete Product ----
    document.querySelectorAll('.btnConfirmDeleteProduto').forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
    
            const res = await fetch('/products/' + id + '/delete', { method: 'POST' });
            const dados = await res.json();
    
            if (!dados.success) {
                alert(dados.message || 'Erro ao eliminar produto.');
                return;
            }
    
            bootstrap.Modal.getInstance(document.getElementById('deleteProduto-' + id)).hide();
    
            const linha = document.querySelector(`[data-campo][data-id="${id}"]`)?.closest('tr');
            if (linha) linha.remove();
        });
    });

    // ---- Script de filtragem de Users ----
    function filtrarTabelaUsers() {
        const searchEl = document.getElementById('searchUsersInput');
        const roleEl = document.getElementById('filterRole');
        const statusEl = document.getElementById('filterStatus');
        const creationMinEl = document.getElementById('filterAccountCreationDateMin');
        const creationMaxEl = document.getElementById('filterAccountCreationDateMax');

        if (!searchEl || !roleEl || !statusEl || !creationMinEl || !creationMaxEl) return;

        const search = searchEl.value.toLowerCase();
        const role = roleEl.value.toLowerCase();
        const status = statusEl.value.toLowerCase();
        const accountCreationMin = creationMinEl.value;
        const accountCreationMax = creationMaxEl.value;

        document.querySelectorAll('#corpoTabelaUsersDB tr').forEach(function(linha) {
            const username = linha.cells[1]?.textContent.toLowerCase() || '';
            const roleCell = linha.cells[2]?.textContent.toLowerCase() || '';
            const statusCell = linha.cells[4]?.textContent.toLowerCase() || '';
            const accountCreation = linha.cells[5]?.textContent || '';

            const match =
                username.includes(search) &&
                (role === '' || roleCell.includes(role)) &&
                (status === '' || statusCell.includes(status)) &&
                (accountCreationMin === '' || accountCreation >= accountCreationMin) &&
                (accountCreationMax === '' || accountCreation <= accountCreationMax);

            linha.style.display = match ? '' : 'none';
        });
    }

    const btnLimparFiltrosUsers = document.getElementById('btnLimparFiltrosUsers');
    if (btnLimparFiltrosUsers) {
        btnLimparFiltrosUsers.addEventListener('click', function () {
            document.getElementById('searchUsersInput').value = '';
            document.getElementById('filterRole').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterAccountCreationDateMin').value = '';
            document.getElementById('filterAccountCreationDateMax').value = '';
            filtrarTabelaUsers();
        });
    }

    ['searchUsersInput', 'filterRole', 'filterStatus',
     'filterAccountCreationDateMin', 'filterAccountCreationDateMax']
        .forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', filtrarTabelaUsers);
        });

    // ---- Script de filtragem de ProdutosPai ----
    function filtrarTabela() {
        const search = document.getElementById('searchProduct')?.value.toLowerCase() || '';
        const category = document.getElementById('filterCategory')?.value.toLowerCase() || '';
        const priceMin = parseFloat(document.getElementById('filterPriceMin')?.value) || 0;
        const priceMax = parseFloat(document.getElementById('filterPriceMax')?.value) || Infinity;
        const salesMin = parseFloat(document.getElementById('filterSalesMin')?.value) || 0;
        const salesMax = parseFloat(document.getElementById('filterSalesMax')?.value) || Infinity;
        const revenueMin = parseFloat(document.getElementById('filterRevenueMin')?.value) || 0;
        const revenueMax = parseFloat(document.getElementById('filterRevenueMax')?.value) || Infinity;

        document.querySelectorAll('#corpoTabelaProdutosPaiDB tr').forEach(function(linha) {
            const productName = linha.cells[2]?.textContent.toLowerCase() || '';
            const cat = linha.cells[3]?.textContent.toLowerCase() || '';
            const price = parseFloat(linha.cells[5]?.textContent.replace('€', '')) || 0;
            const sales = parseFloat(linha.cells[7]?.textContent) || 0;
            const revenue = parseFloat(linha.cells[8]?.textContent.replace('€', '')) || 0;

            const match =
                productName.includes(search) &&
                (category === '' || cat.includes(category)) &&
                price >= priceMin && price <= priceMax &&
                sales >= salesMin && sales <= salesMax &&
                revenue >= revenueMin && revenue <= revenueMax;

            linha.style.display = match ? '' : 'none';
        });
    }

    const btnLimparFiltros = document.getElementById('btnLimparFiltros');
    if (btnLimparFiltros) {
        btnLimparFiltros.addEventListener('click', function () {
            ['searchProduct', 'filterCategory', 'filterPriceMin', 'filterPriceMax',
             'filterSalesMin', 'filterSalesMax', 'filterRevenueMin', 'filterRevenueMax']
                .forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
            filtrarTabela();
        });
    }

    ['searchProduct', 'filterCategory', 'filterPriceMin', 'filterPriceMax',
     'filterSalesMin', 'filterSalesMax', 'filterRevenueMin', 'filterRevenueMax']
        .forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', filtrarTabela);
        });

    // ---- Script que adiciona/atualiza posts ----
    const btnSalvarPost = document.getElementById('btnSalvarPost');
    if (btnSalvarPost) {
        btnSalvarPost.addEventListener('click', function () {
            const image = document.getElementById('post-inputImage').value;
            const text = document.getElementById('post-inputText').value;
            const username = document.getElementById('post-inputUsername').value;
            const date = document.getElementById('post-inputDate').value;
            const likeCount = document.getElementById('post-inputLikeCount').value;

            if (!text || !username || !date || !likeCount) {
                alert('Fill all fields!');
                return;
            }

            const post = new Post(null, username, date, text, image, likeCount);

            const novaLinha = `
                <tr>
                    <td><img src="${post.image_post || 'productImage1.jpg'}" alt="post image" style="width: 40px; height: 40px; object-fit: cover;"></td>
                    <td>${post.text_post}</td>
                    <td>${post.id_utilizador}</td>
                    <td>${post.dt_postagem}</td>
                    <td>${post.like_count}</td>
                    <td>
                        <button class="btn btn-sm btn-warning btnUpdatePost">Update</button>
                        <button class="btn btn-sm btn-danger btnDeletePost">Delete</button>
                    </td>
                </tr>`;

            const editIndex = this.dataset.editLinha;
            const tbody = document.getElementById('corpoTabelaPostsDB');

            if (editIndex !== undefined && editIndex !== '') {
                tbody.rows[editIndex].outerHTML = novaLinha;
                delete this.dataset.editLinha;
            } else {
                tbody.innerHTML += novaLinha;
            }

            ['post-inputImage', 'post-inputText', 'post-inputUsername', 'post-inputDate', 'post-inputLikeCount']
                .forEach(id => { document.getElementById(id).value = ''; });

            bootstrap.Modal.getOrCreateInstance(document.getElementById('insertPostModal')).hide();
        });
    }

    // ---- Script de UPDATE e DELETE de Posts ----
    const corpoTabelaPostsDB = document.getElementById('corpoTabelaPostsDB');
    if (corpoTabelaPostsDB) {
        corpoTabelaPostsDB.addEventListener('click', function(e) {
            const linha = e.target.closest('tr');

            if (e.target.classList.contains('btnDeletePost')) {
                linha.remove();
            }

            if (e.target.classList.contains('btnUpdatePost')) {
                const cells = linha.querySelectorAll('td');

                document.getElementById('post-inputImage').value = cells[0].querySelector('img').src;
                document.getElementById('post-inputText').value = cells[1].textContent;
                document.getElementById('post-inputUsername').value = cells[2].textContent;
                document.getElementById('post-inputDate').value = cells[3].textContent;
                document.getElementById('post-inputLikeCount').value = cells[4].textContent;

                document.getElementById('btnSalvarPost').dataset.editLinha = Array.from(
                    document.getElementById('corpoTabelaPostsDB').rows
                ).indexOf(linha);

                bootstrap.Modal.getOrCreateInstance(document.getElementById('insertPostModal')).show();
            }
        });
    }

    const insertPostModal = document.getElementById('insertPostModal');
    if (insertPostModal) {
        insertPostModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('btnSalvarPost').dataset.editLinha = '';
            ['post-inputImage', 'post-inputText', 'post-inputUsername', 'post-inputDate', 'post-inputLikeCount']
                .forEach(id => { document.getElementById(id).value = ''; });
        });
    }
    </script>
</body>
</html>