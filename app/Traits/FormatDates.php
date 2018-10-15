<?php
/**
 * Created by PhpStorm.
 * User: win8
 * Date: 6/20/2018
 * Time: 3:01 PM
 */
namespace App\Traits;

use DateInterval;
use DatePeriod;
use DateTime;

trait FormatDates
{



    public function get_start_end_arr($begin_date,$end_date,$get_all_leaves)
    {
        $date_array = [];
        foreach ($get_all_leaves as $check_leaves) {

            $begin = new DateTime($begin_date);
            //$end = clone $begin;
            $end = new DateTime($end_date);
            $end->setTime(0, 0, 1);
            $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
            foreach ($daterange as $date) {

                $date_array[] = $date->format("Y-m-d");


            }

            return $date_array;

        }
    }

}