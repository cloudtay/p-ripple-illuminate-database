<?php

namespace Cclilshy\PRipple\Database\PDO;

use Doctrine\DBAL\Driver\AbstractSQLiteDriver;
use Cclilshy\PRipple\Database\PDO\Concerns\ConnectsToDatabase;

class SQLiteDriver extends AbstractSQLiteDriver
{
    use ConnectsToDatabase;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pdo_sqlite';
    }
}
