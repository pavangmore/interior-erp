<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class Reports extends Controller {
  public function trialBalance(){
    $db=Database::connect(); $rows=$db->query('SELECT * FROM vw_trial_balance')->getResultArray(); return view('rep_trial_balance',['rows'=>$rows]);
  }
  public function profitLoss(){
    $db=Database::connect(); $rows=$db->query('SELECT * FROM vw_profit_loss')->getResultArray(); return view('rep_profit_loss',['rows'=>$rows]);
  }
  public function balanceSheet(){
    $db=Database::connect(); $rows=$db->query('SELECT * FROM vw_balance_sheet')->getResultArray(); return view('rep_balance_sheet',['rows'=>$rows]);
  }
  public function gstr1(){
    $db=Database::connect(); $rows=$db->query('SELECT * FROM vw_gstr1_b2b')->getResultArray(); return view('rep_gstr1',['rows'=>$rows]);
  }
  public function gstr3b(){
    $db=Database::connect(); $rows=$db->query('SELECT * FROM vw_gstr3b_summary')->getResultArray(); return view('rep_gstr3b',['rows'=>$rows]);
  }
}
