<?php

namespace agilov\yii2testingkit;

use Yii;
use yii\base\ArrayAccessTrait;
use yii\base\InvalidConfigException;
use yii\redis\ActiveRecord;
use yii\test\DbFixture;

/**
 * Class RedisFixture
 *
 * @author Roman Agilov <agilovr@gmail.com>
 */
class RedisFixture extends DbFixture
{
    use ArrayAccessTrait;


    public $db = 'redis';

    /**
     * @var ActiveRecord
     */
    public $modelClass;

    /**
     * @var array the data rows. Each array element represents one row of data (column name => column value).
     */
    public $data = [];

    /**
     * @var string|bool the file path or [path alias](guide:concept-aliases) of the data file that contains the fixture data
     * to be returned by [[getData()]]. You can set this property to be false to prevent loading any data.
     */
    public $dataFile;

    /**
     * Loads the fixture.
     *
     * The default implementation simply stores the data returned by [[getData()]] in [[data]].
     * You should usually override this method by putting the data into the underlying database.
     */
    public function load()
    {
        $this->data = $this->getData();

        foreach ($this->data as $alias => $row) {
            /** @var ActiveRecord $model */
            $model = new $this->modelClass($row);
            $model->save(false);
            $this->data[$alias] = $model->getAttributes();
        }
    }

    /**
     * @inheritdoc
     */
    public function unload()
    {
        $this->data = [];
        $this->modelClass::deleteAll();
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->modelClass === null) {
            throw new InvalidConfigException('"modelClass" must be set.');
        }
    }

    /**
     * @return array|mixed
     * @throws InvalidConfigException
     */
    protected function getData()
    {
        if ($this->dataFile === null) {
            $class = new \ReflectionClass($this);
            $dataFile = dirname($class->getFileName()) . '/data/' . $this->modelClass::keyPrefix() . '.php';

            return is_file($dataFile) ? require $dataFile : [];
        }

        $dataFile = Yii::getAlias($this->dataFile);

        if (is_file($dataFile)) {
            return require $dataFile;
        }

        throw new InvalidConfigException("Fixture data file does not exist: {$this->dataFile}");
    }
}
