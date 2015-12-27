<?php

/**
 * This file is part of the Queue package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Queue\Executor;

use Queue\Job\JobInterface;

class CallbackExecutor implements JobExecutorInterface
{
    /**
     * @param JobInterface $job
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function execute(JobInterface $job)
    {
        $data = $job->getData();

        if (!isset($data['callback'])) {
            throw new \InvalidArgumentException('Could not find callback.');
        }

        if (!is_callable($data['callback'])) {
            throw new \InvalidArgumentException('The callback needs to be a callable.');
        }

        $callback = $data['callback'];
        unset($data['callback']);

        return call_user_func($callback, $job->getName(), $data);
    }
}
