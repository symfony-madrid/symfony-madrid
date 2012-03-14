<?php

namespace SFM\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PollOptionType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('title', 'checkbox');
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'SFM\WebsiteBundle\Entity\PollOption',
        );
    }

    public function getName() {
        return 'sfm_websitebundle_poll_type';
    }

}
