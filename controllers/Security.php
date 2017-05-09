<?php
namespace Core;


class Security{
	public function __construct(){
		$this->login='/^[\w\.]+$/i';
		$this->password='/^[0-9\w\- \.\/]+$/i';
		$this->email='`^[[:alnum:]]([-_.]?[[:alnum:]])+_?@[[:alnum:]]([-.]?[[:alnum:]])+\.[a-z]{2,4}$`';
		$this->date='/^([0-3][0-9])[\/\-]([0-1][1-9])[\/\-]([1-2][0-9][0-9][0-9])$/i';
		$this->DateFr='/^([0-3][0-9])[\/\-]([0-1][0-9])[\/\-]([0-9][0-9][0-9][0-9])$/i';//XX-XX-XXXX | XX/XX/XXXX
		$this->DateEN='/^([0-9][0-9][0-9][0-9])[\/\-]([0-1][0-9])[\/\-]([0-3][0-9])$/i';//XXXX-XX-XX | XXXX/XX/XX
		$this->datetime='/^([2][0-9][0-9][0-9])[\/|\-]([0-1][1-9])[\/|\-]([0-3][0-9])[\ ]([0-2][0-9]):([0-5][0-9]):([0-5][0-9])$/i';
		$this->time='/^([0-2][0-9]):([0-5][0-9])$/i';
		$this->number='/^[0-9]+$/i';
		$this->Phone='/^[0-9\.\- ]+$/i';
		$this->noSpecialCaracters = '/^[a-zA-Z, 0-9\-\_\.\ \r\n]+$/i';
		$this->onlyLetter = '/^[a-zA-Z]+$/';

	}

	public function check_login($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->login,$this->data)){
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	public function check_pwd($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->password,$this->data)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	public function check_email($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->email,$this->data)){
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	public function check_DateFR($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->DateFr,$this->data)){
				return true;
			}else{
				echo $this->data;
				return false;
			}
		}else{
			return false;
		}	
	}
	public function check_DateEN($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->DateEN,$this->data)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	public function check_dateTime($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->datetime,$this->data)){
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	public function check_time($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->time,$this->data)){
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	public function check_numbers($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->number,$this->data)){
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	public function check_noSpecialCaracters($data){
		$this->data = $data;
                
		if(isset($this->data))
		{
			if(preg_match($this->noSpecialCaracters,$this->data)){
				return true;
			}else{
				
				return false;
			}	
		}else{
			return false;
		}
	}
	public function check_onlyLetter($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->onlyLetter,$this->data)){
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	public function check_phone($data){
		$this->data=$data;
		if(isset($this->data))
		{
			if(preg_match($this->Phone,$this->data)){
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	public function get_safe_text($data){
            $this->data = $data;
            $this->data = strip_tags($this->data);
            $this->data = addslashes($this->data);
            return $this->data;
	}
}
?>