projets4
========

A Symfony project created on February 16, 2017, 10:08 am.
#Jeu de carte

_Bundles installés_

`FOS User Bundle`

`VichUploadBundle`

`FOSMessageBundle`

`EasyAdminBundle`

`DForumBundle`

#Modification des Entités pour EAB.
Modifier le fichier Forum et Category de Discutea pour y ajouter 
```
public function __toString() {
        return $this->name;
    }
```
