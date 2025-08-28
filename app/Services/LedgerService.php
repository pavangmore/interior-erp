<?php namespace App\Services; use CodeIgniter\Database\BaseConnection;
class LedgerService {
  protected BaseConnection $db;
  public function __construct(BaseConnection $db){ $this->db=$db; }

  public function postInvoice(array $inv){
    $this->db->transStart();
    $this->db->table('fin_journal')->insert([
      'jv_no'=>'SI-'.$inv['invoice_no'], 'jv_date'=>$inv['invoice_date'],
      'narration'=>'Sales Invoice '.$inv['invoice_no'], 'ref_table'=>'fin_invoice', 'ref_id'=>$inv['id']
    ]);
    $jvId = $this->db->insertID();

    // Dr Accounts Receivable
    $this->line($jvId,'1100',(float)$inv['grand_total'],'D', 'customer',$inv['client_id']);
    // Cr Revenue
    $this->line($jvId,'4000',(float)$inv['taxable_value'],'C');
    // Cr Output taxes
    if((float)$inv['cgst']>0 || (float)$inv['sgst']>0){ $this->line($jvId,'2100',(float)$inv['cgst'],'C'); $this->line($jvId,'2110',(float)$inv['sgst'],'C'); }
    if((float)$inv['igst']>0){ $this->line($jvId,'2120',(float)$inv['igst'],'C'); }

    $this->db->transComplete();
    return $this->db->transStatus();
  }

  public function postReceipt(array $rcpt){
    $inv = $this->db->table('fin_invoice')->where('id',$rcpt['invoice_id'])->get()->getRowArray();
    if(!$inv) return false;
    $tds = (float)($rcpt['tds'] ?? 0);
    $net = (float)$rcpt['amount'];
    $this->db->transStart();
    $this->db->table('fin_journal')->insert([
      'jv_no'=>'RCPT-'.($rcpt['receipt_no'] ?? 'AUTO'), 'jv_date'=>$rcpt['receipt_date'],
      'narration'=>'Receipt against '.$inv['invoice_no'], 'ref_table'=>'fin_receipt', 'ref_id'=>$rcpt['id'] ?? null
    ]); $jvId = $this->db->insertID();

    // Dr Bank (net), Dr TDS Receivable (if client deducted), Cr Accounts Receivable (gross)
    if($net>0) $this->line($jvId,'1000',$net,'D');
    $this->ensureAccount('1230','TDS Receivable',1);
    if($tds>0) $this->line($jvId,'1230',$tds,'D');
    $this->line($jvId,'1100',$net+$tds,'C','customer',$inv['client_id']);

    $this->db->transComplete();
    return $this->db->transStatus();
  }

  public function postVendorBill(array $bill){
    $this->db->transStart();
    $this->db->table('fin_journal')->insert([
      'jv_no'=>'BILL-'.$bill['bill_no'],'jv_date'=>$bill['bill_date'],'narration'=>'Vendor Bill','ref_table'=>'fin_vendor_bill','ref_id'=>$bill['id']
    ]); $jvId = $this->db->insertID();

    $this->line($jvId,'5000',(float)$bill['taxable_value'],'D');
    if((float)$bill['cgst']>0 || (float)$bill['sgst']>0){ $this->line($jvId,'1200',(float)$bill['cgst'],'D'); $this->line($jvId,'1210',(float)$bill['sgst'],'D'); }
    if((float)$bill['igst']>0){ $this->line($jvId,'1220',(float)$bill['igst'],'D'); }
    $this->line($jvId,'2000',(float)$bill['grand_total'],'C','vendor',$bill['vendor_id']);

    $this->db->transComplete();
    return $this->db->transStatus();
  }

  public function postVendorPayment(array $pay){
    $this->db->transStart();
    $this->db->table('fin_journal')->insert([
      'jv_no'=>'VPMT-'.($pay['ref'] ?? 'AUTO'),'jv_date'=>$pay['date'],'narration'=>'Vendor Payment','ref_table'=>'fin_vendor_payment','ref_id'=>$pay['id'] ?? null
    ]); $jvId = $this->db->insertID();

    $gross = (float)$pay['gross']; $net=(float)$pay['net']; $tds=(float)($pay['tds']??0);
    $this->line($jvId,'2000',$gross,'D','vendor',$pay['vendor_id']);
    if($net>0) $this->line($jvId,'1000',$net,'C');
    if($tds>0) $this->line($jvId,'2130',$tds,'C');

    $this->db->transComplete();
    return $this->db->transStatus();
  }

  private function ensureAccount(string $code,string $name,int $type){
    $row = $this->db->table('fin_account')->where('code',$code)->get()->getRow();
    if(!$row){ $this->db->table('fin_account')->insert(['code'=>$code,'name'=>$name,'type_id'=>$type]); }
  }

  private function line(int $jvId,string $accountCode,float $amount,string $side,string $partyType=null,$partyId=null){
    $acc = $this->db->table('fin_account')->where('code',$accountCode)->get()->getRowArray();
    if(!$acc) throw new \RuntimeException('Account not found: '.$accountCode);
    $data = ['journal_id'=>$jvId,'account_id'=>$acc['id'],'debit'=>0,'credit'=>0,'party_type'=>$partyType,'party_id'=>$partyId];
    if($side==='D') $data['debit']=$amount; else $data['credit']=$amount;
    $this->db->table('fin_journal_line')->insert($data);
  }
}
