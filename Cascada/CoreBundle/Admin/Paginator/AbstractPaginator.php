<?php

namespace Cascada\CoreBundle\Admin\Paginator;

use Cascada\CoreBundle\Admin\ConfigurableTrait;
use Cascada\CoreBundle\Paginator\Results\PaginatedResultsInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractPaginator implements PaginatorInterface
{
    use ConfigurableTrait;

    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';

    const PAGE_PARAMETER = 'page';
    const ORDER_PARAMETER = 'order';
    const DIRECTION_PARAMETER = 'direction';

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->resolveConfiguration($options);
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->getRequest()->query->get(self::PAGE_PARAMETER, 1);
    }

    /**
     * @return string|null
     */
    protected function getOrder()
    {
        return $this->getRequest()->query->get(self::ORDER_PARAMETER, $this->getOption('order_by'));
    }

    /**
     * @return string|null
     */
    protected function getDirection()
    {
        $direction = $this->getRequest()->query->get(self::DIRECTION_PARAMETER, $this->getOption('sort_direction'));

        if (in_array($direction, [self::ORDER_ASC, self::ORDER_DESC])) {
            return $direction;
        }

        return $this->getOption('sort_direction');
    }


    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param EngineInterface $templating
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return PaginatedResultsInterface
     */
    abstract protected function handlePagination(QueryBuilder $queryBuilder);


    /**
     * @param QueryBuilder $queryBuilder
     * @return PaginatedResultsInterface
     */
    public function paginate(QueryBuilder $queryBuilder)
    {
        $queryBuilder->addOrderBy($this->getOrder(), $this->getDirection() === self::ORDER_ASC ? 'ASC' : 'DESC');

        return $this->handlePagination($queryBuilder);
    }

    /**
     * @return EngineInterface
     */
    protected function getTemplating()
    {
        if (null === $this->templating) {
            throw new \LogicException('Templating needed but not injected.');
        }

        return $this->templating;
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        if (null === $this->requestStack) {
            throw new \LogicException('Request needed but not injected.');
        }

        return $this->requestStack->getCurrentRequest();
    }

    /**
     * {@inheritdoc}
     */
    public function renderSortControls($field, $label = null)
    {
        $order = $this->getOrder();
        $direction = $this->getDirection();

        return $this->getTemplating()->render($this->getOption('sort_controls_template'), [
            'field' => $field,
            'label' => $label,
            'order_parameter' => self::ORDER_PARAMETER,
            'direction_parameter' => self::DIRECTION_PARAMETER,
            'is_asc' => $direction == self::ORDER_ASC,
            'is_desc' => $direction == self::ORDER_DESC,
            'order' => $order,
            'direction' => $direction,
            'new_direction' => $direction == self::ORDER_ASC ? self::ORDER_DESC : self::ORDER_ASC,
            'active' => $order === $field,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolverInterface $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'limit' => 15,
            'sort_controls_template' => 'CSAdminCoreBundle:Paginator:theadSortControls.html.twig',
            'order_by' => null,
            'sort_direction' => self::ORDER_ASC,
        ]);

        $optionsResolver->setAllowedTypes([
            'limit' => 'integer',
        ]);
    }
}