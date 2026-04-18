# Projets, Bénévolats et Gestion d'Images Multiples

Ces éléments sont essentiels pour qu'une ONG publie localement son travail. 
Les projets ont la particularité de posséder une couverture visuelle ET une galerie photo (les images peuvent être optionnelles).

## 1. La Base de données (Modèle et Migration)
Le modèle `Project.php` a une colonne spéciale de type `JSON` nommée `gallery`.
Laravel prend en charge ce format via `casts` :
```php
protected $casts = [
    'gallery' => 'array',
];
// En base, c'est enregistré converti format JSON, mais dans Laravel on peut le parcourir comme un array ($project->gallery).
```

## 2. Le Contrôleur (Dashboard\ProjectController.php)
Il récupère le formulaire soumis depuis l'interface d'administration de l'organisation. L'upload de la galerie se déroule ici :
```php
  if ($request->hasFile('gallery')) {
      $galleryPaths = [];
      foreach ($request->file('gallery') as $image) {
          // Range physiquement le fichier dans /storage/app/public/projects/gallery
          $galleryPaths[] = $image->store('projects/gallery', 'public');
      }
      $validated['gallery'] = $galleryPaths; // Range les liens dans la BD JSON
  }
```

## 3. Le Formulaire Vue.js (Dashboard/Projects.vue)
C'est la pièce maîtresse. Puisqu'il permet les galeries locales avant même la soumission du formulaire :
1. Quand l'image entre  `@change="handleGalleryUpload"`, `URL.createObjectURL(file)` crée une mini-URL d'aperçu temporaire visible à l'écran. 
2. Si vous supprimez l'aperçu (`X`), le composant retranche aussi ce fichier de l'array `projectFormData.gallery`. Vue.js étant réactif, le compteur s'ajuste instantanément.

*Comment modifier ?*
* **Pour permettre les PDF :** Changez `accept="image/*"` en `accept=".pdf, image/*"` du `<input type="file">`. Puis modifiez le validateur array du controlleur `('gallery.*' => 'image')` vers `('gallery.*' => 'mimes:jpeg,png,pdf')`.
