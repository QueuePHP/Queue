<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 27/12/15
 * Time: 14:53
 */

namespace Queue\Executor;


use Queue\Job\JobInterface;

class JobExecutor implements JobExecutorInterface
{
    /**
     * @param JobInterface $job
     *
     * @return bool
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
