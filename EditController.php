<?php

/*
 * This file is part of the Symfony-Util package.
 *
 * (c) Jean-Bernard Addor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymfonyUtil\Component\FormRoutingTemplatingHttpFoundation;

use SymfonyUtil\Component\HttpFoundation\ArrayInsertInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Templating\EngineInterface;

class NewController /////////////////////////////////// InsertController
{
    protected $formFactory;
    protected $formClass;
    protected $model;
    protected $urlGenerator;
    protected $routeName;
    protected $templating;
    protected $template;

    public function __construct(
        FormFactoryInterface $formFactory,
        $formClass,
        ArrayInsertInterface $model,
        UrlGeneratorInterface $urlGenerator,
        $routeName,
        EngineInterface $templating,
        $template = 'new.html.twig'
    )
    {
        $this->formFactory = $formFactory;
        $this->formClass = $formClass;
        $this->model = $model;
        $this->urlGenerator = $urlGenerator;
        $this->routeName = $routeName;
        $this->templating = $templating;
        $this->template = $template;
    }

    public function __invoke($id, Request $request = new Request())
    {
        $form = $formFactory->create($this->formClass, $this->model->show($id, $request));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return new RedirectResponse($this->urlGenerator->generate(
                $this-routeName,
                $this->model->update($id, $form->getData(), $request)
            ));
        }
        // return new Response($this->templating->render($this->template, $this->model->...($form, $request)));

        return new Response($this->templating->render($this->template, [
            'form' => $form->createView(),
        ])); /////////////////////////////////////////////////////////////////////////////////////////!!!
    }
}
