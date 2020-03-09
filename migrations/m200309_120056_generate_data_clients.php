<?php

use yii\db\Migration;

/**
 * Class m200309_120056_generate_data_clients
 */
class m200309_120056_generate_data_clients extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `clients` (`id`, `identification`, `first_name`, `last_name`, `gender`, `birthday`, `created_at`) 
            VALUES (1, '42142142134', 'Nick', 'Famnd', 'male', '1987-03-03', '2020-02-01 00:00:00'),
                (2, '55552140131', 'Bak', 'Smith', 'male', '1997-07-12', '2020-02-04 00:00:00'),
                (3, '72349042874', 'Katy', 'Asder', 'female', '1977-02-23', '2020-02-06 00:00:00');
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200309_120056_generate_data_clients cannot be reverted.\n";

        return false;
    }
}
