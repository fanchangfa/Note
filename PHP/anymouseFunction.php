<?php
class anyMouseTest{
	const IPHONE6_PRICE = 5500;
	const XIAOMI4_PRICE = 1999;
	const HONERX_PRICE = 799;

	private $_productSort;
	private $_products;
	
	public function __construct(){
		$this->_productSort = array('iphone6','xiaomi4','honerx');
		$this->_products = array();
	}

	public function addProduct($product , $sum){
		if(in_array($product , $this->_productSort) && is_int($sum)){
			$this->_products[$product] = $sum;
		}
	}

	public function getCount($tax){
		$count = 0;

		$callback = function($sum , $product) use ($tax , &$count){
			$price = constant(__CLASS__.'::'.strtoupper($product).'_PRICE');
			$curPrice = $price* $sum * $tax;
			$count += $curPrice;
		};

		array_walk($this->_products, $callback);
		return $count;
	}
}

$oanyMouse = new anyMouseTest;

$oanyMouse->addProduct('iphone6',1);
$oanyMouse->addProduct('honerx',2);
echo $oanyMouse->getCount(1);
