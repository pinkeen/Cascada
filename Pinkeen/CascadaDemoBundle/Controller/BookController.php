<?php

namespace Pinkeen\CascadaDemoBundle\Controller;

use Pinkeen\Cascada\Controller\AbstractCrudController;
use Pinkeen\Cascada\Controller\BaseController;
use Pinkeen\Cascada\Field\ReflectiveField;

class BookController extends AbstractCrudController
{
    public function listAction()
    {
        return $this->renderResponse('PinkeenCascadaDemoBundle:Book:list.html.twig');
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return [];
    }
}