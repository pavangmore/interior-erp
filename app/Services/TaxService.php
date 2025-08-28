<?php namespace App\Services;
class TaxService {
  /** Determine intra vs inter and split GST */
  public static function splitGST(float $taxable, float $gstRate, string $supplierState, string $placeOfSupply): array {
    $gst = round($taxable * $gstRate / 100, 2);
    if ($supplierState === $placeOfSupply) {
      $cgst = round($gst/2,2); $sgst = $gst - $cgst; return ['cgst'=>$cgst,'sgst'=>$sgst,'igst'=>0.00];
    } else {
      return ['cgst'=>0.00,'sgst'=>0.00,'igst'=>$gst];
    }
  }
}
