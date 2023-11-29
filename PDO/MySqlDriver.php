<?php

namespace PRipple\Illuminate\Database\PDO;

use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use PRipple\Illuminate\Database\PDO\Concerns\ConnectsToDatabase;

class MySqlDriver extends AbstractMySQLDriver
{
    use ConnectsToDatabase;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pdo_mysql';
    }
}
