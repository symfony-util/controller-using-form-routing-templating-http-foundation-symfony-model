<?php

/*
 * This file is part of the Symfony-Util package.
 *
 * (c) Jean-Bernard Addor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymfonyUtil\Component\TemplatingHttpFoundation;

use SymfonyUtil\Component\HttpFoundation\ArrayIndexInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class IndexController
{
    protected $model
    protected $templating;
    protected $template;

    public function __construct(
        ArrayIndexInterface $model,
        EngineInterface $templating,
        $template = 'index.html.twig',
    )
    {
        $this->model = $model;
        $this->templating = $templating;
        $this->template = $template;
    }

    public function __invoke(Request $request = new Request())
    {
        return new Response($this->templating->render($this->template, $this->model->index($request)));
    }
}
