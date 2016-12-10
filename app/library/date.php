<?php

namespace App\library;


class Date
{

  public function covertDateToSting($date) {
    $date = explode('-', $date);
    return (int)$date[2].' '.$this->getMonthName($date[1]).' '.($date[0]+543);
  }

  public function getMonthName($month) {   

    $monthName = null;

    switch ($month) {
      case 1:
        $monthName = 'มกราคม';
        break;
      
      case 2:
        $monthName = 'กุมภาพันธ์';
        break;
      
      case 3:
        $monthName = 'มีนาคม';
        break;
      
      case 4:
        $monthName = 'เมษายน';
        break;
      
      case 5:
        $monthName = 'พฤษภาคม';
        break;
      
      case 6:
        $monthName = 'มิถุนายน';
        break;
      
      case 7:
        $monthName = 'กรกฎาคม';
        break;
      
      case 8:
        $monthName = 'สิงหาคม';
        break;
      
      case 9:
        $monthName = 'กันยายน';
        break;
      
      case 10:
        $monthName = 'ตุลาคม';
        break;
      
      case 11:
        $monthName = 'พฤศจิกายน';
        break;
      
      case 12:
        $monthName = 'ธันวาคม';
        break;

    }

    return $monthName;

  } 
}
