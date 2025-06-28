# GameForgeAI 🎮

GameForgeAI est une plateforme web alimentée par l'intelligence artificielle, permettant à n'importe qui de **créer un jeu vidéo** simplement en décrivant une idée en texte.

## 🚀 Fonctionnalités

- ✍️ Génération de jeux vidéo à partir de prompts IA (OpenAI GPT-4)
- ⚙️ Choix de la plateforme : HTML5 (navigateur) ou Godot (PC)
- 📦 Téléchargement automatique du projet généré au format `.zip`
- 👤 Gestion des utilisateurs (inscription, connexion, session)
- 💳 Système de crédits IA (3 générations gratuites)
- 💎 Section Premium (bientôt disponible)
- 📱 Design moderne et responsive avec TailwindCSS

## 📁 Structure du projet
<pre><code>
📦 GameForgeAI/
├── index.html
├── creer-un-jeu.html
├── connexion.html / inscription.html
├── mes-jeux.html / premium.html / a-propos.html
├── config/config.php
├── data/users.json / jeux/
├── php/*.php (backend complet)
├── js/app.js
├── style/tailwind.css
└── README.md  </code></pre>

## ⚙️ Configuration requise

- Serveur compatible PHP (ex: XAMPP, Render.com, etc.)
- PHP 7.4 ou supérieur
- Une clé OpenAI valide (à ajouter dans `config/config.php`)

## 🔐 Ajouter votre clé OpenAI

Dans `config/config.php`, remplacez :

```php
define('OPENAI_API_KEY', 'sk-votre_clé_ici');
