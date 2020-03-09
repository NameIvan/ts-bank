<?php

use yii\db\Migration;

/**
 * Class m200308_191840_create_table_deposits
 */
class m200308_191840_create_table_deposits extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE `deposits` (
                `id` INT(11) NOT NULL AUTO_INCREMENT ,
                `client_id` INT(11) NOT NULL ,
                `start_account` DECIMAL(15,2) NOT NULL ,
                `account` DECIMAL(15,2) NOT NULL COMMENT 'Текущий счёт' ,
                `rate` DECIMAL(6,2) NOT NULL COMMENT 'Процент по депозиту' ,
                `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL ,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB;
        ");

        $this->execute("
            ALTER TABLE `deposits`
            ADD FOREIGN KEY `fk-clients-id-deposits-client_id`(`client_id`) 
            REFERENCES `clients`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
            ALTER TABLE `deposits` DROP FOREIGN KEY `fk-clients-id-deposits-client_id`;
        ");

        $this->execute("
            DROP TABLE IF EXISTS `deposits`;
        ");
    }
}
