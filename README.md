Queue
====
 [![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)


This library is a Queueing Aystem abstraction layer. It enables you to implement any queueing system in your application, 
without having to depend on the actual implementation of the queueing system you choose. 

**Attention**: You will need a Process Control System like [supervisord](http://supervisord.org/) to keep your workers going.

Use Case
--------

***Queueing system***

Say you want to notify multiple users when a new comment is placed on a forum thread. Sending these email on the spot might
slow down your application significantly when many emails need to be send. When using a Queueing System you can delay this
action by adding the Jobs to a Queue. A worker will pick up these Jobs asynchronously from you web process. This way your 
application is future proof and you will have a much easier time scaling in the future.

***Library***

When you decide to use this library, you do not depend on the queueing system implementation. You can plug the driver of your
choice. You might choose a basic mysql version to get started and when you need more performance go for something like 
[beanstalkd](http://kr.github.io/beanstalkd/) or [RabbitMQ](https://www.rabbitmq.com/).

Code example
------------

```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Queue\Queue;
use Queue\Job\Job;
use Queue\Executor\JobExecutor;

$driver = new QueueDriver(); // Use your driver.
$queue = new Queue($driver);

// Add a job to the queue
$queue->addJob(new Job('notify_forum_thead', ['threadId' => 12]));
```


```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Queue\Queue;
use Queue\Worker\Worker;

$driver = new QueueDriver(); // Use your driver.
$queue = new Queue($driver);

$worker = new Worker($queue, new JobExecutor(), 1);
$worker->run();

```


Installation
------------

Run this command to get the latest version from [packagist](packagist.org):

```bash
$ composer require queue/queue
```

Contributing
------------

> All code contributions - including those of people having commit access - must
> go through a pull request and approved by a core developer before being
> merged. This is to ensure proper review of all the code.
>
> Fork the project, create a feature branch, and send us a pull request.
>
> To ensure a consistent code base, you should make sure the code follows
> the [Coding Standards](http://symfony.com/doc/2.0/contributing/code/standards.html)
> which we borrowed from Symfony.
> Make sure to check out [php-cs-fixer](https://github.com/fabpot/PHP-CS-Fixer) as this will help you a lot.

If you would like to help, take a look at the [list of issues](http://github.com/NoUseFreak/Queue/issues).

Requirements
------------

PHP 5.5 or above

Author and contributors
-----------------------

Dries De Peuter - <dries@nousefreak.be> - <http://nousefreak.be>

See also the list of [contributors](https://github.com/NoUseFreak/Queue/contributors) who participated in this project.

License
-------

Cron is licensed under the MIT license.
