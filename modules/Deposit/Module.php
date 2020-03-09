<?php
namespace app\modules\Deposit;

use app\modules\Deposit\repositories\DepositRepository;
use app\modules\Deposit\services\DepositService;
use app\modules\Module AS ModuleBase;
use Yii;

class Module extends ModuleBase
{
    public $moduleName = 'Deposit';

    public function init()
    {
        Yii::$container->set('DepositService', [
            'class' => DepositService::class,
        ]);

        Yii::$container->set('DepositRepository', [
            'class' => DepositRepository::class,
        ]);


        return parent::init();
    }
}