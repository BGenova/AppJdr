<?php

namespace App\Form;

use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType {

    /**
     * Set configuration for fields
     *
     * @param string $label
     * @param string $placeholder
     * @param string $labelClass
     * @param string $inputClass
     * @param Boolean $required
     * @return array
     */
    protected function setConfiguration($label, $placeholder, $labelClass, $inputClass, $required)
    {
        return [
            'label' => $label,
            'label_attr' => [
                'class' => $labelClass
            ],
            'attr' => [
                'placeholder' => $placeholder,
                'class' => $inputClass
            ],
            'required' => $required,
        ];
    }
}