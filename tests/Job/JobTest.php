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

class JobTest extends \PHPUnit_Framework_TestCase
{
    public function testProperties()
    {
        $name = 'name';
        $data = ['data'];

        $job = new Job($name, $data);

        $this->assertEquals($name, $job->getName());
        $this->assertEquals($data, $job->getData());
    }
}
