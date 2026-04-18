# Administration et Approbation

L'administrateur système (l'équipe derrière RAOSC/ABEC) doit pré-approuver ou rejeter les demandes de création d'organisations.

## 1. Le Tableau de Bord Administrateur
La page `Admin/Organizations.vue` lève la liste des demandes (`pending`) et des actions récentes (`recent`), fournie par `Admin\OrganizationManagementController::class`.

## 2. Le Composant Approbation (AdminApprovalCard.vue)
Contrairement aux vues Vue3 classiques, nous voulons envoyer une action POST rapidement (sans pour autant charger la page visuellement - SPA concept).

L'approbation se fait en redirigeant un lien `method="post"` vers le backend. 
```html
<Link 
     :href="updateStatusAction(organization.id).url" 
     method="post"
     :data="{ status: 'approved' }"
     as="button"
>
     Approuver l'OSC
</Link>
```
Le rejet a plus de conséquences puisqu'il demande un motif pour aider à s'améliorer. Nous utilisons là une balise `<form ...>` pure, interceptée par `router.post()` d'InertiaJS pour envoyer les requêtes sans causer un chargement dur de la plateforme.

## 3. Mécanisme Backend
Le contrôleur `updateStatus` modifie la ligne en Base de données de l'Organisation. `status` bascule à `approved` ou `rejected`. 
Ensuite, pour la communication, ce bout de code finalise : 
Il utilise le système de `notification` de Laravel (les classes `App\Notifications\*`). Il enverra une notification soit en tableau sur le site, ou à l'email du "Créateur" de la demande. Vous le trouverez dans le dossier Notifications.

*Comment modifier ?*
* **Envoyer également un SMS Admin :** Intégrez Twilio (ou autre) via le système `Notification` de Laravel, modifiez la méthode `via()` dans `OrganizationStatusChanged.php` pour ajouter le Driver SMS et implémentez-y la fonction de construction du message!
