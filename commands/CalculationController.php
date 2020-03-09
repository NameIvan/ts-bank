<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\console\ExitCode;

class CalculationController extends Controller
{
    /**
     *
     * run script 'php yii calculation 2020-03-10' or 'php yii calculation' for yesterday
     *
     *
     * @param null $date
     * @return int
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionIndex($date = null)
    {
        if ($date) {
            if (!strtotime($date)) {
                echo "Invalid date format";
                die;
            }

            $lastDayOfMonth = date("Y-m-t", strtotime($date));
            $day = date("Y-m-d", strtotime($date));
            $periodStart = date("Y-m-d 00:00:00", strtotime( $date . '-1 month' ));
            $periodEnd = date(
                ($lastDayOfMonth === $day) ? "Y-m-t 23:59:59" : "Y-m-d 23:59:59",
                strtotime( $date . '-1 month' )
            );
        } else {
            $lastDayOfMonth = date("Y-m-t", strtotime( '-1 days' ));
            $day = date("Y-m-d", strtotime( '-1 days' ));
            $periodStart = date("Y-m-d 00:00:00", strtotime( '-1 month - 1 day' ));
            $periodEnd = date(
                ($lastDayOfMonth === $day) ? "Y-m-t 23:59:59" : "Y-m-d 23:59:59",
                strtotime( '-1 month - 1 day' )
            );
        }

        /* When the previous month has less days than the current*/
        if (date("Y-m", strtotime($day)) === date("Y-m", strtotime($periodEnd))) {
            echo "For the date already count \n";
            die;
        }

        /** @var \app\modules\Deposit\services\DepositService $depositService */
        $depositService = Yii::$container->get("DepositService");
        /** @var \app\modules\Deposit\repositories\DepositRepository $depositRepository */
        $depositRepository = Yii::$container->get("DepositRepository");

        echo "Start calculation deposits for $day \n\n";

        //Начисление процентов
        $queryPercent = $depositRepository->getPercentQuery($day, $periodStart, $periodEnd);
        foreach ($queryPercent->each() as $deposit) {
            $result = $depositService->addPercent($deposit, $day);
            if (!$result)
                throw new Exception('Something when wrong during Percent count');

            echo " Deposit percent - ID $deposit->id was updated \n";
        }

        echo "\n\n";

        // Снятие коммисии
        if ($lastDayOfMonth === $day) {
            $queryCommission = $depositRepository->getCommissionQuery($day);
            foreach ($queryCommission->each() as $deposit) {
                $result = $depositService->addCommission($deposit, $day);
                if (!$result)
                    throw new Exception('Something when wrong during Percent count');

                echo " Deposit commission - ID $deposit->id was updated \n";
            }
        }

        echo "\nEnd calculation deposits for $day \n";

        return ExitCode::OK;
    }
}
