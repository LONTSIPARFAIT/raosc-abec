# Architecture Globale et Principes de Fonctionnement

Ce fichier explique brièvement comment l'application est structurée pour qu'un développeur entrant puisse facilement se repérer et faire des modifications.

## La pile technique (Stack)
Le projet utilise **Laravel** pour le (Backend) et **Vue 3 avec Composition API** propulsé par **Inertia.js** pour le (Frontend).
Il n'y a pas d'API REST classique, Inertia s'occupe du pont en récupérant les données des contrôleurs Laravel directement comme Propriétés (`Props`) dans les composants Vue.

## Dossiers clés :
- `routes/web.php` : C'est ici que toutes les URL que les utilisateurs visitent sont déclarées. Chaque route renvoie une fonction d'un Contrôleur.
- `app/Http/Controllers/` : Contient la logique d'obtention des données (via les Model `app/Models/`) puis envoie ces données à la vue via `return inertia('NomDuComposant', [...data])`.
- `resources/js/pages/` : Contient les vues complètes (les pages) de l'application (ex: `Welcome.vue`).
- `resources/js/components/` : Contient des fragments de code réutilisables appelés par les pages (ex: bouton, section statistiques, carte d'une organisation).

## Modifier ou Ajouter une page
1. Créer le composant Vue dans `resources/js/pages/NouvellePage.vue`.
2. Ouvrir `routes/web.php` et créer une route : `Route::get('/nouvelle', [Controlleur::class, 'methode'])`.
3. Dans la méthode du contrôleur, faire les requêtes de données et renvoyer la vue : `return inertia('NouvellePage', ['titre' => 'Mon Titre']);`.
4. Dans `NouvellePage.vue`, déclarer `defineProps<{ titre: string }>()` pour utiliser les données.

> Note importante pour la maintenance : *Si vous modifiez une table de la base de données (ajout d'une colonne), vous devez modifier son `Model` (ajout dans fillables), son `Resource` (app/Http/Resources) pour que la donnée passe vers le JS, et son Seeder.*
