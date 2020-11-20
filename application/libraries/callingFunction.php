<?php

// Wherever you want to invoke the print from
// Maybe a model, controller or other library/helper

try {
  $this->load->library('ReceiptPrint');
  $this->receiptprint->connect('192.168.0.110', 9100);
  $this->receiptprint->print_test_receipt('Hello World!');
} catch (Exception $e) {
  log_message("error", "Error: Could not print. Message ".$e->getMessage());
  $this->receiptprint->close_after_exception();
}

?>