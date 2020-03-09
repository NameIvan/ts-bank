<?php
namespace app\modules\Deposit\services;

use app\models\Deposits;
use app\models\DepositsOperations;
use app\modules\Deposit\enums\DepositOperationEnum;
use Yii;
use yii\base\Exception;

class DepositService
{

    const MIN_COMMISSION = 50;
    const MAX_COMMISSION = 5000;

    /**
     * @param Deposits $deposit
     * @param string $day
     * @return bool
     */
    public function addPercent(Deposits $deposit, string $day): bool
    {
        $amount = floor($deposit->account * $deposit->rate)/100;

        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $deposit->account = $deposit->account + $amount;
            if (!$deposit->save())
                throw new Exception("Couldn't update deposit!");

            $depositOperation = new DepositsOperations();
            $depositOperation->deposit_id = $deposit->id;
            $depositOperation->type = DepositOperationEnum::TYPE_PERCENT;
            $depositOperation->value = $amount;
            $depositOperation->date = $day;
            if (!$depositOperation->save())
                throw new Exception("Couldn't update deposit operation!");

            $transaction->commit();
            $result = true;
        } catch(\Exception $e) {
            $result = false;

            $transaction->rollBack();
        }

        return $result;
    }

    /**
     * @param Deposits $deposit
     * @param string $day
     * @return bool
     */
    public function addCommission(Deposits $deposit, string $day): bool
    {
        $amount = $this->countCommission($deposit->account);

        // if deposit open in current month
        if (date("Y-m", strtotime($deposit->created_at)) == date("Y-m", strtotime($day))) {
            $amount = $this->correctionCommission($amount, $deposit->created_at, $day);
        }

        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $deposit->account = $deposit->account - $amount;
            if (!$deposit->save())
                throw new Exception("Couldn't update deposit!");

            $depositOperation = new DepositsOperations();
            $depositOperation->deposit_id = $deposit->id;
            $depositOperation->type = DepositOperationEnum::TYPE_COMMISSION;
            $depositOperation->value = $amount;
            $depositOperation->date = $day;
            if (!$depositOperation->save())
                throw new Exception("Couldn't update deposit operation!");

            $transaction->commit();
            $result = true;
        } catch(\Exception $e) {
            $result = false;

            $transaction->rollBack();
        }

        return $result;
    }

    public function countCommission($account) {
        if ($account < 1000) {
            $commission = floor($account * 5)/100;
            $commission = ($commission < static::MIN_COMMISSION) ? static::MIN_COMMISSION : $commission;
        } elseif ($account < 10000) {
            $commission = floor($account * 6)/100;
        } else {
            $commission = floor($account * 7)/100;
            $commission = ($commission > static::MAX_COMMISSION) ? static::MAX_COMMISSION : $commission;
        }

        return $commission;
    }

    public function correctionCommission($commission, $created, $lastDay) {
        $days = (int) (date("d", strtotime($lastDay) - strtotime($created)) + 1);
        $allDaysInMonth = (int) date("d", strtotime($lastDay));

        return floor(100 * $commission * $days/$allDaysInMonth)/100;
    }
}