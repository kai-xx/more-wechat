<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/24
 * Time: 18:35
 */

namespace App\Logging;


use Illuminate\Contracts\Foundation\Application;

/**
 * 获取include时的时间
 */
if (!defined('APP_START_TIME')) {
    define('APP_START_TIME', microtime(true));
}

/**
 * 日志采集类
 *
 * @package app.Bootstrap
 */
class ApplicationLog
{
    /**
     * 警告阈值： 内存100M
     */
    const THRESHOLD_WARNING_MEMORY = 100;

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $this->app = $app;

        // 当是测试时，不采集日志
        if (!$app->environment('testing')) {
            // 追加记录结束日志
            register_shutdown_function([$this, 'handleShutdownLog']);

            // 开始日志
            $this->startupLog();
        }
    }

    /**
     * 开始日志
     */
    public function startupLog()
    {
        if ($this->app->runningInConsole()) {
            $command = sprintf('php %s', implode(' ', (array)array_get($GLOBALS, 'argv')));
            $params = compact('command');
        } else {
            $method = $_SERVER['REQUEST_METHOD'];
            $uri = $_SERVER['REQUEST_URI'];
            $params = compact('method', 'uri');
        }
        app('log')->info('-- Startup', $params);
    }

    /**
     * 结束日志
     *
     * @return void
     */
    public function handleShutdownLog()
    {
        $time = $this->getProcessingTime();
        $memory = $this->getPeekMemory();
        if ($this->isOverUsingMemory(self::THRESHOLD_WARNING_MEMORY)) {
            app('log')->warning('using a large amount of memory.', compact('memory'));
        }
        app('log')->info('-- Shutdown', compact('time', 'memory'));
    }

    /**
     * 添加时间单位
     *
     * @param float $time
     * @return string
     */
    protected function formatTime($time)
    {
        if ($time < 1) {
            return sprintf('%0.3f[ms]', $time * 1000);
        } else if ($time < (1 / 1000)) {
            return sprintf('%0.3f[μs]', $time * 1000 * 1000);
        }
        return sprintf('%0.3f[s]', $time);
    }

    /**
     * 添加内存单位
     *
     * @param float $value
     * @return string
     */
    protected function formatMemory($value)
    {
        if ($value < 1024 * 10) {
            return sprintf('%s[b]', $value);
        } else if ($value < (1024 * 1024 * 10)) {
            return sprintf('%s[kb]', round($value / 1024, 1));
        } else {
            return sprintf('%s[mb]', round($value / (1024 * 1024), 2));
        }
    }

    /**
     * @param int $threshold 阈值（MB）
     * @return bool
     */
    protected function isOverUsingMemory($threshold)
    {
        return round(memory_get_peak_usage(1) / 1024 / 1024) > $threshold;
    }

    /**
     * 获取处理时间
     *
     * @return string
     */
    protected function getProcessingTime()
    {
        return $this->formatTime(microtime(true) - APP_START_TIME);
    }

    /**
     * 获取内存使用峰值
     *
     * @return float
     */
    protected function getPeekMemory()
    {
        return $this->formatMemory(memory_get_peak_usage(true));
    }

}