<?php

class Rain_Form_Decorator_Recurring extends Zend_Form_Decorator_Abstract
{
  public function render($content) {
    $element = $this->getElement();
    if (!$element instanceof Zend_Form_Element) {
      return $content;
    }
    if (null === $element->getView()) {
      return $content;
    }

    $element->getView()->headScript()->appendFile('/js/recurring.js');
    $element->getView()->headLink()->appendStylesheet('/css/recurring.css');

    $checkbox = '<label><input type="checkbox" class="rain-recurring">Is Recurring</label>';
    $select = '<select class="rain-recurring-freq">'.
      '<option value="daily">Daily</option>'.
      '<option value="weekly">Weekly</option>'.
      '<option value="fortnightly">Fortnightly</option>'.
      '<option value="monthly">Monthly</option>'.
      '<option value="quarterly">Quarterly</option>'.
      '<option value="yearly">Yearly</option>'.
      '<option value="every">Every...</option>'.
      '</select>';
 
    $x = '<input class="rain-recurring-x">';
    $duration = '<select class="rain-recurring-duration">'.
      '<option value="days">Days</option>'.
      '<option value="weeks">Weeks</option>'.
      '<option value="months">Months</option>'.
      '<option value="years">Years</option>'.
      '</select>';

    $dow = '<div class="rain-recurring-dow">'.
      'From selected date or :'.
      '<input type="checkbox" class="checkbox rain-recurring-dow-day" value="monday">Mo'.
      '<input type="checkbox" class="checkbox rain-recurring-dow-day" value="tuesday">Tu'.
      '<input type="checkbox" class="checkbox rain-recurring-dow-day" value="wednesday">We'.
      '<input type="checkbox" class="checkbox rain-recurring-dow-day" value="thursday">Th'.
      '<input type="checkbox" class="checkbox rain-recurring-dow-day" value="friday">Fr'.
      '<input type="checkbox" class="checkbox rain-recurring-dow-day" value="Saturday">Sa'.
      '<input type="checkbox" class="checkbox rain-recurring-dow-day" value="sunday">Su'.
      '</div>';

    $dom = '<div class="btn-group rain-recurring-dom">';
    for($i=1;$i<=31;$i++) {
      $dom .= '<label><input type="checkbox" class="checkbox" value="'.$i.'"/>'.$i .'</label>';
    }
    $dom .= '</div>';

    $publicHolidays = '<label class="rain-recurring-public-holidays"><input type="checkbox">Excluding Public Holidays</label>';
    $businessOnly = '<label class="rain-recurring-business"><input type="checkbox">Only on Business Days</label>';

    $else = '<select class="rain-recurring-else">'.
      '<option value="skip">Skip</option>'.
      '<option value="day-before">Day Before</option>'.
      '<option value="day-after">Day After</option>'.
      '</select>';

    $until = '<div class="rain-recurring-until">Until <select>'.
      '<option value="forever">Forever</option>'.
      '<option value="date">Date: </option>'.
      '<option value="count">Times...</option>'.
      '</select>'.
      '<input class="rain-recurring-until-x">'.
      '</div>';

    $output = $checkbox.$select.$x.$duration.$dow.$dom.$publicHolidays.$businessOnly.$else.$until;

    $separator = $this->getSeparator();
    switch ($this->getPlacement()) {
    case (self::PREPEND):
      return $output . $separator . $content;
    case (self::APPEND):
    default:
      return $content . $separator . $output;
    }
    
  }
}