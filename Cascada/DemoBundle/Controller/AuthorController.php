<?php

namespace Cascada\DemoBundle\Controller;

use Cascada\CoreBundle\Admin\Field;
use Cascada\CoreBundle\Admin\Filter;
use Cascada\CoreBundle\Admin\Filter\Manager\FilterManager;
use Cascada\CoreBundle\Admin\ListView\ListViewInterface;
use Cascada\CoreBundle\Admin\Controller\AbstractAdminController;
use Cascada\CoreBundle\Bridge\Doctrine\ORM\Admin\Controller\AbstractDoctrineAdminController;
use Cascada\DemoBundle\Entity\Author;
use Doctrine\ORM\QueryBuilder;

class AuthorController extends AbstractDoctrineAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function buildListView(ListViewInterface $listView)
    {
        $listView
            ->addField(new Field\ScalarField('firstName'))
            ->addField(new Field\ScalarField('middleName'))
            ->addField(new Field\ScalarField('lastName'))
            ->addField(new Field\ScalarField('bookCount', [
                'callback' => function (Author $author) {
                    return $author->getBooks()->count();
                }
            ]))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getItems()
    {
        return $this
            ->getService('doctrine.orm.entity_manager')
            ->getRepository('CascadaDemoBundle:Author')
            ->findAll()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return [

        ];
    }
}