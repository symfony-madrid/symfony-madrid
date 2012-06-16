<?php

namespace SFM\WebsiteBundle\Extension;

/**
 * TwigExtension
 *
 * @author Eduardo Gulias Davis <me@egulias.com>
 *
 */
class SFMTwigExtension extends \Twig_Extension
{
    /**
     * getFilters
     *
     * @return array()
     */
    public function getFilters()
    {
        return array(
          'split'  => new \Twig_Filter_Method($this, 'split'),
          'substr' => new \Twig_Filter_Method($this, 'substr'),
        );
    }

    /**
     * split
     *
     * @param string $sentence
     * @param string $expr
     *
     * @return array
     */
    public function split($sentence, $expr)
    {
        return explode($expr, $sentence);
    }
    
    public function substr($string , $start, $length ){
        return substr($string , $start, $length );
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return 'sfm_twig_extension';
    }
}
