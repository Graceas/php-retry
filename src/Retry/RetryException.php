<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-12-22
 * Time: 18:13
 */

namespace Retry;

use Throwable;

/**
 * Class RetryException
 * @package Retry
 */
class RetryException extends \Exception
{
    /**
     * RetryException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
