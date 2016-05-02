<?php namespace AlistairShaw\Vendirun\App\ValueObjects;

use Config;

class TimeWindow {

    /**
     * @var string
     */
    private $start;

    /**
     * @var string
     */
    private $end;

    /**
     * DateWindow constructor.
     * @param $start
     * @param $end
     */
    private function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @param $start
     * @param $end
     * @return DateWindow|null
     */
    public static function make($start, $end)
    {
        if (!$start || !$end) return null;

        return new self($start, $end);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $start = date("g:ia", strtotime('1970-01-01 ' . $this->start));
        $end = date("g:ia", strtotime('1970-01-01 ' . $this->end));

        return ($start == $end) ? $start : 'Between ' . $start . ' and ' . $end;
    }
}