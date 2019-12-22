<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-12-22
 * Time: 18:03
 */

namespace Retry;

/**
 * Class RetryAction
 * @package Retry
 */
class RetryAction
{
    /**
     * @var callable
     */
    protected $callable;

    /**
     * @var mixed
     */
    protected $expect;

    /**
     * RetryAction constructor.
     * @param callable $callable
     * @param mixed    $expect
     */
    public function __construct($callable, $expect)
    {
        $this->callable = $callable;
        $this->expect   = $expect;
    }

    /**
     * @throws \Exception
     */
    public function execute()
    {
        set_error_handler(array($this, 'errorHandler'));

        try {
            $result = call_user_func($this->callable);
            $expectResult = is_callable($this->expect) ? call_user_func($this->expect, $result) : $this->expect;
            if ($result !== $expectResult) {
                throw new RetryException(sprintf('the result (%s) is not as expected (%s)', $result, $expectResult));
            }
        } catch (\Exception $exception) {
            throw $exception;
        }

        restore_error_handler();
    }

    /**
     * @param int    $errNo
     * @param string $errStr
     * @param string $errFile
     * @param int    $errLine
     * @throws RetryException
     */
    public function errorHandler($errNo, $errStr, $errFile, $errLine) {
        $msg = sprintf('%s in %s on line %s%s', $errStr, $errFile, $errLine, PHP_EOL);

        if (error_reporting() == 0) {
            // skip silenced errors (@...)
            return;
        }

        if ($errNo < E_NOTICE) {
            throw new RetryException($msg, $errNo);
        } else {
            // print error
            echo $msg;
        }
    }

}
