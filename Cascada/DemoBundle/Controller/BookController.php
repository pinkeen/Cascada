<?php

namespace Cascada\DemoBundle\Controller;

use Cascada\CoreBundle\Admin\ListView\ListViewInterface;
use Cascada\CoreBundle\Admin\Filter\Manager\FilterManager;
use Cascada\CoreBundle\Admin\Field;
use Cascada\CoreBundle\Admin\Filter;
use Cascada\CoreBundle\Bridge\Doctrine\ORM\Admin\Filter as DoctrineFilter;
use Cascada\CoreBundle\Bridge\Doctrine\ORM\Admin\Controller\AbstractDoctrineAdminController;
use Cascada\DemoBundle\Entity\Book;
use Doctrine\ORM\QueryBuilder;

class BookController extends AbstractDoctrineAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function buildListView(ListViewInterface $listView)
    {
        $listView
            ->addField(new Field\ScalarField('title'))
            ->addField(new Field\DateTimeField('publishedAt', [
                'format' => 'M Y'
            ]))
            ->addField(new Field\ScalarField('isbn', [
                'label' => 'ISBN',
                'empty_value' => '—',
            ]))
            ->addField(new Field\ScalarField('author', [
                'callback' => function (Book $book) {
                    return $book->getAuthor()->getFirstName() . ' ' . $book->getAuthor()->getLastName();
                }
            ]))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function buildFilterChain(FilterManager $filterManager)
    {
        $filterManager
            ->registerFilter(new Filter\ChoiceFilter('has_isbn', [
                'empty_label' => 'All',
                'choices' => [
                    'yes' => 'With ISBN',
                    'no' => 'Missing ISBN'
                ],
                'callback' => function (QueryBuilder $queryBuilder, $value) {
                    if ($value === 'yes') {
                        $queryBuilder->andWhere('book.isbn IS NOT NULL');
                    } elseif($value === 'no') {
                        $queryBuilder->andWhere('book.isbn IS NULL');
                    }
                }
            ]))
            ->registerFilter(new DoctrineFilter\StringFilter('title', [
                'fields' => 'book.title'
            ]))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return [
            'entity_repository' => 'CascadaDemoBundle:Book',
            'query_builder_alias' => 'book',
            'list_select_join_fields' => ['author'],
        ];
    }
}