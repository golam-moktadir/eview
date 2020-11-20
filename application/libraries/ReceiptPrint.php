<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// IMPORTANT - Replace the following line with your path to the escpos-php autoload script
require_once __DIR__ . '/escpos-php/autoload.php';

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

class ReceiptPrint
{

    private $CI;
    private $connector;
    private $printer;
    private $profile;

    // TODO: printer settings
    // Make this configurable by printer (32 or 48 probably)
    private $printer_width = 32;

    function __construct()
    {
        $this->CI =& get_instance(); // This allows you to call models or other CI objects with $this->CI->...
    }

    function connect($ip_address, $port)
    {
        $this->connector = new NetworkPrintConnector($ip_address, $port);
        $this->printer = new Printer($this->connector);
    }

    function connect_windows($receipt_printer)
    {
        $this->profile = CapabilityProfile::load("simple");
        $this->connector = new WindowsPrintConnector("smb://User:hp@LAPTOP-3P2HISGP/".$receipt_printer);
        $this->printer = new Printer($this->connector, $this->profile);
    }

    public function close_after_exception()
    {
        if (isset($this->printer) && is_a($this->printer, 'Mike42\Escpos\Printer')) {
            $this->printer->close();
        }
        $this->connector = null;
        $this->printer = null;
        $this->emc_printer = null;
    }

    public function print_test_receipt($text = "")
    {

        $this->check_connection();
        $this->printer->setJustification(Printer::JUSTIFY_CENTER);
        $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $this->add_line("TESTING");
        $this->add_line("Receipt Print");
        $this->printer->selectPrintMode();
        $this->add_line(); // blank line
        $this->add_line($text);
        $this->add_line(); // blank line
        $this->add_line(date('Y-m-d H:i:s'));
        $this->printer->cut(Printer::CUT_PARTIAL);
        $this->printer->close();
    }

    private function check_connection()
    {
        if (!$this->connector OR !$this->printer OR !is_a($this->printer, 'Mike42\Escpos\Printer')) {
            throw new Exception("Tried to create receipt without being connected to a printer.");
        }
    }

    // Calls printer->text and adds new line

    private function add_line($text = "", $should_wordwrap = true)
    {
        $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
        $this->printer->text($text . "\n");
    }

    public function print_invoice($datetime, $all_sales, $invoice_total, $discount, $sub_total)
    {
        $items = array();
        foreach ($all_sales as $sales) {
            $items[] = new item($sales[2] . ': ' . $sales[3], $sales[6], $sales[7], $sales[9], $sales[10], $sales[11]);
        }
        $subtotal = new item('Sub Total', '', '', '', '', $invoice_total);
        $subtotal_discount = new item('Discount', '', '', '', '', $discount);
        $grand_total = new item('Total', '', '', '', '', $sub_total);
//        $tax = new item('A local tax', '1.30');
//        $total = new item('Total', '14.25', '1', true);
        /* Date is kept the same for testing */
// $date = date('l jS \of F Y h:i:s A');
        $date = $datetime;

        /* Start the printer */
        $logo = EscposImage::load(__DIR__ . "escpos-php/src/Mike42/Escpos/resources/banner.jpg", false);

        /* Print top logo */
        $this->printer->setJustification(Printer::JUSTIFY_CENTER);
        $this->printer->graphics($logo);

        /* Name of shop */
        $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $this->printer->text("Remax Technology Bangladesh Ltd.\n");
        $this->printer->selectPrintMode();
        $this->printer->text("Skylark MAK84, House#84, Level#B, Road#11\nBlock#D Banani, Dhaka-1213\nMobile: 01713 043909");
        $this->printer->feed();

        /* Title of receipt */
        $this->printer->setEmphasis(true);
        $this->printer->text("SALES INVOICE\n");
        $this->printer->setEmphasis(false);

        /* Items */
        $this->printer->setJustification(Printer::JUSTIFY_LEFT);
        $this->printer->setEmphasis(true);
        $this->printer->text(new item('Product', 'Unit', 'Qty', 'Amount', 'Discount', 'Total'));
        $this->printer->setEmphasis(false);
        foreach ($items as $item) {
            $this->printer->text($item);
        }

        $this->printer->feed();
        $this->printer->setEmphasis(true);
        $this->printer->text($subtotal);
        $this->printer->text($subtotal_discount);
        $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $this->printer->text($grand_total);
        $this->printer->setEmphasis(false);

        /* Tax and total */
//        $this->printer->text($tax);
        $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
//        $this->printer->text($total);
        $this->printer->selectPrintMode();

        /* Footer */
        $this->printer->feed(2);
        $this->printer->setJustification(Printer::JUSTIFY_CENTER);
        $this->printer->text("Thank you for shopping at Remax Technology Bangladesh Ltd\n");
//        $this->printer->text("For trading hours, please visit example.com\n");
        $this->printer->feed(2);
        $this->printer->text($date . "\n");

        /* Cut the receipt and open the cash drawer */
        $this->printer->cut();
        $this->printer->pulse();

        $this->printer->close();
    }

}

/* A wrapper to do organise item names & prices into columns */

class item
{
    private $name;
    private $unit;
    private $quantity;
    private $price;
    private $discount;
    private $total;

    public function __construct($name = '', $unit = '', $quantity = '', $price = '', $discount = '', $total = '')
    {
        $this->name = $name;
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->discount = $discount;
        $this->total = $total;
    }

    public function __toString()
    {

        $name = str_pad($this->name, 10);
        $unit_quanitty = str_pad($this->unit . ' ×' . $this->quantity, 10);
        $price = str_pad($this->price, 10);
        $discount = str_pad($this->discount . '%', 10);
        $total = str_pad($this->total, 10);

        return "$name$unit_quanitty$price$discount$total\n";
    }
}
