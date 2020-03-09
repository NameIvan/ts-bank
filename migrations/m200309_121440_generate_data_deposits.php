<?php

use yii\db\Migration;

/**
 * Class m200309_121440_generate_data_deposits
 */
class m200309_121440_generate_data_deposits extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `deposits` (`id`, `client_id`, `start_account`, `account`, `rate`, `updated_at`, `created_at`)
            VALUES (1, '1', '1000', '1000', '5.5', '2020-02-02 14:20:00', '2020-02-02 14:20:00'),
                (2, '2', '105.5', '105.5', '5.5', '2020-02-08 15:00:00', '2020-02-08 15:00:00'),
                (3, '2', '1000', '1000', '4', '2020-02-09 00:00:00', '2020-02-09 00:00:00'),
                (4, '2', '425', '425', '3', '2020-02-10 10:00:00', '2020-02-10 10:00:00');
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200309_121440_generate_data_deposits cannot be reverted.\n";

        return false;
    }
}
