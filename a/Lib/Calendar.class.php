<?php

/**
 * @排期日历
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/11
 * @Copyright: blog.ghostry.cn
 */

namespace Lib;

class Calendar {

    private $year;
    private $month;
    private $weeks = array('日', '一', '二', '三', '四', '五', '六');
    public $data = array();

    function __construct($options = array()) {
        $this->year = date('Y');
        $this->month = date('m');

        $vars = get_class_vars(get_class($this));
        foreach ($options as $key => $value) {
            if (array_key_exists($key, $vars)) {
                $this->$key = $value;
            }
        }
    }

    function display($return = FALSE) {
        $str = '<table class="table calendar">';
        $str.=$this->showChangeDate();
        $str.=$this->showWeeks();
        $str.=$this->showDays($this->year, $this->month);
        $str.= '</table>';
        if ($return) {
            return $str;
        } else {
            echo $str;
        }
    }

    private function showWeeks() {
        $str = '<tr>';
        foreach ($this->weeks as $title) {
            $str.= '<th>' . $title . '</th>';
        }
        $str.= '</tr>';
        return $str;
    }

    private function showDays($year, $month) {
        $firstDay = mktime(0, 0, 0, $month, 1, $year);
        $starDay = date('w', $firstDay);
        $days = date('t', $firstDay);
        $str = '<tr>';
        for ($i = 0; $i < $starDay; $i++) {
            $str.= '<td>&nbsp;</td>';
        }

        for ($j = 1; $j <= $days; $j++) {
            $i++;
            $str.= '<td class="day';
            if (date('Ymd', strtotime($year . '-' . $month . '-' . $j)) == date('Ymd')) {
                $str.= ' today';
            }
            $str.=' ' . $this->data[$j]['class'];
            $str.= '">' . $j;
            $str.='<br />' . $this->data[$j]['value'];
            $str.='</td>';

            if ($i % 7 == 0) {
                $str.= '</tr><tr>';
            }
        }
        $str.= '</tr>';
        return $str;
    }

    private function showChangeDate() {

        $url = basename($_SERVER['PHP_SELF']);

        $str = '<tr>';
        $str.= '<td><a href="?' . $this->preYearUrl($this->year, $this->month) . '">' . '<<' . '</a></td>';
        $str.= '<td><a href="?' . $this->preMonthUrl($this->year, $this->month) . '">' . '<' . '</a></td>';
        $str.= '<td colspan="3"><form>';

        $str.= '<select name="year" onchange="window.location=\'' . $url . '?year=\'+this.options[selectedIndex].value+\'&month=' . $this->month . '\'">';
        for ($ye = 1970; $ye <= 2038; $ye++) {
            $selected = ($ye == $this->year) ? 'selected' : '';
            $str.= '<option ' . $selected . ' value="' . $ye . '">' . $ye . '</option>';
        }
        $str.= '</select>';
        $str.= '<select name="month" onchange="window.location=\'' . $url . '?year=' . $this->year . '&month=\'+this.options[selectedIndex].value+\'\'">';



        for ($mo = 1; $mo <= 12; $mo++) {
            $selected = ($mo == $this->month) ? 'selected' : '';
            $str.= '<option ' . $selected . ' value="' . $mo . '">' . $mo . '</option>';
        }
        $str.= '</select>';
        $str.= '</form></td>';
        $str.= '<td><a href="?' . $this->nextMonthUrl($this->year, $this->month) . '">' . '>' . '</a></td>';
        $str.= '<td><a href="?' . $this->nextYearUrl($this->year, $this->month) . '">' . '>>' . '</a></td>';
        $str.= '</tr>';
        return $str;
    }

    private function preYearUrl($year, $month) {
        $year = ($this->year <= 1970) ? 1970 : $year - 1;

        return 'year=' . $year . '&month=' . $month;
    }

    private function nextYearUrl($year, $month) {
        $year = ($year >= 2038) ? 2038 : $year + 1;

        return 'year=' . $year . '&month=' . $month;
    }

    private function preMonthUrl($year, $month) {
        if ($month == 1) {
            $month = 12;
            $year = ($year <= 1970) ? 1970 : $year - 1;
        } else {
            $month--;
        }

        return 'year=' . $year . '&month=' . $month;
    }

    private function nextMonthUrl($year, $month) {
        if ($month == 12) {
            $month = 1;
            $year = ($year >= 2038) ? 2038 : $year + 1;
        } else {
            $month++;
        }
        return 'year=' . $year . '&month=' . $month;
    }

}
