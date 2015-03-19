<?php
/*
定义中介对象基类，提取相同的方法
并定义需要实现的方法
*/
abstract class colleague{
	//各类中相同的变量抽象
	public $_title;
	public $_description;
	public $_author;

	public $_mediator = null;

	//介绍认识中介类
	public function setMediator($mediaInstance){
		if(!is_null($mediaInstance)){
			$this->_mediator = $mediaInstance;
		}
	}

	//中介方法
	public abstract function setAuthor($author);
}

/*
中介对象A
*/
class colleagueA extends colleague{
	private $_varA;	//区分其他类独有的变量
	
	public function __construct($title , $description ,$varA='test'){
		$this->_title = $title;
		$this->_description = $description;
		$this->_varA = $varA;
	}
	

	public function setAuthor($author){
		$this->_author = $author;
		print 'change colleagueA author' . PHP_EOL;

		//这里可以执行colleagueA中的其他方法
		$this->methodA();

		//执行中介方法
		if(!is_null($this->_mediator)){
			$this->_mediator->execute($this);
		}
	}

	public function methodA(){
		echo $this->_author , ' from colleagueA ' , PHP_EOL;
	}
}

/*
中介对象B
*/
class colleagueB extends colleague{
	private $_varB;	//区分其他类独有的变量
	
	public function __construct($title , $description){
		$this->_title = $title;
		$this->_description = $description;
	}
	
	public function setAuthor($author){
		$this->_author = $author;
		print 'change colleagueB author' . PHP_EOL;

		//这里可以执行colleagueB中的其他方法
		$this->functionB();

		//执行中介方法
		if(!is_null($this->_mediator)){
			$this->_mediator->execute($this);
		}
	}

	//区分其他类独有的方法
	public function functionB(){
		echo $this->$author , ' from B' , PHP_EOL;
	}

}
/*
中介类
*/
class Mediator{
	public $mediatorArr = array('colleagueA','colleagueB');

	public function execute($obj){
		$title = $obj->_title;
		$description = $obj->_description;
		$author = $obj->_author;

		if(!empty($this->mediatorArr) && !is_null($obj) ){
			foreach($this->mediatorArr as $mediaObject){
				if($obj instanceof $mediaObject){
					continue;
				}
				$colleague = new $mediaObject($title , $description);
				$colleague->_author = $author;
				var_dump($colleague);
			}
		}
	}
}

$oColleagueA = new colleagueA('testTitle' , 'this is description');
$oMediator = new Mediator;

$oColleagueA->setMediator($oMediator);
$oColleagueA->setAuthor('Frank');
