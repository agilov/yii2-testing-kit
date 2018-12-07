<?php

namespace agilov\yii2testingkit;

use yii\helpers\VarDumper;

/**
 * Trait DynamicFixtureTrait
 *
 * @author Roman Agilov <agilovr@gmail.com>
 */
trait DynamicFixtureTrait
{
    /**
     * @param callable $func
     * @param string $filename
     * @param array $depends
     */
    public function generateFile(callable $func, string $filename, array $depends = [])
    {
        if (file_exists($filename)) {
            return;
        }

        $generator = new FixtureGenerator($func, $depends);
        $generator->initFixtures();
        $generator->generate->call($generator);
        $generator->unloadFixtures();

        $folder = dirname($filename);
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        file_put_contents($filename, "<?php\n\nreturn " . VarDumper::export($generator->data) . ";\n");
    }
}
