<?php

namespace Pinkeen\CascadaBundle\Crud\Templating;

use Symfony\Component\Templating\EngineInterface;
use LogicException;

/**
 * Common code for classes that need templating injected.
 *
 * {@inheritdoc}
 */
trait TemplatingAwareTrait
{
    /**
     * @var EngineInterface
     */
    private $templating = null;

    /**
     * {@inheritdoc}
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * Returns templating or throws errors if not injected before.
     */
    protected function getTemplating()
    {
        if (null === $this->templating) {
            throw new LogicException('Templating requested but not injected beforehand.');
        }

        return $this->templating;
    }

    /**
     * A convenience method for rendering templates.
     *
     * @param string $template
     * @param array $parameters
     * @return string
     */
    protected function renderTemplate($template, array $parameters = [])
    {
        return $this->getTemplating()->render($template, $parameters);
    }

    /**
     * Convenience method for conditional injecting templating into another object.
     *
     * @param object $potentiallyTemplatingAware
     */
    protected function injectTemplatingInto($potentiallyTemplatingAware)
    {
        if ($potentiallyTemplatingAware instanceof TemplatingAwareInterface) {
            $potentiallyTemplatingAware->setTemplating($this->getTemplating());
        }
    }
}