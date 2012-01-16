<?php

namespace SFBCN\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EventType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('datetime')
            ->add('location')
            ->add('gmaps')
        ;
    }

    public function getName()
    {
        return 'sfbcn_websitebundle_eventtype';
    }
}
