<?php

namespace Cclilshy\PRipple\Database\PDO;

use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use Cclilshy\PRipple\Database\PDO\Concerns\ConnectsToDatabase;

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
