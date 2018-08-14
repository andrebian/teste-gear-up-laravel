<?php

namespace App\Models;

use Zend\Hydrator\ClassMethods;

/**
 * This model doesn't extend from Model because for this example
 * it has no database integration.
 *
 * Class TimeResult
 * @package App\Models
 */
class TimeResult
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $content;

    public function __construct($data = [])
    {
        $this->content = [];
        if (! empty($data)) {
            $hydrator = new ClassMethods(false);
            $hydrator->hydrate($data, $this);
        }
    }

    /**
     * @param $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param string $status
     * @return TimeResult
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $message
     * @return TimeResult
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param array $content
     * @return TimeResult
     */
    public function setContent(array $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $hydrator = new ClassMethods(false);
        return $hydrator->extract($this);
    }
}
