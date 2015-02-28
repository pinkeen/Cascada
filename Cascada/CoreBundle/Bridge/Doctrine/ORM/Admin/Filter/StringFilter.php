<?php

namespace Cascada\CoreBundle\Bridge\Doctrine\ORM\Admin\Filter;

use Cascada\CoreBundle\Admin\Filter\StringFilter as BaseStringFilter;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;

class StringFilter extends BaseStringFilter
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param array $fields
     * @return Expr|string
     */
    protected function createConcatExpr(QueryBuilder $queryBuilder, array $fields)
    {
        if (count($fields) == 1) {
            return current($fields);
        }

        $first = array_shift($fields);

        return $queryBuilder->expr()->concat($first, $this->createConcatExpr($queryBuilder, $fields));
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param Expr|string $fieldsExpr
     * @param $userQuery
     * @return Expr
     */
    protected function createComparisonExpr(QueryBuilder $queryBuilder, $fieldsExpr, $userQuery)
    {
        $userQueryExpr = $queryBuilder->expr()->literal($userQuery);

        if ($this->getOption('exact')) {
            return $queryBuilder->expr()->eq($fieldsExpr, $userQueryExpr);
        }

        return $expr = $queryBuilder->expr()->like($fieldsExpr, $userQueryExpr);
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    protected function handleApply($queryBuilder)
    {
        $concat = $this->getOption('concat');
        $fields = $this->getOption('fields');
        $exact = $this->getOption('exact');

        $userQuery = trim($this->getValue());

        if(empty($userQuery)) {
            return;
        }

        if (!$exact) {
            $userQuery = '%' . str_replace(' ', '%', $userQuery) . '%';
        }

        if (!is_array($fields)) {
            $fields = [$fields];
        }

        if ($concat) {
            $fieldsExpr = $this->createConcatExpr($queryBuilder, $fields);
            $expr = $this->createComparisonExpr($queryBuilder, $fieldsExpr, $userQuery);
        } else {
            $expr = $queryBuilder->expr()->orX();

            foreach ($fields as $field) {
                $expr->add($this->createComparisonExpr($queryBuilder, $field, $userQuery));
            }
        }

        $queryBuilder->andWhere($expr);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDefaults(OptionsResolverInterface $optionsResolver)
    {
        parent::configureDefaults($optionsResolver);

        $optionsResolver->setDefaults([
            'concat' => false,
            'exact' => false,
        ]);

        $optionsResolver->setRequired([
            'fields',
        ]);

        $optionsResolver->setAllowedTypes([
            'fields' => ['array', 'string'],
        ]);
    }
}