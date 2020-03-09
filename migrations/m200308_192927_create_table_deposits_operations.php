<?php

use yii\db\Migration;

/**
 * Class m200308_192927_create_table_deposits_operations
 */
class m200308_192927_create_table_deposits_operations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE `deposits_operations` (
                `id` INT(11) NOT NULL AUTO_INCREMENT ,
                `deposit_id` INT(11) NOT NULL ,
                `type` TINYINT(1) UNSIGNED NOT NULL COMMENT '1 - Начисление процентов, 2 - Комиссия' ,
                `value` DECIMAL(15,2) NOT NULL COMMENT 'Денежная сумма' ,
                `date` DATE NOT NULL ,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB;
        ");

        $this->execute("
            ALTER TABLE `deposits_operations`
            ADD FOREIGN KEY `fk-deposits-id-deposits_operations`(`deposit_id`) 
            REFERENCES `deposits`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
            ALTER TABLE `deposits_operations` DROP FOREIGN KEY `fk-deposits-id-deposits_operations`;
        ");

        $this->execute("
            DROP TABLE IF EXISTS `deposits_operations`;
        ");
    }
}
