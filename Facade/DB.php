<?php

namespace PRipple\Illuminate\Database\Facade;

use Carbon\CarbonInterval;
use Closure;
use DateTimeInterface;
use Exception;
use Generator;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use PDO;
use PDOStatement;
use PRipple\Illuminate\Database\ConnectionHook;
use PRipple\Illuminate\Database\DatabaseManager;
use PRipple\Illuminate\Database\DatabaseTransactionsManager;
use PRipple\Illuminate\Database\Grammar as BaseGrammar;
use PRipple\Illuminate\Database\Query\Builder as QueryBuilder;
use PRipple\Illuminate\Database\Query\Grammars\Grammar as QueryGrammar;
use PRipple\Illuminate\Database\Query\Processors\Processor;
use PRipple\Illuminate\Database\Schema\Builder as SchemaBuilder;
use PRipple\Illuminate\Database\Schema\Grammars\Grammar as SchemaGrammar;
use Throwable;

/**
 * @method static ConnectionHook connection(string|null $name = null)
 * @method static void registerDoctrineType(string $class, string $name, string $type)
 * @method static void purge(string|null $name = null)
 * @method static void disconnect(string|null $name = null)
 * @method static ConnectionHook reconnect(string|null $name = null)
 * @method static mixed usingConnection(string $name, callable $callback)
 * @method static string getDefaultConnection()
 * @method static void setDefaultConnection(string $name)
 * @method static string[] supportedDrivers()
 * @method static string[] availableDrivers()
 * @method static void extend(string $name, callable $resolver)
 * @method static void forgetExtension(string $name)
 * @method static array getConnections()
 * @method static void setReconnector(callable $reconnector)
 * @method static DatabaseManager setApplication(Application $app)
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static void useDefaultQueryGrammar()
 * @method static void useDefaultSchemaGrammar()
 * @method static void useDefaultPostProcessor()
 * @method static SchemaBuilder getSchemaBuilder()
 * @method static QueryBuilder table(Closure|QueryBuilder|Expression|string $table, string|null $as = null)
 * @method static QueryBuilder query()
 * @method static mixed selectOne(string $query, array $bindings = [], bool $useReadPdo = true)
 * @method static mixed scalar(string $query, array $bindings = [], bool $useReadPdo = true)
 * @method static array selectFromWriteConnection(string $query, array $bindings = [])
 * @method static array select(string $query, array $bindings = [], bool $useReadPdo = true)
 * @method static array selectResultSets(string $query, array $bindings = [], bool $useReadPdo = true)
 * @method static Generator cursor(string $query, array $bindings = [], bool $useReadPdo = true)
 * @method static bool insert(string $query, array $bindings = [])
 * @method static int update(string $query, array $bindings = [])
 * @method static int delete(string $query, array $bindings = [])
 * @method static bool statement(string $query, array $bindings = [])
 * @method static int affectingStatement(string $query, array $bindings = [])
 * @method static bool unprepared(string $query)
 * @method static array pretend(Closure $callback)
 * @method static mixed withoutPretending(Closure $callback)
 * @method static void bindValues(PDOStatement $statement, array $bindings)
 * @method static array prepareBindings(array $bindings)
 * @method static void logQuery(string $query, array $bindings, float|null $time = null)
 * @method static void whenQueryingForLongerThan(DateTimeInterface|CarbonInterval|float|int $threshold, callable $handler)
 * @method static void allowQueryDurationHandlersToRunAgain()
 * @method static float totalQueryDuration()
 * @method static void resetTotalQueryDuration()
 * @method static void reconnectIfMissingConnection()
 * @method static ConnectionHook beforeExecuting(Closure $callback)
 * @method static void listen(Closure $callback)
 * @method static Expression raw(mixed $value)
 * @method static string escape(string|float|int|bool|null $value, bool $binary = false)
 * @method static bool hasModifiedRecords()
 * @method static void recordsHaveBeenModified(bool $value = true)
 * @method static ConnectionHook setRecordModificationState(bool $value)
 * @method static void forgetRecordModificationState()
 * @method static ConnectionHook useWriteConnectionWhenReading(bool $value = true)
 * @method static bool isDoctrineAvailable()
 * @method static bool usingNativeSchemaOperations()
 * @method static mixed getDoctrineColumn(string $table, string $column)
 * @method static mixed getDoctrineSchemaManager()
 * @method static mixed getDoctrineConnection()
 * @method static PDO getPdo()
 * @method static PDO|Closure|null getRawPdo()
 * @method static PDO getReadPdo()
 * @method static PDO|Closure|null getRawReadPdo()
 * @method static ConnectionHook setPdo(PDO|Closure|null $pdo)
 * @method static ConnectionHook setReadPdo(PDO|Closure|null $pdo)
 * @method static string|null getName()
 * @method static string|null getNameWithReadWriteType()
 * @method static mixed getConfig(string|null $option = null)
 * @method static string getDriverName()
 * @method static QueryGrammar getQueryGrammar()
 * @method static ConnectionHook setQueryGrammar(QueryGrammar $grammar)
 * @method static SchemaGrammar getSchemaGrammar()
 * @method static ConnectionHook setSchemaGrammar(SchemaGrammar $grammar)
 * @method static Processor getPostProcessor()
 * @method static ConnectionHook setPostProcessor(Processor $processor)
 * @method static Dispatcher getEventDispatcher()
 * @method static ConnectionHook setEventDispatcher(Dispatcher $events)
 * @method static void unsetEventDispatcher()
 * @method static ConnectionHook setTransactionManager(DatabaseTransactionsManager $manager)
 * @method static void unsetTransactionManager()
 * @method static bool pretending()
 * @method static array getQueryLog()
 * @method static array getRawQueryLog()
 * @method static void flushQueryLog()
 * @method static void enableQueryLog()
 * @method static void disableQueryLog()
 * @method static bool logging()
 * @method static string getDatabaseName()
 * @method static ConnectionHook setDatabaseName(string $database)
 * @method static ConnectionHook setReadWriteType(string|null $readWriteType)
 * @method static string getTablePrefix()
 * @method static ConnectionHook setTablePrefix(string $prefix)
 * @method static BaseGrammar withTablePrefix(BaseGrammar $grammar)
 * @method static void resolverFor(string $driver, Closure $callback)
 * @method static mixed getResolver(string $driver)
 * @method static void beginTransaction()
 * @method static void commit()
 * @method static void rollBack(int|null $toLevel = null)
 * @method static int transactionLevel()
 * @method static void afterCommit(callable $callback)
 *
 * @see DatabaseManager
 */
class DB extends Facade
{
    /**
     * @param Closure     $closure
     * @param string|null $name
     * @return mixed
     * @throws Throwable
     */
    public static function transaction(Closure $closure, string|null $name = 'default'): mixed
    {
        $connection       = DB::connection($name);
        $pdo              = $connection->getPdo();
        $connection->mode = ConnectionHook::MODE_ORIGINAL;

        try {
            $pdo->beginTransaction();
            $result = call_user_func($closure);
            if (!$pdo->commit()) {
                throw new Exception('commit failed');
            }
            return $result;
        } catch (Throwable $exception) {
            $pdo->rollBack();
            throw $exception;
        } finally {
            $connection->mode = ConnectionHook::MODE_PROXY;
        }
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'db';
    }
}

