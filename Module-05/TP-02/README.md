# Système de Gestion d'Utilisateurs

Ce projet est un système de gestion d'utilisateurs simple mais sécurisé, développé en utilisant PHP, HTML, CSS, et MySQL. Il permet aux utilisateurs de s'inscrire, de se connecter, de visualiser et de modifier leurs informations sur le tableau de bord, et de supprimer leur compte.

## Fonctionnalités

- Inscription des utilisateurs avec vérification de l'unicité de l'email.
- Connexion et déconnexion des utilisateurs.
- Tableau de bord utilisateur pour afficher et modifier les informations personnelles.
- Possibilité pour les utilisateurs de supprimer leur compte.
- Mesures de sécurité comprenant la prévention contre les attaques XSS, CSRF, et l'injection SQL.
- Hashage des mots de passe utilisateur.

## Installation

Pour exécuter ce projet, assurez-vous que PHP et MySQL sont installés sur votre serveur. Vous devez également créer une base de données MySQL et configurer les informations de connexion dans `model.php`.

1. Clonez le dépôt ou téléchargez les fichiers sur votre serveur.
2. Créez une base de données MySQL et importez le schéma fourni.
3. Configurez les informations de connexion à la base de données dans `functions/model.php`.
4. Accédez à `index.php` depuis votre navigateur pour démarrer l'application.

## Sécurité

Ce projet implémente plusieurs mesures de sécurité, y compris mais sans se limiter à :

- Sanitisation des entrées utilisateur pour prévenir les attaques XSS.
- Utilisation de tokens CSRF pour prévenir les attaques CSRF.
- Hashage des mots de passe avec des algorithmes robustes.
- Prévention des injections SQL grâce à l'utilisation de requêtes préparées.