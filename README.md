# Plateforme QCM en ligne

Application web simple permettant aux **professeurs** de créer des QCM et aux **étudiants** de les passer en ligne, avec consultation des résultats. Développée en **HTML**, **CSS** et **PHP**.

## Fonctionnalités

- Création de compte étudiant
- Connexion séparée pour étudiants et professeurs
- Tableau de bord professeur (gestion des QCM)
- Tableau de bord étudiant (accès aux QCM disponibles)
- Création de QCM par le professeur
- Passage d'un QCM par l'étudiant
- Enregistrement automatique des réponses
- Consultation des résultats
- Déconnexion sécurisée

## Structure du projet

| Fichier | Description |
|---|---|
| `index.php` | Page d'accueil du site |
| `login_etud.php` | Connexion étudiant |
| `login_prof.php` | Connexion professeur |
| `creer_compte_etudiant.php` | Inscription d'un nouvel étudiant |
| `dashboard_etud.php` | Tableau de bord étudiant |
| `dashboard_prof.php` | Tableau de bord professeur |
| `creer_qcm.php` | Création d'un nouveau QCM par le professeur |
| `passer_qcm.php` | Page permettant à l'étudiant de répondre au QCM |
| `enregistrer_reponses.php` | Traitement et enregistrement des réponses de l'étudiant |
| `voir_resultats.php` | Affichage des résultats du QCM |
| `logout.php` | Déconnexion de l'utilisateur |

## Prérequis

- [XAMPP](https://www.apachefriends.org/) (ou WAMP/MAMP) avec Apache, PHP et MySQL
- Un navigateur web

## Installation

1. Cloner ou télécharger ce dépôt :
   ```bash
   git clone https://github.com/yahyasafadi/<nom-du-depot>.git
   ```
2. Copier le dossier du projet dans le répertoire `htdocs` de XAMPP (ou équivalent).
3. Créer une base de données MySQL (par exemple `qcm_db`) via phpMyAdmin et importer le fichier `.sql` de la base si disponible.
4. Vérifier les informations de connexion à la base de données dans le code PHP (hôte, utilisateur, mot de passe, nom de la base).
5. Démarrer Apache et MySQL depuis le panneau de contrôle XAMPP.

## Utilisation

1. Ouvrir un navigateur et aller à :
   ```
   http://localhost/<nom-du-dossier-projet>/index.php
   ```
2. **Étudiant** : créer un compte via `creer_compte_etudiant.php`, puis se connecter via `login_etud.php`.
3. **Professeur** : se connecter via `login_prof.php`, puis créer un QCM via `creer_qcm.php`.
4. L'étudiant peut ensuite passer le QCM (`passer_qcm.php`) et consulter ses résultats (`voir_resultats.php`).

## Technologies utilisées

- **HTML5 / CSS3** — structure et mise en forme des pages
- **PHP** — logique côté serveur et gestion des sessions
- **MySQL** — stockage des comptes, QCM, questions et réponses

## Auteur

Projet développé par **yahyasafadi**.
