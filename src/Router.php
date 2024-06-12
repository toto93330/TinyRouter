<?php

namespace Anthony\Router;

/*
MIT License
Copyright (c) 2024 Anthony Alves <contact@anthonyalves.fr>
ROUTEUR POUR APPRENDRE A MES ETUDIENTS OPENCLASSROOMS (VERSION V.2) PARCOURS PHP SYMFONY
*/

class Router
{

    public $routes = [];

    public $routename;

    public $params = [];

    public $route;

    public $index = [];
    /**
     * @var array verification du type de nos variables dans nos uri grace aux expresion reguliere (regex)
     */
    protected $matchTypes = [
        'i'  => "/[0-9]+/",
        'a'  => '/[a-z]+/',
        '*'  => '/[a-zA-Z0-9-]+/',
    ];

    /**
     * Permet d'ajouter une route dans votre projet
     * 
     * Exemple : 
     * 
     * (new Router)->addRoute('home' , '/' , function () {
     * 
     * $controller = new Controller;
     * 
     * return $controller->Home();
     * 
     * });
     * 
     * @param string $method (method HTTP [GET,POST etc ...])
     * @param string $name (Nom de votre route)
     * @param string $uri (L'URI de votre route)
     * @param mixed $controller (Controller)
     * @return void 
     */
    public function addRoute(string $method, string $name, string $uri, mixed $controller)
    {
        $this->routes += [$uri => ['method' => $method, 'name' => $name, 'uri' => $uri, 'controller' => $controller]];
    }

    /**
     * Method qui renvoi si la route existe ou pas et qui l'instancie si là route et fausse ça renvoie 
     * @return true|void 
     */
    function verifRoute()
    {

        //J'explode mon uri courant pour recuperer ces parametres 
        $uri = explode('/', $_SERVER['REQUEST_URI']);

        foreach ($this->routes as $value) {

            // J'explode mes uri pour voir si l'une de mes routes match sans les parametre complementaire
            $route = explode('/', $value['uri']);

            //////////////
            // Je verifie si ma route pointe sur l'index et je la defini grace à son nom
            /////////////

            if ($uri[1] == "") {
                foreach ($this->routes as $value) {
                    if ($value['uri'] === '/') {
                        $this->routename = $value['name'];
                        $this->route = $value;
                    }
                };
                return true;
            }

            ///////
            // Je passe a là suite de mon traitement si je ne suis pas dans l'index
            ///////

            if (($uri[1] === $route[1] && count($uri) === count($route)) && strtolower($value['method']) === strtolower($_SERVER['REQUEST_METHOD']) || $uri[1] === "") {

                //////
                // VERIF ROUTE EXIST
                //////  

                $array = [];
                foreach ($this->routes as $route) {
                    $array[] = explode('/', $route['uri'])[1];
                }

                if (array_search($uri[1], $array)) {


                    //////////
                    // Je verifie si le type de la methode (GET, POST etc ...) est bonne sinon je defini ma route sur null
                    //////////

                    if (strtolower($value['method']) != strtolower($_SERVER['REQUEST_METHOD'])) {
                        $this->routename = null;
                        return false;
                    }


                    ////////////
                    // Je defini ma route dans une variable
                    ////////////

                    $this->route = $value;

                    ////////
                    // On creer un tableau qui regroupe le nom le type l'index et la valeur du parametre (CORRECTIF 2024)
                    ////////

                    $array = [];
                    if (isset($this->route['uri'])) {
                        $d = explode('/', $this->route['uri']);
                        $count = 0;
                        for ($i = 0; $i < count($d); $i++) {
                            if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $d[$i], $match, PREG_SET_ORDER)) {
                                $uri = explode('/', $_SERVER['QUERY_STRING']);
                                $array += [$count => ['name' => $match[0][3], 'type' => $match[0][2], 'index' => $i, 'value' => $uri[$i - 1]]];
                                $count++;
                            }
                        }
                    }


                    ////////
                    // On verifie la validité des parametre de la route (CORRECTIF 2024)
                    ////////

                    foreach ($array as $result) {
                        if (!preg_match_all($this->matchTypes[$result['type']], $result['value'], $match, PREG_SET_ORDER)) {
                            return false;
                        }
                    }

                    ////////
                    // On défini les paramétres envoyer dans le controller (CORRECTIF 2024)
                    ////////
                    foreach ($array as $param) {
                        $this->params[] = $param['value'];
                    }

                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * ceci est la method de rendu de mon controller si renvoie les variable a mon controller si c'est bon sinon il renvoie false ce qui permet de faire une redirection vers une page d'erreur
     * @return  
     */
    function render()
    {
        if ($this->verifRoute()) {
            call_user_func_array($this->route['controller'], $this->params);
        } else {
            return false;
        }
    }
}
