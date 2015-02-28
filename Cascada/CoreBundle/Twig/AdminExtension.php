<?php

namespace Cascada\CoreBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Twig_Extension;
use Twig_SimpleFilter;

class AdminExtension extends Twig_Extension
{
    /**
     * @param Request $request
     * @param array $parameters
     * @return string
     */
    public function modifyQueryParameters(Request $request, $parameters)
    {
        $queryParams = $request->query->all();

        foreach ($parameters as $key => $value) {
            if (null === $value) {
                unset($queryParams[$key]);
            } else {
                $queryParams[$key] = $value;
            }
        }

        return
            $request->getSchemeAndHttpHost() .
            $request->getBaseUrl() .
            $request->getPathInfo() .
            (empty($queryParams) ? '' : '?' . http_build_query($queryParams))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('cascada_modify_query', [$this, 'modifyQueryParameters']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cascada_admin_extension';
    }
}
