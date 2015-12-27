<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 27/12/15
 * Time: 13:42
 */

namespace Queue\Driver;


use Queue\Job\JobInterface;

interface DriverInterface
{
    /**
     * @param JobInterface $job
     */
    public function addJob(JobInterface $job);

    public function resolveJob();
    public function removeJob(JobInterface $job);
    public function buryJob(JobInterface $job);
}
