<?php

namespace Blog\Route;

use Blog\PostMapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BlogPage
{
    /**
     * @var PostMapper
     */
    private PostMapper $postMapper;

    /**
     * @var Environment
     */
    private Environment $view;

    /**
     * @param PostMapper $postMapper
     * @param Environment $view
     */
    public function __construct(Environment $view, PostMapper $postMapper)
    {
        $this->postMapper = $postMapper;
        $this->view = $view;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $page = isset($args['page']) ? (int) $args['page'] : 1;

        $limit = 2;

        $posts = $this->postMapper->getList($page, $limit, 'DESC');

        $totalCount = $this->postMapper->getTotalCount();

        $body = $this->view->render('blog.twig', [
            'posts' => $posts,
            'pagination' => [
                'current' => $page,
                'paging' => ceil($totalCount / $limit),
            ]
        ]);

        $response->getBody()->write($body);

        return $response;
    }
}