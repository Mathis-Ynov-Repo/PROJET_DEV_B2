# BDD

Il y a 3 types de comptes stockés dans la table **utilisateurs**: 
  * le compte client avec le rôle ["ROLE_MEMBRE"], 
  * le compte du gérant du restaurant avec le rôle ["ROLE_RESTAURATEUR"], et 
  * le compte administrateur avec le rôle ["ROLE_ADMIN"].

Un restaurant créé est stocké dans la table **restaurants** avec une colonne *ID_restaurateur* pointant vers le gérant dans la table **utilisateurs**.

Le restaurant ajoute ses plats à la BDD, chaque plat est lié à un restaurant d’où la clé étrangère *ID_restaurant*.

Chaque plat possèdera aussi un type qui permettra de trier les plats.
La table **plat_types** stockera ces types.

Le restaurant peut aussi créer un menu avec un prix fixe stocké dans la table **menu**.
La table **menu_details** permet de lier un menu aux plats le constituant.

La table **commande** s’occupe de stocker les frais de la livraison et le prix de la commande après ces frais ainsi que les dates d’achat et de réception de la commande.
La table **commande_plats** liée à cette table s’occupe elle de conserver les détails de cette commande, les plats ou menu la composant et le prix total sans les frais.
**Feedback** contient les reviews des utilisateurs sur les restaurants
