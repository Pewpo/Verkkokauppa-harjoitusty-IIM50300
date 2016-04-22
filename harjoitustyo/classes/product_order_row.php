<?php 
class ProductOrderRow {
	private $asd;
	private $arr;
	function __construct(){
		$this->arr = array();
	}
	function AddNewRow($object){
		$arr[] = $object;
	}
	function getArray(){
		return $this->arr;
	}
	function setTest($asd){
		$this->asd = $asd;

	}
	function getTest(){
		return $this->asd;
	}
}
?>