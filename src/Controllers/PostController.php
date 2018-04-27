<?php
namespace PhpBlog\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;


class PostController
{
    /** @var Twig_Environment */
    private $twig;

    /**
     * PostController, constructed by the container
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function view($routeParams)
    {
        //get and display the post
    }

    /**
     * Add post
     */
    public function addPost()
    {

    }

    public function editPost()
    {

    }

    public function addComment()
    {

    }


}