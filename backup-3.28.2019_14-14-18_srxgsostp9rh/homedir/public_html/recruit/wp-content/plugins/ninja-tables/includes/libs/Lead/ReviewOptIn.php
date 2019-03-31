<?php
namespace WPManageNinja\Lead;

class ReviewOptIn 
{
	private $options;
	private $dismissTime = 604800; // 7 Days
	
	public function __construct($optionArray) {
		$this->options = $optionArray;
	}
	
	/**
	 * Check If User already consent. If consented then don't show
	 * Or If user dismissed then check if $this->dismissTime is over.
	 * If within the time then don't show 
	 * Otherwise we can show this message
	 * @return bool
	 */
	public function noticeable()
	{
		$optStatus = $this->status();
		if( $optStatus == 'yes') {
			return false;
		}
		// check if user dismissed
		$dismissTime = $this->getValue('review_optin_dismiss');
		if( $dismissTime && ( time() - intval($dismissTime) < $this->dismissTime) ) {
			return false;
		}
		return true;
	}
	
	public function status()
	{
		return $this->getValue('review_optin_status');
	}
	
	private function getValue($key) {
		if (isset($this->options[$key])) {
			return $this->options[$key];
		}
		return false;
	}
}