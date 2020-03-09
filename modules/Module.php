<?php
namespace app\modules;

use Yii;
use yii\base\Module AS ModuleBase;


abstract class Module extends ModuleBase
{
    public $moduleName;

    protected function setContainer(array $services)
    {
        foreach ($services as $serviceName => $definitionAndParams) {
            Yii::$container->set($serviceName, $definitionAndParams[0], $definitionAndParams[1] ?? []);
        }
    }
}