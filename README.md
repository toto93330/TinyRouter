# TinyRouter
Petit routeur en POO destiné à mes etudients OpenClassRooms parcours : PHP/SYMFONY

```php

// Je cree une instance de mon routeur
$route = new Router();

// Exemple de mapping d'une route
$route->addRoute('GET', 'article', '/article/[i:date]/[i:slug]', function ($date, $slug) {
    $controller = new Controller;
    return $controller->Article($date, $slug);
});

```

## Caractéristiques

* Peut être utilisé avec toutes les méthodes HTTP
* Routage dynamique avec des paramètres de route nommés
* Routage flexible des expressions régulières
* Regex personnalisé

## Contributeurs
- [Anthony Alves](https://github.com/toto93330)


## License
MIT License
Copyright (c) 2021 Anthony Alves <contact@anthonyalves.fr>

L'autorisation est par la présente accordée, gratuitement, à toute personne obtenant une copie de ce logiciel et des fichiers de documentation associés (le "Logiciel"), de traiter le Logiciel sans restriction, y compris, sans limitation, les droits d'utilisation, de copie, de modification, de fusion , publier, distribuer, sous-licencier et/ou vendre des copies du Logiciel, et permettre aux personnes auxquelles le Logiciel est fourni de le faire, sous réserve des conditions suivantes :

L'avis de droit d'auteur ci-dessus et cet avis d'autorisation doivent être inclus dans toutes les copies ou parties substantielles du logiciel.

LE LOGICIEL EST FOURNI « EN L'ÉTAT », SANS GARANTIE D'AUCUNE SORTE, EXPRESSE OU IMPLICITE, Y COMPRIS, MAIS SANS S'Y LIMITER, LES GARANTIES DE QUALITÉ MARCHANDE, D'ADAPTATION À UN USAGE PARTICULIER ET D'ABSENCE DE CONTREFAÇON. EN AUCUN CAS, LES AUTEURS OU TITULAIRES DE DROITS D'AUTEUR NE SERONT RESPONSABLES DE TOUTE RÉCLAMATION, DOMMAGES OU AUTRE RESPONSABILITÉ, QU'IL SOIT DANS UNE ACTION DE CONTRAT, DÉLIT OU AUTRE, DÉCOULANT DE, OU EN RELATION AVEC LE LOGICIEL OU L'UTILISATION OU D'AUTRES TRANSACTIONS DANS LE LOGICIEL.

