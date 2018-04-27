<?php
namespace PhpBlog\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;


class IndexController
{
    /** @var Twig_Environment */
    private $twig;

    /**
     * IndexController, constructed by the container
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $data['posts'] = [ ['id'=>1, 'title'=>'Post 1', 'slug'=>'post_1'],
            ['id'=>2, 'title'=>'Post 2', 'slug'=>'post_2'],
            ['id'=>3, 'title'=>'Post 3', 'slug'=>'post_3']
        ];
        return new Response($this->twig->render('pages/index.html.twig', $data));
    }

}
