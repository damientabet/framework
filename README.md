# OpenClassrooms PHP/SYMFONY - Projet 5
## Résumé du projet
Le projet est donc de développer votre blog professionnel. Ce site web se décompose en deux grands groupes de pages :
les pages utiles à tous les visiteurs ;
les pages permettant d’administrer votre blog.
Voici la liste des pages qui devront être accessibles depuis votre site web :
- la page d'accueil ;
- la page listant l’ensemble des blogs posts ;
- la page affichant un blog post ;
- la page permettant d’ajouter un blog post ;
- la page permettant de modifier un blog post.
- les pages permettant de modifier/supprimer un blog post ;
- les pages de connexion/enregistrement des utilisateurs.  

Vous développerez une partie administration qui devra être accessible uniquement aux utilisateurs inscrits et validés.
Les pages d’administration seront donc accessible sur conditions et vous veillerez à la sécurité de la partie administration.
Commençons par les pages utiles à tous les internautes.
Sur la page d’accueil il faudra présenter les informations suivantes :
- Votre nom et prénom ;
- Une photo et/ou un logo ;
- Une phrase d’accroche qui vous ressemble ( exemple : “Martin Durand, le développeur qu’il vous faut !”) ;
- Un menu permettant de naviguer parmi l’ensemble des pages de votre site web ;
- Un formulaire de contact (à la soumission de ce formulaire, un email avec toutes ces informations vous serons envoyé) avec les champs suivants :
    - nom/prénom
    - email de contact
    - message
- un lien vers votre CV au format pdf ; et l’ensemble des liens vers les réseaux sociaux où l’on peut vous suivre (Github, LinkedIn, Twitter…).  

Sur la page listant tous les blogs posts (du plus récent au plus ancien), il faut afficher les informations suivantes pour chaque blog post :
- le titre ;
- la date de dernière modification ;
- le châpo ;
- et un lien vers le blog post.  

Sur la page présentant le détail d’un blog post, il faut afficher les informations suivantes :
- le titre ;
- le chapô ;
- le contenu ;
- l’auteur ;
- la date de dernière mise à jour ;
- le formulaire permettant d’ajouter un commentaire (soumis pour validation) ;
- les listes des commentaires validés et publiés.

Sur la page permettant de modifier un blog post, l’utilisateur a la possibilité de modifier les champs titre, chapô, auteur et contenu.  
Dans le footer menu, il doit figurer un lien pour accéder à l’administration du blog.
## Processus d'installation
### Étape 1 :
- Cloner le repository avec le lien suivant : https://github.com/damientabet/framework.git
### Étape 2 :
- Bien s'assurer que composer est installé sur votre machine
- Lancer ``composer install`` à la racine
### Étape 3 :
- Bien s'assurer que npm est installer sur votre machine
- Se rendre, avec la console, dans le dossier **/public** ``cd public/``
- Lancer ``npm run``
### Étape 4 :
Modifier votre fichier **host** afin de faire pointer une url directement vers le dossier **/public**
## Lancer le projet
Après installé le projet et modifier votre fichier host.  
Rendez-vous sur votre **navigateur web** pour lancer la page d'accueil du site.
