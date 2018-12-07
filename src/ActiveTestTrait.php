<?php
namespace agilov\yii2testingkit;

use yii\test\FixtureTrait;
use Yii;

/**
 * Trait ActiveTestTrait
 *
 * @author Roman Agilov <agilovr@gmail.com>
 */
trait ActiveTestTrait
{
    use FixtureTrait;

    public $model;

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        $this->initFixtures();
        $this->model = Yii::createObject($this->modelClass());
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        $this->unloadFixtures();
    }

    /**
     * Class name or config array for Yii::createObject() method
     *
     * @return string|array
     */
    abstract protected function modelClass();
}
