<?php include __DIR__ . "/../../includes/header.php"; ?>

<style> body { background-color: black; } </style>

<?php if (isset($_SESSION['flash_error'])): ?>
  <div class="alert alert-danger">
    <?php echo $_SESSION['flash_error']; ?>
    <?php unset($_SESSION['flash_error']); ?>
  </div>
<?php endif; ?>

<div class="container-fluid bg-black">
  <div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-5 col-lg-4">
      <div class="card bg-black text-white" style="border: 2px solid white;">
        <div class="card-body p-5 text-center">

          <img src="/<?= htmlspecialchars($user->getImage() ?? 'assets/images/users/user_icon.png') ?>"
               alt="avatar" width="80" height="80"
               class="rounded-circle mb-3" style="object-fit:cover;">

          <h5 class="mb-0"><?= htmlspecialchars($user->getUsername()) ?></h5>
          <p class="text-white-50 mb-3"><?= htmlspecialchars($user->getEmail()) ?></p>

          <?php if (AuthMiddlewareWeb::canEditProfile($user->getId())): ?>
            <hr style="border-color: white;">
            <h6 class="mb-3 text-start">Editar Perfil</h6>
            <form method="POST" action="/users/<?= $user->getId() ?>/update">
              <input name="username" value="<?= htmlspecialchars($user->getUsername()) ?>"
                     class="form-control bg-black text-white border-light mb-2" placeholder="Username" required>
              <input name="email" value="<?= htmlspecialchars($user->getEmail()) ?>"
                     type="email" class="form-control bg-black text-white border-light mb-2" placeholder="Email" required>
              <button class="btn btn-outline-light w-100 mt-3">Guardar</button>
            </form>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . "/../../includes/footer.php"; ?>