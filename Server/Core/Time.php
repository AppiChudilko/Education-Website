<?php

namespace Server\Core;

if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

class Time
{
    protected $timeStampNow;
    protected $dateTimeNow;

    protected $dateNow;
    protected $timeNow;

    protected $server;

    /**
     * Server constructor.
     * @param Server $server
     */
    function __construct(Server $server)
    {
        $this->server = $server;
        $this->timeStampNow = time();
        $this->dateTimeNow = gmdate('Y-m-d H:i:s', $this->timeStampNow);
        $this->dateNow = gmdate('Y-m-d', $this->timeStampNow);
        $this->timeNow = gmdate('H:i:s', $this->timeStampNow);
    }

    /**
     * Method. Get time stamp;
     */
    public function timeStampNow() {
        return $this->timeStampNow;
    }

    /**
     * Method. Get date time;
     */
    public function dateTimeNow() {
        return $this->dateTimeNow;
    }

    /**
     * Method. Get date;
     */
    public function dateNow() {
        return $this->dateNow;
    }

    /**
     * Method. Get time;
     */
    public function timeNow() {
        return $this->timeNow;
    }

    /**
     * Returns true if given date is today.
     *
     * @param int $timestamp Unix timestamp
     * @param int $offset Unix timestamp
     * @return boolean True if date is today
     */
    public function isToday($timestamp, $offset = 0) {
        return gmdate('Y-m-d', $timestamp) == gmdate('Y-m-d', $this->timeStampNow + $offset);
    }

    /**
     * Returns true if given date was yesterday
     *
     * @param int $timestamp Unix timestamp
     * @param int $offset Unix timestamp
     * @return boolean True if date was yesterday
     */
    public function isYesterday($timestamp, $offset = 0) {
        return gmdate('Y-m-d', $timestamp) == gmdate('Y-m-d', strtotime('yesterday') + $offset);
    }

    /**
     * Returns true if given date is in this year
     *
     * @param int $timestamp Unix timestamp
     * @param int $offset Unix timestamp
     * @return boolean True if date is in this year
     */
    public function isThisYear($timestamp, $offset = 0) {
        return gmdate('Y', $timestamp) == gmdate('Y', $this->timeStampNow + $offset);
    }

    /**
     * Returns true if given date is in this week
     *
     * @param int $timestamp Unix timestamp
     * @param int $offset Unix timestamp
     * @return boolean True if date is in this week
     */
    public function isThisWeek($timestamp, $offset = 0) {
        return gmdate('W Y', $timestamp) == gmdate('W Y', $this->timeStampNow + $offset);
    }

    /**
     * Returns true if given date is in this month
     *
     * @param int $timestamp Unix timestamp
     * @param int $offset Unix timestamp
     * @return boolean True if date is in this month
     */
    public function isThisMonth($timestamp, $offset = 0) {
        return gmdate('m Y',$timestamp) == gmdate('m Y', $this->timeStampNow + $offset);
    }
}