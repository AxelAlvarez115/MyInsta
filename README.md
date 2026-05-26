# Vanilla-TP-CloneInstagram

# 📷Clone instagram




Vous avez une idée révolutionnaire : refaire Instagram… mais en plus simple !  
Ça va marcher à coup sûr !

Ce projet combine des techniques classiques et standards de codage de site HTML/CSS/PHP avec un peu de code Javascript asynchrone.


#  📜 Scénarios utilisateurs minimum requis


## 
  **Graphisme**



* Je visualise l'application sur tous les formats d'écran sans scrollbar horizontale
* L'application utilise tout l'écran de façon optimal sur tous les appareils
* Le design est sobre, moderne, simple et intuitif

## 
  **Compte**

* En tant qu'utilisateur non connecté, je dois me connecter en saisissant seulement mon pseudo. Il n'y a pas de mot de passe. \
Si le pseudo n'est pas connu dans la base de données, un nouvel utilisateur est créé. \
 Si le pseudo est connu dans la base de données, alors je suis connecté sur le profil.

## 
  **Profils**

* En tant qu'utilisateur connecté, j'accède à mon profil sur lequel je retrouve mes photos
* En tant qu'utilisateur connecté, j'accède à tous les profils autres que le miens.
* Un profil, que ce soit le mien ou un autre, s'affiche de la même façon : nom, avatar, et liste des photos

## 
  **Likes**

* En tant qu'utilisateur, je peux liker chaque photo une seule fois. Son compteur s'incrémente alors sans que la page soit rechargée et l'information est enregistrée en base de données.


## **Commentaires**



* En tant qu'utilisateur, je peux déposer un commentaire et voir les autres commentaires


# 🔗Complexité minimale requise


## 
  **Backend**



* Il doit y avoir une base de données avec au moins une table users et une table photos
* Une relation doit exister en MySQL entre users et photos
* Prenez soin de bien structurer votre application PHP !

## 
  **Frontend**

* Le site doit être entièrement responsive
* Au format mobile certains éléments disparaissent, changent de taille ou encore de position. Vous devez montrer que vous savez gérer des règles média CSS en fonction de la taille de l'appareil utilisé. Par exemple menu est différent sur mobile


# 💡 Suggestions



* Uploader des photos sur son profil
* Ajouter l'authentification par mot de passe en plus du pseudo
