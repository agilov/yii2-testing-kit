<?php

namespace agilov\yii2testingkit;

use yii\helpers\FileHelper;

/**
 * Class FixtureController
 *
 * @author Roman Agilov <agilovr@gmail.com>
 */
class FixtureController extends \yii\faker\FixtureController
{
    /**
     * @var string Group of fixtures (suite)
     */
    public $suite;

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['suite']);
    }

    /**
     * @inheritdoc
     */
    public function generateFixtureFile($templateName, $templatePath, $fixtureDataPath)
    {
        $fixtures = [];

        for ($i = 0; $i < $this->count; $i++) {
            $id = $i + 1;
            $fixture = $this->generateFixture($templatePath . '/' . $templateName . '.php', $id);

            if (!$fixture || $fixture === 1) {
                continue;
            }

            $key = $templateName . '_' . $id;

            $fixtures[$key] = $fixture;
        }

        $content = $this->exportFixtures($fixtures);

        // data file full path
        $dataFile = $fixtureDataPath . '/' . $templateName . '.php';

        // data file directory, create if it doesn't exist
        $dataFileDir = dirname($dataFile);
        if (!file_exists($dataFileDir)) {
            FileHelper::createDirectory($dataFileDir);
        }
        file_put_contents($dataFile, $content);
    }

    /**
     * @inheritdoc
     */
    public function checkPaths()
    {
        if ($this->suite) {
            $this->templatePath = "@app/modules/{$this->suite}/fixtures/templates";
            $this->fixtureDataPath = "@app/modules/{$this->suite}/fixtures/data";
        }

        return;
    }
}
