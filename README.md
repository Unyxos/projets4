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
Modifier vendor/discutea/forum-bundle/Discutea/DForumBundle/Entity/Category.php pour : 
```
<?php

namespace Discutea\DForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Discutea\DForumBundle\Entity\Model\BaseTopic;

/**
 *
 * @ORM\Entity(repositoryClass="Discutea\DForumBundle\Repository\TopicRepository")
 * @ORM\Table(name="df_topic")
 * 
 */
class Topic extends BaseTopic
{
    public function __toString() {
        return $this->title;
    }
}
```

Modifier vendor/discutea/forum-bundle/Discutea/DForumBundle/Entity/Forum.php pour :
```
<?php

namespace Discutea\DForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Discutea\DForumBundle\Entity\Model\BaseForum;

/**
 * @ORM\Entity(repositoryClass="Discutea\DForumBundle\Repository\ForumRepository")
 * @ORM\Table(name="df_forum")
 */
class Forum extends BaseForum
{
    public function __toString() {
        return $this->name;
    }
}
```

Modifier vendor/discutea/forum-bundle/Discutea/DForumBundle/Entity/Category.php pour :
```
<?php
namespace Discutea\DForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Discutea\DForumBundle\Entity\Model\BaseCategory;

/**
 * @ORM\Entity(repositoryClass="Discutea\DForumBundle\Repository\CategoryRepository")
 * @ORM\Table(name="df_category")
 */
class Category extends BaseCategory
{
    public function __toString() {
        return $this->name;
    }
}
```

Le fichier "cartes.sql" est à importer dans la table "cartes" sur phpMyAdmin après l'installation du projet.
