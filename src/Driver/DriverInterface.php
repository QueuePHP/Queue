<?php

/**
 * This file is part of the Queue package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Queue\Driver;

use Queue\Job\JobInterface;

interface DriverInterface
{
    /**
     * @param string       $queueName
     * @param JobInterface $job
     */
    public function addJob($queueName, JobInterface $job);

    /**
     * @param string $queueName
     * @return JobInterface
     */
    public function resolveJob($queueName);

    /**
     * @param string       $queueName
     * @param JobInterface $job
     */
    public function removeJob($queueName, JobInterface $job);

    /**
     * @param string $queueName
     * @param JobInterface $job
     */
    public function buryJob($queueName, JobInterface $job);
}
