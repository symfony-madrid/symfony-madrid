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
            ->add('date')
            ->add('location')
            ->add('photo')
            ->add('file1')
            ->add('file2')
        ;
    }

    public function getName()
    {
        return 'sfbcn_websitebundle_eventtype';
    }
}
