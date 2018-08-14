<?php

namespace App\Models;

/**
 * This model doesn't extend from Model because for this example
 * it has no database integration
 *
 * Class ClockCalculationResult
 * @package App\Models
 */
class ClockCalculationResult
{
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

    public function __construct($status, $message, $content = [])
    {
        $this->status = $status;
        $this->message = $message;
        $this->content = $content;
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
}
