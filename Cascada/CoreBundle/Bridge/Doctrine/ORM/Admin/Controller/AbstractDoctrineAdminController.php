<?php

namespace Cascada\CoreBundle\Bridge\Doctrine\ORM\Admin\Controller;

use Cascada\CoreBundle\Admin\Controller\AbstractAdminController;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Base admin controller with Doctrine ORM specific helpers and boilerplate.
 */
abstract class AbstractDoctrineAdminController extends AbstractAdminController
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine = null;

    /**
     * @return QueryBuilder
     */
    protected function createListQueryBuilder()
    {
        $entityAlias = $this->getOption('query_builder_alias');

        $queryBuilder = $this->createDoctrineQueryBuilder(
            $this->getOption('entity_repository'),
            $entityAlias
        );

        foreach ($this->getOption('list_select_join_fields') as $i => $fieldName) {
            $queryBuilder
                ->leftJoin($entityAlias . '.' . $fieldName, $fieldName)
                ->addSelect($fieldName)
            ;
        }

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return array
     */
    protected function executeQueryBuilderQuery($queryBuilder)
    {
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return RegistryInterface
     */
    protected function getDoctrine()
    {
        if (null === $this->doctrine) {
            $this->doctrine = $this->getService('doctrine');
        }

        return $this->doctrine;
    }

    /**
     * @param string $name
     * @return EntityRepository
     */
    protected function getDoctrineRepository($name)
    {
        return $this->getDoctrine()->getManager()->getRepository($name);
    }

    /**
     * @param string $repositoryName
     * @param string $alias
     * @return QueryBuilder
     */
    protected function createDoctrineQueryBuilder($repositoryName, $alias = 'item')
    {
        return $this->getDoctrineRepository($repositoryName)->createQueryBuilder($alias);
    }

    /**
     * {@inheritdoc}
     */
    protected function getItemById($id)
    {
        $this->getDoctrineRepository($this->getOption('entity_repository'))->find($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'query_builder_alias' => 'item',
            'list_select_join_fields' => [],
        ]);

        $optionsResolver->setAllowedTypes([
            'list_select_join_fields' => 'array',
        ]);

        $optionsResolver->setRequired([
            'entity_repository'
        ]);
    }
}