<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 27/12/15
 * Time: 14:53
 */

namespace Queue\Executor;


use Queue\Job\JobInterface;

interface JobExecutorInterface
{
    /**
     * @param JobInterface $job
     *
     * @return bool
     */
    public function execute(JobInterface $job);
}
