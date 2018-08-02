<?php

namespace agilov\yii2testingkit;

use yii\base\Model;

/**
 * Class TestValidatorHelper
 *
 * @author Roman Agilov <agilovr@gmail.com>
 */
trait TestValidatorTrait
{
    /**
     * @param Model $model
     * @param array $required
     */
    public function checkRequiredAttributes(Model $model, array $required)
    {
        expect($model->validate())->false();
        foreach ($required as $r) {
            expect($model->hasErrors($r))->true();
        }
    }

    /**
     * @param Model $model
     * @param array $invalid
     */
    public function tryInvalidAttributes(Model $model, array $invalid)
    {
        foreach ($invalid as $k => $v) {
            if (!is_array($v)) {
                $v = [$v];
            }

            foreach ($v as $val) {
                $model->{$k} = $val;
                expect($model->validate())->false();
                expect($model->hasErrors($k))->true();
            }
        }
    }
}
