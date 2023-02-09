CREATE DATABASE IF NOT EXISTS `projet`
CREATE TABLE `client`(
    `id_client` INT(10) PRIMARY KEY NOT NULL AUTO8INCREMENT,
    `nom_client` VARCHAR(250) COLLATE utf8_general_ci,
    `prenom_client`VARCHAR (250)COLLATE utf8_general_ci,
    `emai_client`VARCHAR(250) COLLATE utf8_general_ci,
    `telephone_client`INT(12),
    `etat_client`ENUM('actif','radié') COLLATE utf8_general_ci,
    `date_client` DATE()
);
/* inserer des données table client*/
INSERT INTO `client`(`nom_client`,`prenom_client`,`emai_client`,`telephone_client`,`etat_client`,`date_client`)
VALUES
('larregain','joseph','larregain.joseph@gmail.com','0220022002','actif','CURDATE()'),
('leger','gerald','geralde.leger@gmail.com','0656341528','radié','CURDATE()');
/*deuxime methode d'inserction*/
INSERT INTO `client` SET 
    `nom_client`= 'hareaux',
    `prenom_client` = 'kevin',
    `telephone_client` = '3004056238',
    `etat_client`= 'actif',
    `date_client`= CURDATE();
    /* pour ajouter un champs à la table client*/
    ALTER TABLE `client`ADD `password_client` VARCHAR(250) COLLATE utf8_general_ci AFTER `email_client`;

    /* pour ajouter un mot de passe au client*/
    UPDATE `client`SET `password_client` = MD5(SHA1('123456'));
    /* modifier le mot de passe  des clients ayant le nom leger*/
    UPDATE `client`SET `password_client`= MD5(SHA1('123456')) WHERE `nom_client`= 'leger';

CREATE TABLE `projet`(
    `id_projet` INT(10) PRIMARY KEY NULL AUTO_INCREMENT,
    ` id_client_projet`INT(10),
    `nom_projet`VARCHAR(250) COLLATE utf8_general_ci,
    `description_projet` TEXT COLLATE utf8_general_ci,
    `prix_projet`FLOAT(5,2) NOT NULL,
    `etat_projet` ENUM('attente','en cours','terminé','annulé') COLLATE utf8_general_ci,
    `date_projet`DATE
);
/* on ajoute des projets*/
INSERT INTO `projet`(`id_client_projet`,`nom_projet`,`description_projet`,`prix_projet`,`etat_projet`,`date_projet`)
VALUES
(1,'cours particulier','apprendre les langages web en quelques semaines',600,'attente',CURDATE()),
(2,'greffe de cheveux','avoir les mêmes cheveux que amelie',3500,'annulé','2010-06-01'),
(2,'être sur les sites des aixs','être bien réferencé sur le site de la commune des aix',50,'en cours','2020-11-01'),
(3,'avoir chaud','acheter des chauffages à LIDL pour avoir chaud',150,'en cours','2022-12-01');
/*supprimer le projet de greffe de cheveux*/
DELETE FROM `projet`WHERE `nom_projet` like '%cheveux%'OR `description_projet` LIKE '%cheveux%';
CREATE TABLE `tache`(
    `id_tache` INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id_projet_tache` INT(10) NOT NULL,
    `nom_tache` VARCHAR(250) COLLATE utf8_general_ci,
    `date_debut_tache` DATETIME,
    `date_fin_tache`DATETIME,
    `description_tache` TEXT COLLATE utf8_general_ci,
    `etat_tache` ENUM('attente','en cours','en validation','terminé','annulé')
);
/* inserer des taches*/
INSERT INTO `tache`(`id_projet_tache`,`nom_tache`,`date_debut_tache`,`date_fin_tache`,`description_tache`,`etat_tache`)
VALUES
(1,'html','2023-03-30','apprendre les bases','en cours'),
(2,'css','2023-04-05','2023-04-10','apprendre les bases','en attente'),
(3,'acheter',CURDATE(),'2023-04-14','passer a lidl','en attente'),



CREATE TABLE `utilisateur`(
    `id_utilisateur` INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `nom_utilisateur`VARCHAR(250)COLLATE utf8_general_ci,
    `prenom_utilisateur` VARCHAR(250) COLLATE utf8_general_ci,
    `email_utilisateur`VARCHAR(250)COLLATE utf8_general_ci,
    `password_utilisateur`VARCHAR(250)COLLATE utf8_general_ci,
    `statut_utilisateur` ENUM('admin','developpeur','chef de projet'),
    `date_utilisateur`DATE,
    `etat_utilisateur` ENUM('valide','invalide')
);
/*requette de selection*/
SELECT * FROM `utilisateur`;
/* que les utilisateurs valide*/
SELECT * FROM `utilisateur` WHERE `etat_utilisateur` = 'valide';
/* jointure pour selectionner l'ensemble des projets et les clients en face*/
SELECT * FROM `projet` LEFT JOIN `client` on id_client_projet = id_client;/*affiche l'ensemble des projets même s'il n'y a pas de client en face*/

SELECT * FROM `projet` INNER JOIN `client` on id_client_projet = id_client; /*affiche l'ensemble des projets qui ont un client*/

/* les sous-requettes en SQL*/
SELECT * FROM `projet` RIGHT JOIN `client`ON id_client_projet = id_client WHERE `id_client_projet` =  (
    SELECT `id_client` FROM `client` ORDER BY RAND() LIMIT 1
);
/*les conditions multiples SQL*/
/* afficher tous les client qui on la lettre g dans le prenom et le nom client et qui sont actif */
SELECT * FROM `client` WHERE (`nom_client` LIKE '%g%' OR `prenom_client`LIKE '%g%') AND `etat_client` = 'actif';

/*afficher toutes les taches dont la date de fin est dépassée*/
SELECT * FROM `tache` WHERE date_fin_tache < CURDATE();
/* afficher le nombre de jours qu'on a pour realiser les taches*/
 SELECT DATEDIFF(date_fin_tache,date_debut_tache) AS nb_jour FROM `tache`;
 /* si jamais on a un champs du type datetime
  affiche le nombre d'heure qu'on a pour realiser les taches*/
  SELECT TIMEDIFF(date_fin_tache, date_debut_tache) AS nb_jour FROM `tache`;
  /*selectionner des résultats compris entre deux valeurs*/
  SELECT * FROM `tache` WHERE date_debut_tache BETWEEN '2023-02-01' AND '2023-02-28';
  /* mettre en majuscule un champs*/
  SELECT UPPER(nom_client) AS nom,prenom_client FROM `client`;
  INSERT INTO `client` SET
  `nom_client`= UPPER('Dubouchau'),
  `prenom_client` = 'Jessica';
  /*vider une table et mettre à jour les index*/
  TRUNCATE `projet`;
  /* supprimer une table */

  DROP TABLE `projet`;
    /*pour une suppression de la BDD*/
  DROP DATABASE `projet`;



