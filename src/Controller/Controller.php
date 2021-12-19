<?php

namespace Anthony\Router\Controller;

class Controller
{
    /**
     * HOME PAGE
     * @return void 
     */
    public function Home()
    {
        echo 'hello';
    }

    /**
     * PAGE D'ERREUR SIMPLE
     * @return void 
     */
    public function Error()
    {
        echo 'error 404';
    }

    /**
     * PAGE POUR SUPPRIMER UN ARTICLE
     * @return void 
     */
    public function Delect($id)
    {
        echo "l'article a supprimer à l'id : $id";
    }

    /**
     * PAGE POUR VOIR UN ARTICLE
     * @return void 
     */
    public function Article($date, $slug)
    {
        echo "la date de creation de l'article est : $date";
        echo "<br>";
        echo "le slug de l'article est : $slug";
    }
}
