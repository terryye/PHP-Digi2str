<?php
/**
 * Using 0-9,a-Z,A-Z (62 charactors) to represent long numbers. 
 * The length can always be cut to nearly half of the original one and the encoded string is url and user frinedly.
 */
class digi2str {
	/**
	 * the charactors dictionary used for encode the number
	 */
	private static $table = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	
	/**
	 * check if the number giving is valid.
	 */
	private static function _validNum($number){
		$trim_number = bcadd($number,0);
		if($trim_number !== $number){
			throw new Exception("input contains invalid chars!");
		}
	}
	
	
	/**
	 * encode the giving number
	 */
	static function encode($number){
		self::_validNum($number);
		
		$is_nagative = bccomp($number , 0) < 0;
		if($is_nagative){
			$number = bcsub(0,$number);
		}
		
		$len = strlen(self::$table);		
		$chars = array();
		while(bccomp($number , 0) == 1 ){
			$left = bcmod($number, $len);
			$number = bcdiv($number,$len);
			$chars[]= self::$table[$left];
		}
		if($is_nagative){
			$chars[] = '-';
		}
		$res = array_reverse($chars);
		return join($res,"");
	}
	
	/**
	 * decode the giving string
	 */
	static function decode($str){
		$is_nagative = ($str[0] === "-");
		if($is_nagative){
			$str = substr($str,1);
		}
		$len = strlen(self::$table);
		$strlen = strlen($str);
		$number = 0;
		for($i=0; $i<$strlen; $i++){
			$chr = $str[$i];
			$val = strpos(self::$table, $chr);
			if($val === false){
				throw new Exception("input contains invalid chars!");
			}
			$number = bcadd(bcmul($number,$len),$val);
		}
		if($is_nagative){
			$number = bcsub(0,$number);
		}
		return $number;
	}
	
	/**
	 * encode the Chinese ID card's number (sometimes an X is included in the number)
	 */
	static function encodeIDCard($idCard){
		$idCard = trim($idCard);
		if(strtoupper(substr($idCard,-1)) === 'X'){
			$numberStr = substr($idCard,0,-1);
			$hasX = 1;
		}else{
			$numberStr = $idCard;
			$hasX = 0;
		}
		if($numberStr[0] === '-' ){
			throw new Exception("input contains invalid chars!");
		}
		if($hasX){
			$numberStr = "-".$numberStr;
		}
		
		return self::encode($numberStr);
	}

	/**
	 * deencode the Chinese ID card's string
	 */	
	static function decodeIDCard($idCard){
		$card_str = self::decode($idCard);
		//值为负标明身份证号末尾为X
		if($card_str[0] === '-'){
			$card_str = substr($card_str, 1) . "X";
		}
		
		return $card_str;
	}
}
