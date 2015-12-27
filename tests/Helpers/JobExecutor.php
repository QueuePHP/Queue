<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 27/12/15
 * Time: 19:36
 */

namespace Queue\Helpers;


use Queue\Executor\JobExecutorInterface;
use Queue\Job\JobInterface;

class JobExecutor implements JobExecutorInterface
{
    public function execute(JobInterface $job)
    {
        switch ($job->getName()) {
            case 'error':
                return false;
                break;

            case 'exception':
                throw new \Exception('error');
                break;

            case 'success':
            default:
                return true;
        }
    }
}
