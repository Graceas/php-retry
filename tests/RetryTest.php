<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-12-22
 * Time: 16:16
 */

namespace Retry\Tests;

use PHPUnit\Framework\TestCase;
use Retry\Retry;
use Retry\RetryAction;
use Retry\Strategy\LinearRetryStrategy;

/**
 * Class RetryTest
 * @package Retry\Tests
 */
class RetryTest extends TestCase
{
    public function testRetryFailed()
    {
        $retry = new Retry();

        $retry->retry(
            new RetryAction(
                function() {
                    return 1 / 0;
                },
                null
            ),
            new LinearRetryStrategy(10, 5)
        );

        $this->assertTrue(!$retry->isSuccess());
    }

    public function testRetrySuccess()
    {
        $retry = new Retry();

        $i = 0;

        $retry->retry(
            new RetryAction(
                function() use (&$i) {
                    // simulate non-periodic error (eg broken database connection)
                    $i++;

                    return ($i > 3) ? $i : 1 / 0;
                },
                4
            ),
            new LinearRetryStrategy(10, 5)
        );

        $this->assertTrue($retry->isSuccess());
    }

    public function testRetrySuccessWithCallback()
    {
        $retry = new Retry();

        $i = 0;

        $retry->retry(
            new RetryAction(
                function() use (&$i) {
                    // simulate non-periodic error (eg broken database connection)
                    $i++;

                    return ($i > 4) ? $i : 1 / 0;
                },
                function ($result) {
                    return ($result === 5) ? $result : false;
                }
            ),
            new LinearRetryStrategy(10, 5)
        );

        $this->assertTrue($retry->isSuccess());
    }
}
