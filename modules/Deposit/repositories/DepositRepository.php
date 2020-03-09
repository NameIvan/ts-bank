<?php
namespace app\modules\Deposit\repositories;

use app\models\Deposits;
use app\models\DepositsOperations;
use app\modules\Deposit\enums\DepositOperationEnum;


class DepositRepository
{
    /**
     * @param string $day
     * @param string $periodStart
     * @param string $periodEnd
     * @return \yii\db\ActiveQuery
     */
    public function getPercentQuery(string $day, string $periodStart, string $periodEnd) {
        $operationTable = DepositsOperations::tableName();
        $depositTable = Deposits::tableName();

        return Deposits::find()
            ->leftJoin($operationTable,
                $operationTable . '.deposit_id = ' . $depositTable . '.id AND '
                . $operationTable . '.date = "' . $day . '"'
                . ' AND type = ' . DepositOperationEnum::TYPE_PERCENT
            )
            ->where([
                'AND',
                [$operationTable . '.id' => null],
                ['>=', $depositTable . '.created_at', $periodStart],
                ['<=', $depositTable . '.created_at', $periodEnd]
            ])
            ->orderBy($depositTable . '.id');
    }

    /**
     * @param string $day
     * @return \yii\db\ActiveQuery
     */
    public function getCommissionQuery(string $day) {
        $operationTable = DepositsOperations::tableName();
        $depositTable = Deposits::tableName();

        return Deposits::find()
            ->leftJoin($operationTable,
                $operationTable . '.deposit_id = ' . $depositTable . '.id AND '
                . $operationTable . '.date = "' . $day . '"'
                . ' AND type = ' . DepositOperationEnum::TYPE_COMMISSION
            )
            ->where([$operationTable . '.id' => null])
            ->orderBy($depositTable . '.id');
    }
}