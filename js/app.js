// JavaScript du site
// Charger dynamiquement les crédits IA (si utilisé dans le header ou premium)
async function loadUserCredits(displayId = "creditCount") {
  try {
    const res = await fetch("php/credit-check.php");
    const data = await res.json();
    if (data.success && data.credits !== undefined) {
      document.getElementById(displayId).textContent = data.credits;
    } else {
      document.getElementById(displayId).textContent = "0";
    }
  } catch (err) {
    console.error("Erreur lors du chargement des crédits IA :", err);
    document.getElementById(displayId).textContent = "—";
  }
}

// Redirige vers connexion si utilisateur non connecté
async function verifySessionOrRedirect() {
  try {
    const res = await fetch("php/session.php");
    const data = await res.json();
    if (data.error) {
      window.location.href = "connexion.html";
    }
  } catch (e) {
    window.location.href = "connexion.html";
  }
}

// Utilitaire pour afficher une alerte (ex. : erreur, succès)
function showMessage(text, type = "info") {
  const color = {
    info: "bg-blue-600",
    success: "bg-green-600",
    error: "bg-red-600"
  }[type] || "bg-gray-700";

  const box = document.createElement("div");
  box.className = `${color} text-white px-4 py-2 rounded fixed top-6 right-6 shadow-lg z-50`;
  box.textContent = text;
  document.body.appendChild(box);

  setTimeout(() => box.remove(), 4000);
}
