wcs_partage
===========

#### Description
Projet de révision

#### Pré-requis
Avoir "composer" d'installé ==> https://getcomposer.org/doc/00-intro.md

#### Initialisation du projet

1. **SSH** git clone git@github.com:florianpdf/projet_revision.git
2. **HTTPS** git clone https://github.com/florianpdf/projet_revision.git
3. cd projet_revision
4. composer install
5. php app/console doctrine:database:create
6. php app/console doctrine:schema:update --force
7. php app/console asset:install

A Symfony project created on July 28, 2016, 3:07 pm.
