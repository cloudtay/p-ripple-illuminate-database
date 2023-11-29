<?php

namespace PRipple\Illuminate\Database\PDO;

use Doctrine\DBAL\Driver\AbstractSQLiteDriver;
use PRipple\Illuminate\Database\PDO\Concerns\ConnectsToDatabase;

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
