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

/**
 * Class RetryTest
 * @package Retry\Tests
 */
class RetryTest extends TestCase
{
    public function testRetry()
    {
        $retry = new Retry();
    }
}
