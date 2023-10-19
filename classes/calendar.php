<?php
namespace classes;

use classes\QueryBuilder;

class calendar {

    protected $currentDay;
    protected $currentDate;
    protected $firstDay;
    protected $days = [
        'lunes','martes','miercoles','jueves','viernes','sabado','domingo'
    ];
    protected $months = [
        'enero', 'febrero', 'marzo', 'abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'
    ];

    public function __construct()
    {
        $current = date('d');
        $this->currentDate = date('d-m-Y');
        $this->currentDay  = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $this->firstDay    = mktime(0, 0, 0, date("m"), date("d") -$current, date("Y"));
    }

    public function getDays()
    {
        return $this->days;
    }

    public function getCurrentMonth()
    {
        return $this->months[date('n') -1];
    }

    public function getCurrentDate()
    {
        return $this->currentDate;
    }

    public function getFirstDayOfMonth($text = false)
    {
        $daysElapsed = date('N', $this->firstDay);
        if ($text){
            return $daysElapsed;
        }
        return $this->days[$daysElapsed];
    }

    public function getEventByDate($date)
    {
		$query = new QueryBuilder();
        $query->table('wallet_movements');
        $query->where([
			'date' => $date,
		]);
    }

    public function drawCalendar()
    {
        $daysOfMonth = date('t');
        $currentDay  = date('d');

        for($i=1; $i<=$daysOfMonth; $i++){
            echo "<div class='day'>";
            if ( $currentDay == $i ){
                echo "<span class='date active'>". $i ."</span>";
            } else {
                echo "<span class='date'>". $i ."</span>";
            }						
            echo "</div>";
        }
    }

}