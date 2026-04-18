# Accueil et Affichage des Statistiques

Ce dossier explique comment la page d'accueil affiche les données réelles et animées depuis le contrôleur jusqu'au frontend, tel que vous voyez sur la plateforme.

## 1. La collecte des données (Backend : routes/web.php)
Dans le fichier `routes/web.php`, la route principale `/` interroge la base de données :

```php
Route::get('/', function () {
    return inertia('Welcome', [
        'organizations' => \App\Models\Organization::with('categories')
                               ->where('status', 'approved')->latest()->take(3)->get(),
        'stats' => [
            'organizations_count' => \App\Models\Organization::where('status', 'approved')->count(),
            'categories_count' => \App\Models\OrganizationCategory::count(),
            'projects_count' => \App\Models\Project::count(),
            'countries_count' => \App\Models\Organization::where('status', 'approved')->distinct('country')->count('country'),
        ]
    ]);
});
```
*Ici, toutes les vraies données (combien d'ONG approuvées, de pays touchés, de projets) sont comptées et injectées dans une variable `stats`.*

## 2. Réception par la Page (Frontend : Welcome.vue)
La page `Welcome.vue` reçoit les `stats` via `defineProps<{ stats: any }>()`. 
Ensuite, pour garder le code de `Welcome.vue` lisible, ces données sont formatées puis passées à un sous-composant `StatsSection.vue`.

Exemple de formatage dans `Welcome.vue` :
```typescript
const statsData = [
    { id: 1, name: 'Organisations Actives', value: props.stats.organizations_count.toString(), icon: Users, ... },
    { id: 2, name: 'Pays Couverts', value: props.stats.countries_count.toString(), icon: Globe, ... }
]
// Et dans le template :
<StatsSection :stats="statsData" />
```

## 3. L'Affichage Visuel (StatsSection.vue)
`StatsSection.vue` reçoit le tableau formaté et utilise une barre `v-for` pour dessiner les boîtes magnifiquement présentées (avec leurs icônes `Lucide-vue-next`). 

*Comment modifier ?*
* **Pour ajouter une statistique en plus :** Ajoutez la logique dans `web.php` ; puisajoutez le résultat dans le tableau `statsData` de `Welcome.vue`.
* **Pour changer la couleur de la section stats :** Editez les classes Tailwind CSS dans `StatsSection.vue` (la balise principale en haut `bg-white dark:bg-zinc-950`).
