<?php namespace AlistairShaw\Vendirun\App\ValueObjects;

use Config;

class DateWindow {

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
        $this->start = date("Y-m-d", strtotime($start));
        $this->end = date("Y-m-d", strtotime($end));
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
        $dateFormat = Config::get('vendirun::dateFormat', 'jS, M Y');

        return ($this->start == $this->end) ?
            date($dateFormat, strtotime($this->start))
            : 'Between ' . date($dateFormat, strtotime($this->start)) . ' and ' . date($dateFormat, strtotime($this->end));
    }
}