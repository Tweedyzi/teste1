<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
?>

<header class="flex justify-between items-center p-6 max-w-7xl mx-auto">
  <h1 class="text-2xl font-bold text-purple-400">GameForgeAI</h1>
  <nav class="space-x-6 text-gray-300">
    <a href="/index.html" class="hover:text-white">Accueil</a>
    <a href="/creer-un-jeu.html" class="hover:text-white">Créer</a>
    <a href="/a-propos.html" class="hover:text-white">À propos</a>
    <a href="/premium.html" class="hover:text-white">Premium</a>

    <?php if ($isLoggedIn): ?>
      <a href="/mes-jeux.html" class="hover:text-white">Mes jeux</a>
      <a href="/php/logout.php" class="text-red-400 hover:text-red-300">Déconnexion</a>
    <?php else: ?>
      <a href="/connexion.html" class="hover:text-white">Connexion</a>
      <a href="/inscription.html" class="hover:text-white">Inscription</a>
    <?php endif; ?>
  </nav>
</header>
