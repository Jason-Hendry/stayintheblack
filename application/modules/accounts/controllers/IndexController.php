<?php

class Accounts_IndexController extends Zend_Controller_Action
{

    public function init()
    {
      if(!Zend_Auth::getInstance()->hasIdentity()) {
          $this->_helper->FlashMessenger('Use must be logged into see your accounts');
          $this->_redirect('auth/login');
      }
        /* Initialize action controller here */
    }

    public function indexAction()
    {
      // TODO: Integrate with user selected options
      $userOptions = $this->getInvokeArg('bootstrap')->getOption('defaultUserOptions');

      $bankAccounts = new Accounts_Model_BankAccountMapper();
      $this->view->bankAccounts = $bankAccounts->fetchAll();

      $creditCardAccounts = new Accounts_Model_CreditCardAccountMapper();
      $this->view->creditCardAccounts = $creditCardAccounts->fetchAll();

      $loanAccounts = new Accounts_Model_LoanAccountMapper();
      $this->view->loanAccounts = $loanAccounts->fetchAll();

      $this->view->weeks = $this->generateWeeksArray($userOptions);
    }

    protected function generateWeeksArray($userOptions) {
      $now = date('U');
      
      $dayToNum = array_flip(array('sun','mon','tue','thu','fri','sat'));
      $startOfWeek = $dayToNum[strtolower(substr($userOptions['startOfWeek'],0,3))];
      $dow = date('w',$now);

      $daysSinceWeekStart = (($dow + 7 - $startOfWeek) % 7);
      $weekStart = strtotime(date('Y-m-d',strtotime("-$daysSinceWeekStart days", $now)));

      $startTime = date('U', strtotime("-{$userOptions['pastWeeks']} weeks", $weekStart));
      $totalWeeks = $userOptions['pastWeeks'] + $userOptions['futureWeeks'] + 1;

      $paymentMapper = new Accounts_Model_PaymentMapper();
      $payments = $paymentMapper->fetchRange($startTime,strtotime("+$totalWeeks weeks",$startTime));
      //      $payments = $paymentMapper->fetchAll();
      //      Zend_Debug::dump($payments); exit;

      $weeks = array();
      for($i=0;$i<$totalWeeks;$i++) {
        $start = date('U',strtotime("+$i weeks",$startTime));
        $end = date('U',strtotime("+7 days",$start))-1; // Last second of Week
        $weekPayments = array();
        $totals = array();
        foreach($payments as $j=>$p) {
          if($p->getPaymentDate()->getTimestamp() > $start && $p->getPaymentDate()->getTimestamp() < $end) {
            $weekPayments[] = $p;
            if(!isset($totals[$p->idAccount]))
              $totals[$p->idAccount] = $p->amount;
            else
              $totals[$p->idAccount] += $p->amount;
            unset($payments[$j]); // Reduce next loop size
          }
        }
        $weeks[] = array(
                         'start'=>$start,
                         'end'=>$end,
                         'payments'=>$weekPayments,
                         'totals'=>$totals,
                         );
      }
      return $weeks;
    }

    public function addpaymentAction() {
      $this->view->paymentForm = new Accounts_Form_Payment();
      if($this->getRequest()->isPost()) {
        if($this->view->paymentForm->isValid($this->getRequest()->getPost())) {
          $mapper = new Accounts_Model_PaymentMapper();
          $mapper->save(new Accounts_Model_Payment($this->view->paymentForm->getValues()));
          return $this->_helper->redirector('index');
        }
      }
      $this->view->paymentForm->setAction($this->view->url());
    }
}
