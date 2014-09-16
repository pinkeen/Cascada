<?php

namespace Pinkeen\Cascada\Templating;

use Symfony\Component\Templating\EngineInterface;

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
        if(null === $this->templating) {
            throw new \LogicException('Templating requested but not injected beforehand.');
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
}