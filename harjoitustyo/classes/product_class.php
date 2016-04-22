<?php 
class Product {
	private $id;
	private $name;
	private $price;
	private $availability;
	private $description;
	function __construct($id, $name,$price, $availability, $description){
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		$this->availability = $availability;
		$this->description = $description;
	}
	function getName(){
		return $this->name;
	}
	function getId(){
		return $this->id;
	}
	function getPrice(){
		return $this->price;
	}
	function getAvailability(){
		return $this->availability;
	}
	function getDescription(){
		return $this->description;
	}
}
?>