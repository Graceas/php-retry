Retry
=====

A library for retrying actions that can fail.

Installation
============

Through composer:

    "require": {
        ...
        "graceas/php-retry": "v0.0.3"
        ...
    }

Usage (general example)
=======================

    $retry = new Retry();
    
    $i = 0;

    $retry->retry(
        new RetryAction(
            // can pass any action that can fail (database query, curl loading, etc)
            function() use (&$i) {
                // simulate non-periodic error (eg broken database connection)
                $i++;

                return ($i > 3) ? $i : 1 / 0;
            },
            4 // expect 4 as result for callable function
        ),
        new LinearRetryStrategy(10 /* timeout ms */, 5 /* retrying times */)
    );

    if ($retry->isSuccess()) {
        // task success
    } else {
        // task failed
        // echo $retry->getLog();
    }

Example Output
==============

    echo $retry->getLog();

    > 1577074792: [1 of 5] [sleep 10] Division by zero in /Users/gorelov/projects/php-retry/tests/RetryTest.php on line 52
    > 1577074792: [2 of 5] [sleep 10] Division by zero in /Users/gorelov/projects/php-retry/tests/RetryTest.php on line 52
    > 1577074792: [3 of 5] [sleep 10] Division by zero in /Users/gorelov/projects/php-retry/tests/RetryTest.php on line 52
    > 1577074977: [4 of 5] [sleep 10] success

Backoff Strategies
==================

LinearRetryStrategy -
Each attempt waits a configured time.

ExponentialRetryStrategy - 
The base delay time is calculated as: time ^ attempt
where attempt is the number of unsuccessful attempts that have been made.
