<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/24
 * Time: 14:52
 */

namespace App\Logging\Processor;


/**
 * Monolog用处理模块
 * 标准IntrospectionProcessor的简化版, 原输出键值文字长度过长
 * Class ProcessIdProcessor
 * @package App\Logging\Processor
 */
class ProcessIdProcessor
{
    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $record['extra']['pid'] = getmypid();

        return $record;
    }
}