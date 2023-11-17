<?php
namespace classes;

use classes\QueryBuilder;

class calendar {

    protected $currentDate;
    protected $firstDay;
    protected $month;

    public function __construct($month)
    {
        $current = date('d');
        $this->month = $month;
        $this->firstDay    = mktime(0, 0, 0, $this->month, date("d") -$current, date("Y"));
        $this->currentDate = date('d-m-Y');
    }

    public function getWeekDays()
    {
        return array(
            'lunes','martes','miercoles','jueves','viernes','sabado','domingo'
        );
    }

    public function getCurrentMonth()
    {  
        $monthsList = array(
            'none','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'
        );

        return $monthsList[$this->month];
    }

    public function getCurrentDate()
    {
        $parseDate = new DateTime($this->currentDate);
        return $parseDate->format('d-m-Y');
    }

    public function getFirstDayOfMonth($dayName = false)
    {
        $daysElapsed = date('N', $this->firstDay);
        if ($dayName){
            return $daysElapsed;
        }
        return $this->days[$daysElapsed];
    }
}