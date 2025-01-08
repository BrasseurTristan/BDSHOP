# 📚 BDSHOP - CRUD Backoffice (Cours PHP) 

 Bienvenue dans le dépôt de **BDSHOP**, un projet réalisé dans le cadre d'un cours PHP. Ce projet consiste à développer un backoffice permettant de gérer les **bandes dessinées** d'une boutique fictive appelée **BDSHOP** en utilisant un CRUD (Create, Read, Update, Delete). 
 
---
## 📋 Fonctionnalités du CRUD

Le backoffice permet d'effectuer les actions suivantes :

- **Créer** une nouvelle BD
- **Lire** la liste des BD disponibles
- **Mettre à jour** les informations d'une BD
- **Supprimer** une BD

 Ce projet utilise : 
 
- **PHP** pour le backend
- **MySQL** pour la base de données
- **phpMyAdmin** pour la gestion de la base de données 
- --- 
- ## 🚀 Installation du projet 

 ### ✅ Prérequis
 
- Un serveur local (**XAMPP**, **WAMP** ou **MAMP**)
- **phpMyAdmin** pour gérer la base de données 
- Un virtualHost
- --- 
 ### 📂 Étapes pour installer la base de données 
 
1. **Démarrez votre serveur local (Apache & MySQL)**
2. **Accédez à phpMyAdmin** depuis votre navigateur : 
 Exemple : `http://localhost/phpmyadmin` 
1. **Créez une nouvelle base de données** appelée `bdshop`.
2. **Importez le fichier SQL** fourni dans le projet : 
	- Rendez-vous dans l'onglet **Importer**.
	- Cliquez sur **Choisir un fichier**, puis sélectionnez le fichier `bdshop.sql`. 
	- Cliquez sur **Exécuter**. 
3. Éxecuter ensuite le script suivant pour créer la table admin 
    ```SQL
    CREATE TABLE `table_admin` (
        `admin_id` INT NOT NULL AUTO_INCREMENT , 
        `admin_lastname` VARCHAR(255) NULL , 
        `admin_firstname` VARCHAR(255) NULL , 
        `admin_mail` VARCHAR(255) NULL , 
        `admin_password` VARCHAR(255) NULL , 
        PRIMARY KEY (`admin_id`)) ENGINE = MyISAM;

    ```
4. Créez votre compte avec la requête suivante en replacant les valeurs:
	```SQL
	INSERT INTO `table_admin` ( `admin_lastname`, `admin_firstname`, `admin_mail`, `admin_password`) 
    VALUES ( '**NOM**', '**PRENOM**', '**EMAIL**', '**MOT DE PASSE HASHÉ**');
	```
- --- 
- ### 📂 Structure du projet 
 ```bash
BDSHOP/ 
├── index.php # Page d'accueil du backoffice 
├── admin/
│      ├──product/
│      │     ├──index.php # Page pour afficher les BDs 
│      │     ├──form.php # Page pour ajouter ou modifier une BD
│      │     ├──process.php # Page pour le traitement lors de l'ajout ou la modification d'une BD
│      │     └──delete.php # Page pour supprimer une BD
│      └──includes/
│            ├──connect.php # Page qui permet de faire la connexion à la base de données
│            └──protect.php # Page qui vérifie la variable globale $_SESSION
└── ressources/
        ├──images/

```