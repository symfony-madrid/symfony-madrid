<?php

namespace SFBCN\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SFNewType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('author')
            ->add('published_at')
            ->add('photo')
            ->add('file1')
            ->add('file2')
        ;
    }

    public function getName()
    {
        return 'sfbcn_websitebundle_sfnewtype';
    }
}
