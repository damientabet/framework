# OpenClassrooms PHP/SYMFONY - Projet 5

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c98335564ffa4051a838f24b8e32df7c)](https://www.codacy.com/app/damientabet/framework?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=damientabet/framework&amp;utm_campaign=Badge_Grade)
[![Maintainability](https://api.codeclimate.com/v1/badges/1e347675a777ba81d686/maintainability)](https://codeclimate.com/github/damientabet/framework/maintainability)

## Résumé du projet

Le projet est donc de développer votre blog professionnel.  
Ce site web se décompose en deux grands groupes de pages :  

-   les pages utiles à tous les visiteurs  
-   les pages permettant d'administrer votre blog  

Voici la liste des pages qui devront être accessibles depuis votre site web :  

-   la page d'accueil  
-   la page listant l'ensemble des blogs posts  
-   la page affichant un blog posts  
-   la page permettant d'ajouter un blog post  
-   la page permettant de modifier un blog post  
-   les pages permettant de modifier/supprimer un blog post  
-   les pages de connexion/enregistrement des utilisateurs  

Vous développerez une partie administration qui devra être accessible uniquement aux utilisateurs inscrits et validées.  
Les pages d'administration seront donc accessible sur conditions et vous veillerez à la sécurité de la partie administration.  
Commençons par les pages utiles à tous les internautes.  

Sur la page d'accueil, il faudra présenter les informations suivantes :  

-   votre nom et prénom  
-   une photo et/ou un logo  
-   une phrase d'accorche qui vous ressemble (exemple : "Martin Durand, le développeur qu'il vous faut !")  
-   un menu permettant de naviguer parmi l'ensemble des pages de votre site web  
-   un formulaire de contact (à la soumission de ce formulaire, un emaul avec toutes ces informations vous serons envoye) avec les champs suivants :  nom/prénom, email de contact, message  
-   un lien vers votre CV au format PDF ; et l'ensemble des liens vers les réseaux sociaux où l'on peut vous suivre (GitHub, LinkedIn, Twitter, ...)  

Sur la page listant tous les blogs posts (du plus récent au plus ancien), il faut afficher les informations suivantes pour chaque blog post :  

-   le titre  
-   la date de dernière modification  
-   le chapô  
-   un lien vers le blog post  

Sur la page présentant le détail d'un blog post, il faut afficher les informations suivantes :  

-   le titre  
-   le chapô  
-   le contenu  
-   l'auteur  
-   la date de dernière mise à jour  
-   le formulaire permettant d'ajouter un commentaire (soumis à validation)  
-   les listes des commentaires validés et publiés  

Sur la page permettant de modifier un blog post, l'utilisateur a la possibilité de modifier les champs suivants :  

-   le titre  
-   le chapô  
-   l'auteur  
-   le contenu  

Dans le footer menu, il doit figurer un lien pour accéder à l'administration du blog.  

## Processus d'installation

### Étape 1

Assurez-vous d'avoir Git installé sur votre machine  

www.git-scm.com  

### Étape 2

Cloner le repository sur votre serveur local  

``git clone https://github.com/damientabet/framework.git``  

### Étape 3

Bien s'assurer que composer est installé sur votre machine  

www.getcomposer.org/doc/00-intro.md  

### Étape 4

Après avoir installé composer, veuillez lancer ``composer install`` à la racine de votre projet.  
Toutes les dépendances vont s'installer et se stocker dans le dossier **/vendor**.  

### Étape 5

Assurez-vous que npm est installé sur votre machine.  

www.npmjs.com/get-npm  

### Étape 6

Se rendre, avec la console, dans le dossier **/public**.  
``cd public/``  

### Étape 7

Lancer ``npm install``  

### Étape 8

Modifier votre fichier **host** afin de faire pointer une url directement vers le fichier **index.php** du dossier **/public**.  

### Étape 9

Créer la base de données en utilisant le fichier présent dans le dossier ``sql/install.sql``.  

### Étape 10

Modifier les accès à votre base de données dans le fichier ``config/config.php``.

### Étape 11

Une fois la base de données créée, ajouter un compte administrateur dans la table ``admin`` grâce à PhpMyAdmin.  
Afin de générer un mot de passe, il est possible d'utiliser un convertisseur.  

www.bcrypt.fr  

### Étape 12

Après avoir installé la totalité du projet et modifier votre fichier host, rendez-vous sur votre **navigateur web** pour lancer la page d'accueil du site.  
