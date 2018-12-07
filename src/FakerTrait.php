<?php

namespace agilov\yii2testingkit;

/**
 * Trait FakerTrait
 *
 * @author Roman Agilov <agilovr@gmail.com>
 */
trait FakerTrait
{
    /** @var \Faker\Generator */
    protected $_faker;

    /**
     * @return \Faker\Generator
     */
    public function fake()
    {
        if ($this->_faker === null) {
            $this->_faker = \Faker\Factory::create();
        }

        return $this->_faker;
    }
}
