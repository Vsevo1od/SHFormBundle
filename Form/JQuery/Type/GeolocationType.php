<?php

namespace SymfonyHackers\Bundle\FormBundle\Form\JQuery\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use SymfonyHackers\Bundle\FormBundle\Form\Core\EventListener\GeolocationListener;

/**
 * GeolocationType to JQueryLib
 */
class GeolocationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', 'text');

        foreach (array('latitude', 'longitude', 'locality', 'country') as $field) {
            $option = $options[$field];

            if (isset($option['enabled']) && !empty($option['enabled'])) {
                $type = 'text';
                if (isset($option['hidden']) && !empty($option['hidden'])) {
                    $type = 'hidden';
                }

                $builder->add($field, $type);
            }
        }

        $builder
            ->addEventSubscriber(new GeolocationListener());
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'configs'   => array(),
            'elements'  => array(),
            'map' => $options['map']
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'map' => false,
            'latitude' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'longitude' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'locality' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'country' => array(
                'enabled' => false,
                'hidden' => false,
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'genemu_jquerygeolocation';
    }
}
