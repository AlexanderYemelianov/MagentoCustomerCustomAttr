<?php

namespace Ay\CustomerGraphQl\Model\Customer\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Hobby extends AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions() : array
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __(''), 'value' => 0],
                ['label' => __('Yoga'), 'value' => 1],
                ['label' => __('Traveling'), 'value' => 2],
                ['label' => __('Hiking'), 'value' => 3]
            ];
        }
        return $this->_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
