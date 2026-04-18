# Réseau d'Organisations (RAO)

Cette section gère l'affichage complet des organisations sur la page publique.

## 1. Flux Backend (RaoController)
La liste de toutes les ONG et le profil détaillé d'une ONG proviennent de `App\Http\Controllers\RaoController`.
Dans la méthode `show($slug)`, le système charge le profil de l'organisation associée au `$slug`. Pour optimiser et nettoyer le format json envoyé, on utilise `OrganizationResource`.

```php
// RaoController.php
$organization->load(['categories', 'projects' => function ($query) {
    $query->where('status', 'active'); // Ne charger que les projets en cours
}]);
return inertia('Rao/Show', [
    'organization' => new OrganizationResource($organization)
]);
```

`OrganizationResource` contient les règles permettant de définir quelles infos secrètes on ne donne *pas* à l'utilisateur et assure le bon lien (le système `asset('storage/...')`) des logos, des couvertures et galeries des projets.

## 2. Le Profil Frontend (Rao/Show.vue)
Dans Vue :
L'interface de la page utilise Inertia. On reçoit l'`organization` qu'on affiche sous forme de Grid CSS. 
S'il y a des projets, ils sont récupérés via `org.projects` et listés en bas sous forme de petites cartes.

```html
<div v-for="project in org.projects" :key="project.id"> ... </div>
```
Si le projet a des petites photos supplémentaires dans la galerie, elles sont parcourues et affichées en scroll horizontal : 
```html
<div v-for="(img, idx) in project.gallery" class="h-16 w-16 flex..."> <img :src="img"> </div>
```

*Comment modifier ?*
* **Si vous créez un nouveau champ "site web secondaire" sur une Organisation :** 
  1. Créez la migration
  2. Ajoutez aux fillables de `Organization`
  3. Ajoutez `$this->site_web_secondaire` dans `OrganizationResource`
  4. Récupérez et affichez avec `{{ org.site_web_secondaire }}` sur `Rao/Show.vue`.
