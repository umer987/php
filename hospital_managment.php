<?php
class Person {
    protected $id;
    protected $name;
    protected $age;
    
    public function __construct($id, $name, $age) {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getInfo() {
        return "ID: {$this->id} | Name: {$this->name} | Age: {$this->age}";
    }
}

?>