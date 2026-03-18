# RAO - Réseau Africain des Organisations (ABEC)

Bienvenue sur le dépôt du projet **RAO**. Cette plateforme est conçue pour regrouper, valider et promouvoir les différentes organisations œuvrant pour le bien-être communautaire en Afrique, sous l'égide de l'**ABEC**.

## 🚀 Stack Technique

Le projet est basé sur des technologies modernes et robustes afin d'assurer performance, maintenabilité, et une excellente expérience utilisateur (UI/UX) :

*   **Backend:** [Laravel 12](https://laravel.com/) (PHP 8.2+)
*   **Frontend:** [Vue.js 3](https://vuejs.org/) (Composition API) via [Inertia.js](https://inertiajs.com/)
*   **Styling:** [Tailwind CSS v4](https://tailwindcss.com/)
*   **Base de données:** MySQL (ou SQLite en environnement de développement)
*   **Build Tool:** Vite

## 📁 Architecture du Projet

Afin de faciliter la maintenance, le projet suit de près les standards Laravel & Vue, en y ajoutant une couche d'abstraction structurante :

### Backend (Laravel)
*   **Modèles (`app/Models`) :** Représentent les entités de la BDD (`Organization`, `OrganizationCategory`, `OrganizationMember`).
*   **Contrôleurs (`app/Http/Controllers`) :** La logique applicative (ex: `RaoController`).
*   **Ressources API (`app/Http/Resources`) :** Nous utilisons les API Resources de Laravel (ex: `OrganizationResource`) pour formater les données qui sont envoyées au front-end via Inertia. Cela permet de cacher les données sensibles et d'avoir une structure JSON standardisée.
*   **Routes (`routes/web.php`) :** Les routes web standards retournant des composants Inertia.

### Frontend (Vue 3 / Inertia)
*   **Pages (`resources/js/pages`) :** Les vues principales appelées par les contrôleurs. Ex: `Rao/Index.vue` (L'annuaire public), `Rao/Show.vue` (Le profil public d'une orga).
*   **Layouts (`resources/js/layouts`) :** Les structures enveloppantes (ex: `AppLayout.vue`).
*   **Composants (`resources/js/components`) :** Des composants réutilisables (Boutons, Cartes UI, Badges) inspirés du design system `shadcn-vue`.

## 🎨 Philosophie de Design (UI/UX)

L'application utilise un **Design Moderne et Premium** :
- **Glassmorphism :** Utilisation de composants subtilement transparents avec effet de flou (`backdrop-blur`).
- **Gradients Abstraits :** Des arrière-plans complexes et chaleureux, rappelant le sérieux du projet.
- **Micro-interactions :** Animations fluides au survol (hover) pour un rendu "vivant".

## 🌱 Base de données & Seeders

Pour lancer le projet rapidement en local, des données réalistes ont été préparées :
1.  **Catégories :** `$ php artisan db:seed --class=OrganizationCategorySeeder` (Insère 8 secteurs d'activités pertinents).
2.  **Organisations :** `$ php artisan db:seed --class=OrganizationSeeder` (Génère 5 organisations d'exemples très réalistes avec images de couvertures, logos, de vraies descriptions et associées aux catégories).

## 🚀 Installation & Configuration

### 1. Cloner le projet
```bash
git clone <url-du-depot>
cd raosc
```

### 2. Dépendances PHP & JavaScript
```bash
composer install
npm install
```

### 3. Configuration de l'environnement
```bash
cp .env.example .env
php artisan key:generate
```
*Configurez votre base de données dans le fichier `.env`.*

### 4. Base de données & Données de test
```bash
php artisan migrate --seed
```

### 5. Lancement du projet
```bash
npm run dev
php artisan serve
```

## 📧 Notifications par Email
L'application envoie des notifications automatiques aux organisations (approbation/rejet). Pour activer l'envoi réel d'emails, configurez les variables suivantes dans votre `.env` :
- `MAIL_MAILER=smtp`
- `MAIL_HOST=...`
- `MAIL_PORT=...`
- `MAIL_USERNAME=...`
- `MAIL_PASSWORD=...`
- `MAIL_FROM_ADDRESS="no-reply@raosc.org"`

## 💡 Remarques de Maintenance
- **Données frontend :** Ne modifiez pas l'envoi de données directement dans le contrôleur. Utilisez toujours les *Resources* (`App\Http\Resources\*`) pour structurer ce qu'Inertia.js enverra à Vue.js.
- **Composants UI :** Si un bouton ou une carte (Card) doit être modifié partout, modifiez-le dans `resources/js/components/ui/`.
- **Accès Admin :** Pour tester le côté administration, assurez-vous que votre utilisateur a la valeur `admin` dans la colonne `role` de la table `users`.
