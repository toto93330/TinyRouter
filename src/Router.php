<?php

namespace Anthony\Router;

/*
MIT License
Copyright (c) 2021 Anthony Alves <contact@anthonyalves.fr>
ROUTEUR POUR APPRENDRE A MES ETUDIENTS OPENCLASSROOMS (VERSION V.1) PARCOURS PHP SYMFONY
*/

class Router
{
    public $routes = [];

    public $routename;

    public $params = [];

    public $route;

    /**
     * @var array verification du type de nos variables dans nos uri grace aux expresion reguliere (regex)
     */
    protected $matchTypes = [
        'i'  => "/[0-9]+/",
        'a'  => '/[a-z]+/',
        '*'  => '/[a-zA-Z0-9]+/',
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

                ///////
                // Je passe a là suite de mon traitement si je ne suis pas dans l'index
                ///////
            } elseif (($uri[1] === $route[1] && count($uri) === count($route)) || $uri[1] === "") {

                //////////
                // Je verifie si le type de la methode est bonne sinon je defini ma route sur null
                //////////
                if (strtolower($value['method']) != strtolower($_SERVER['REQUEST_METHOD'])) {
                    $this->routename = null;
                    return false;
                } else {

                    //////////
                    // Je recupere les parametre envoyer dans uri
                    //////////
                    preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $value['uri'], $match, PREG_SET_ORDER);

                    /////////
                    // Je recupere le nom des variables dans un tableau
                    /////////

                    $index = array();


                    for ($i = 0; $i < count($match); $i++) {
                        $index += [$i => $match[$i][3]];
                    }

                    ////////////
                    // Je defini ma route dans une variable
                    ////////////

                    $this->route = $value;

                    foreach ($match as $value) {

                        ////////
                        // Je verifie son type grace a $matchTypes
                        ////////

                        preg_match_all($this->matchTypes[$value[2]], $_SERVER['REQUEST_URI'], $match, PREG_SET_ORDER);

                        ////////
                        //si il y a une erreur de parametre je defini ma route sur null
                        ////////
                        if ($match == null) {
                            $this->routename = null;
                            return false;
                        } else {

                            ////////
                            // On récupére les parametres de uri et on les l'injects dans un tableau nouveau tableau
                            ////////

                            foreach ($index as $key => $param) {

                                $this->params += [$index[$key] => $match[$key][0]];
                            }
                            return true;
                        }
                    }
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
        $this->verifRoute();

        if ($this->verifRoute()) {
            call_user_func_array($this->route['controller'], $this->params);
        } else {
            return false;
        }
    }
}
