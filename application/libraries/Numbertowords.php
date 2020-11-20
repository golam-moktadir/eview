<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Numbertowords {

    function convert_number($number) {
        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }
        $Gn = floor($number / 100000);
        /* Lakh */
        $number -= $Gn * 100000;
        $kn = floor($number / 1000);
        /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);
        /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);
        /* Tens (deca) */
        $n = $number % 10;
        /* Ones */
        $res = "";
        if ($Gn) {
            $res .= $this->convert_number($Gn) . " Lac";
        }
        if ($kn) {
            $res .= (empty($res) ? "" : " ") . $this->convert_number($kn) . " Thousand";
        }
        if ($Hn) {
            $res .= (empty($res) ? "" : " ") . $this->convert_number($Hn) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");
        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= " ";
            }
            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];
                if ($n) {
                    $res .= " " . $ones[$n];
                }
            }
        }
        if (empty($res)) {
            $res = "zero";
        }
        return $res;
    }

}

?>