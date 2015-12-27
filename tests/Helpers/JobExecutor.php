<?php

/**
 * This file is part of the Queue package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
