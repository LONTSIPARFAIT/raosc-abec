# Actualités (Posts)

Le module d'actualités permet à une Organisation de publier des articles décrivant son impact.

## 1. Création Vue Dashboard
Rendue possible par `PostController` qui est accessible depuis `/dashboard/posts`. Les articles sont enregistrés dans la table `posts`. Le contenu principal provient d'une string contenant des retours à la ligne (souvent reformatée à l'affichage).

## 2. Visuels sur la plateforme (`Posts/Show.vue`)
L'article est retourné avec la fonction `show` dans `PostController`.
Détail astucieux : le contrôleur charge et renvoie EN PLUS la liste des autres Projets (limité à 4) appartenant à l'association créatrice de cet article !

```php
$otherProjects = $post->organization->projects()->where('status', 'active')->latest()->take(4)->get();
```

En bas de `Posts/Show.vue`, vous constaterez que la plateforme vous incite doucement et joliment à "Découvrir les autres initiatives de l'Organisation" (grâce à ses Projets qu'elle affiche en bas d'article avec les couvertures respectives !).

*Comment modifier ?*
* **Pour activer le WYSIWYG :** Si on veut du Text enrichi classique, on peut installer un module comme `TipTap Vue`, formater le champ Post du formulaire, enregistrer le HTML dans la table. Il faudra ensuite changer l'affichage public en utilisant la balise Vue spéciale `v-html="post.content"` sur `Posts/Show.vue`.
