<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/23
 * Time: 10:30
 */


namespace App\Providers;

use App\Logging\Processor\IntrospectionProcessor;
use App\Logging\Processor\ProcessIdProcessor;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Log\Logger as Writer;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogHandler;
use Monolog\Logger as Monolog;

/**
 * 日志记录器服务
 *
 * @package app.Providers
 */
class LogServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('log', function () {
            return $this->createAppLogger();
        });
        $this->app->singleton('sql-log', function () {
            return $this->createSqlLogger();
        });
    }

    /**
     * Create the app logger.
     *
     * @return \Illuminate\Log\Logger
     */
    public function createAppLogger()
    {
        //新增
        $processors = [
            new ProcessIdProcessor(),
            new IntrospectionProcessor()
        ];
        $log = new Writer(
//            new Monolog($this->channel()), $this->app['events']
             new Monolog($this->channel(), [], $processors), $this->app['events']
        );
        $this->configureHandler($log, 'app');
        return $log;
    }

    /**
     * Create the sql logger.
     *
     * @return \Illuminate\Log\Logger
     */
    public function createSqlLogger()
    {
        //新增
        $processors = [
            new ProcessIdProcessor(),
        ];
        $log = new Writer(
//            new Monolog($this->channel()), $this->app['events']
            new Monolog($this->channel(), [], $processors), $this->app['events']
        );
        $this->configureHandler($log, 'sql');
        return $log;
    }

    /**
     * Get the name of the log "channel".
     *
     * @return string
     */
    protected function channel()
    {
        return $this->app->bound('env') ? $this->app->environment() : 'production';
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Logger $log
     * @param string $base_name
     * @return void
     */
    protected function configureHandler(Writer $log, $base_name)
    {
        $this->{'configure' . ucfirst($this->handler()) . 'Handler'}($log, $base_name);
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Logger $log
     * @param string $base_name
     * @return void
     */
    protected function configureSingleHandler(Writer $log, $base_name)
    {
//        $log->useFiles(
//            sprintf('%s/logs/%s%s.log', $this->app->storagePath(), $this->getFilePrefix(), $base_name),
//            $this->logLevel()
//        );
        $path = sprintf('%s/logs/%s%s.log', $this->app->storagePath(), $this->getFilePrefix(), $base_name);
        $log->pushHandler($handler = new StreamHandler($path, $this->logLevel()));

        $handler->setFormatter($this->getDefaultFormatter());
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Logger $log
     * @param string $base_name
     * @return void
     */
    protected function configureDailyHandler(Writer $log, $base_name)
    {
//        $log->useDailyFiles(
//            sprintf('%s/logs/%s%s.log.%s', $this->app->storagePath(), $this->getFilePrefix(), $base_name, Carbon::now()->format('Ymd')),
//            $this->maxFiles(),
//            $this->logLevel()
//        );
        $path = sprintf('%s/logs/%s%s.log.%s', $this->app->storagePath(), $this->getFilePrefix(), $base_name, Carbon::now()->format('Ymd'));
        $log->pushHandler(
            $handler = new RotatingFileHandler($path, $this->maxFiles(), $this->logLevel())
        );
        $handler->setFormatter($this->getDefaultFormatter());
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Logger $log
     * @param string $base_name
     * @return void
     */
    protected function configureSyslogHandler(Writer $log, $base_name)
    {
//        $log->useSyslog($base_name, $this->logLevel());
        $log->pushHandler(new SyslogHandler($base_name, LOG_USER, $this->logLevel()));
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Logger $log
     * @param string $base_name
     * @return void
     */
    protected function configureErrorlogHandler(Writer $log, $base_name)
    {
//        $log->useErrorLog($this->logLevel());
        $log->pushHandler(
            $handler = new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, $this->logLevel())
        );
        $handler->setFormatter($this->getDefaultFormatter());
    }

    /**
     * Get the default log handler.
     *
     * @return string
     */
    protected function handler()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log', 'single');
        }

        return 'single';
    }

    /**
     * Get the log level for the application.
     *
     * @return string
     */
    protected function logLevel()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log_level', 'debug');
        }

        return 'debug';
    }

    /**
     * Get the maximum number of log files for the application.
     *
     * @return int
     */
    protected function maxFiles()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log_max_files', 5);
        }

        return 0;
    }
    /**
     * Get a default Monolog formatter instance.
     * 时间精确到微秒
     * @return \Monolog\Formatter\LineFormatter
     */
    protected function getDefaultFormatter()
    {
        return new LineFormatter(null, 'Y-m-d H:i:s.u', true, true);
    }
    /**
     * 获取文件前缀
     *
     * @return string
     */
    private function getFilePrefix()
    {
        return php_sapi_name() == 'cli' ? 'cli_' : '';
    }
}