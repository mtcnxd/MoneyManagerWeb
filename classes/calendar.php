<?php
namespace classes;

use classes\QueryBuilder;

class calendar {

    protected $currentDate;
    protected $currentDay;
    protected $firstDay;

    public function __construct()
    {
        $current = date('d');
        $this->currentDate = date('d-m-Y');
        $this->currentDay  = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $this->firstDay    = mktime(0, 0, 0, date("m"), date("d") -$current, date("Y"));
    }

    public function getWeekDays()
    {
        return array(
            'lunes','martes','miercoles','jueves','viernes','sabado','domingo'
        );
    }

    public function getCurrentMonth()
    {  
        $months = array(
            'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'
        );

        return $months[date('n') -1];
    }

    public function getCurrentDate()
    {
        $parseDate = new DateTime($this->currentDate);
        return $parseDate->format('d-m-Y');
    }

    public function getFirstDayOfMonth($text = false)
    {
        $daysElapsed = date('N', $this->firstDay);
        if ($text){
            return $daysElapsed;
        }
        return $this->days[$daysElapsed];
    }
}