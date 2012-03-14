<?php

namespace SFM\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuiemlder;
use SFM\WebsiteBundle\Form\PollOptionType;

class PollType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('options', 'collection', array( 'type'   => new PollOptionType()));  
//        $subscriber = new AddOptionsFieldSubscriber($builder->getFormFactory());
//        $builder->addEventSubscriber($subscriber);
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'SFM\WebsiteBundle\Entity\Poll'
        );
    }

    public function getName() {
        return 'sfm_websitebundle_poll_type';
    }

}
