<?php

namespace SymfonyHackers\Bundle\FormBundle\Twig\Extension;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormRendererInterface;

/**
 * FormExtension extends Twig with form capabilities.
 */
class FormExtension extends \Twig_Extension
{
    /**
     * This property is public so that it can be accessed directly from compiled
     * templates without having to call a getter, which slightly decreases performance.
     *
     * @var FormRendererInterface
     */
    public $renderer;

    /**
     * Constructs.
     *
     * @param FormRendererInterface $renderer
     */
    public function __construct(FormRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('form_javascript', array($this, 'renderJavascript'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_js_settings_div', array($this, 'renderDiv'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_stylesheet', null, array(
                'is_safe' => array('html'),
                'node_class' => 'Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode',
            )),
        );
    }

    /**
     * Render Function Form Javascript
     *
     * @param FormView $view
     * @param bool     $prototype
     *
     * @return string
     */
    public function renderJavascript(FormView $view, $prototype = false)
    {
        $block = $prototype ? 'javascript_prototype' : 'javascript';

        return $this->renderer->searchAndRenderBlock($view, $block);
    }

    /**
     * Render Javascript configs in div
     *
     * @param FormView $view
     * @param bool     $prototype
     *
     * @return string
     */
    public function renderDiv(FormView $view, $prototype = false)
    {
        $block = $prototype ? 'js_settings_div_prototype' : 'js_settings_div';

        return $this->renderer->searchAndRenderBlock($view, $block);
    }
}
