<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand">
        <img src = "/public/assets/images/logo.png" alt = "logo" width = "50" height = "50">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="/Views/index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link active" href="/Views/animaux.php">Nos Résidents</a></li>
        <li class="nav-item"><a class="nav-link active" href="/Views/services.php">Nos Services</a></li>
        <li class="nav-item"><a class="nav-link active" href="/Views/inscription.php">Inscription</a></li>
      </ul>
      <button id="auth-button" onclick="toggleAuth()">Connexion</button>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  let isAuthenticated = false;

  function toggleAuth() {
    const authButton = document.getElementById('auth-button');
    if (!isAuthenticated) {
      // Redirection vers la page connexion.php
      window.location.href = "/Views/connexion/index.php";
    } else {
      // Déconnexion
      authButton.textContent = 'Connexion';
      isAuthenticated = false;
    }
  }
</script>
</body>
</html>
