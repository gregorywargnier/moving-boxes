# Moving Boxes
> Gestion des cartons de déménagement

## Qu'est ce que c'est ?
Moving Boxes est une application permettant de lister les cartons et leur contenu lors d'un déménagement. 

La liste des cartons précise 
- le numéro 
- le nom 
- la piéce d'origine
- la piéce de destination
- une photo du contenu
- la description du contenu

## Les entités

### Users
- email: identifiant
- password: mot de passe
- firstname: prénom
- lastname: nom
- screenname: nom affiché (Prénom N.)
- defaultMoving

### Moving
- name

### UsersMovings
- moving
- user
- roles

### Rooms
- name: nom de la piéce
- user

### Boxes
- number: numéro du carton (auto incrémenté)
- name: nom du carton
- origin: piéce d'origine du contenu
- destination: piéce de destination du contenu
- picture: photo du contenu
- content: description du contenu
- moving: liaison au déménagement
