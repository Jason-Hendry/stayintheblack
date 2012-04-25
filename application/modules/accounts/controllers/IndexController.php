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

      $weeks = array();
      for($i=0;$i<$totalWeeks;$i++) {
        $start = date('U',strtotime("+$i weeks",$startTime));
        $end = date('U',strtotime("+7 days",$start))-1; // Last second of Week
        $days = array();
        for($j=0;$j<7;$j++) {
          $day = array(
                       'dayStart'=>date('U',strtotime("+$j days",$start)),
                       'dayEnd'=>date('U',strtotime("+$j days +24 hours",$start)),
                       );
          $day['class'] = $now >= $day['dayStart'] && $now < $day['dayEnd'] ? 'today' : '';
          $day['name'] = substr(date('D',$day['dayStart']),0,1);
          $days[] = $day;
        }
        $weeks[] = array(
                         'start'=>$start,
                         'end'=>$end,
                         'days'=>$days
                         );
      }
      return $weeks;
    }


}

