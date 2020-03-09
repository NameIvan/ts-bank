<?php

use yii\db\Migration;

/**
 * Class m200308_184214_create_table_clients
 */
class m200308_184214_create_table_clients extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE `clients` ( 
                `id` INT(11) NOT NULL AUTO_INCREMENT ,
                `identification` VARCHAR(64) NOT NULL ,
                `first_name` VARCHAR(255) NOT NULL ,
                `last_name` VARCHAR(255) NOT NULL ,
                `gender` ENUM('male','female') NOT NULL ,
                `birthday` DATE NOT NULL ,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                PRIMARY KEY (`id`),
                UNIQUE `u-identification` (`identification`)
            ) ENGINE = InnoDB;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
            DROP TABLE IF EXISTS `clients`;
        ");
    }
}
