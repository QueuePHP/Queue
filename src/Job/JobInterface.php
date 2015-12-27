<?php

/**
 * This file is part of the Queue package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Queue\Job;

interface JobInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return array
     */
    public function getData();
}
