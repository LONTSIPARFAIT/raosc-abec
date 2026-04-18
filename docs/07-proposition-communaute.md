# Proposition Stratégique : Module "Communauté"

La page ou le portail "Communauté" joue un rôle très différent de celui des "Actualités".
Alors que les **Actualités** (Posts) sont les communiqués officiels des organisations (ce que fait l'ONG), la **Communauté** devrait être un espace d'interaction bidirectionnelle, d'échange ou de rassemblement global ("The Hub").

Voici 3 scénarios logiques de développement possibles pour votre plateforme RAOSC :

## Cas 1 : Le Forum d'Entraide (Style StackOverflow / Discussions)
C'est le format recommandé si le but du réseau RAOSC est d'aider les ONG à collaborer ensemble.
*   **Fonctionnement :** N'importe quel membre vérifié d'une organisation pose une question ("Comment obtenir une subvention internationale pour l'eau ?") ou initie un débat.
*   **Les modules à coder :** 
    - `Discussion` (titre, contenu, auteur id, tags).
    - `Reply/Comment` (les réponses des autres ONG).
*   **Avantages :** Rajeunit la plateforme, maintient les vues constantes, aide à la formation croisée.

## Cas 2 : La Bibliothèque de Ressources (Style Wikipedia / Blog partagé)
Si l'objectif de la "Communauté" est le partage des compétences documentées. 
Il s'agit donc bien "d'articles", mais **pas de type actualité**.
*   **Fonctionnement :** Seuls quelques experts ou membres d'org valident des articles de *méthodologie* ou de *tutoriels* (ex: "Guide pour bien mener une campagne de reboisement").
*   **Spécificité :** Un système de tags croisés (Education, Ecologie). Les utilisateurs viendront rechercher un savoir.
*   **Avantages :** Construit le capital intellectuel du RAOSC pour l'Afrique. 

## Cas 3 : Le Mur "Pulse / Timeline" (Style LinkedIn abrégé)
Utile si vous voulez dynamiser la page sans faire un grand forum lourd.
*   **Fonctionnement :** Les volontaires et ONG postent simplement des petites mises à jour, "bravo pour la mission", une photo spontanée, recherche de bénévoles express.
*   **Style Visuel :** Une timeline verticale sur la page `/community`.  
*   **Avantages :** Très facile à maintenir et invite les jeunes à participer plus librement sur téléphone.

***

### Ma Recommandation Idéale pour RAOSC
Pour commencer, je vous recommanderais le **Cas 1 + 2 fusionnés : Un "Hub de Discussions & Ressources"**. 
Concrètement, dans Laravel :
1. Créez un modèle `Thread` (Sujet).
2. Ajoutez un paramètre `is_resource` (boolean). Les sujets normaux sont des débats entre organisations, et ceux cochés *Ressources* sont épinglés en haut (guides PDF, fiches conseil ABEC...).
3. Le tout géré sur une grille très propre avec un composant `CommunityForum.vue`.

Si cela vous intéresse, la prochaine étape serait de : "Créer le composant Thread, implémenter un mini-forum, et permettre aux utilisateurs connectés de poster !". Qu'en dites-vous ?
