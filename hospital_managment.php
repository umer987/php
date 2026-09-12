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

// ============================
// 2. DOCTOR CLASS (extends Person)
// ============================
class Doctor extends Person {
    private $specialization;
    private $fee;
    
    public function __construct($id, $name, $age, $specialization, $fee) {
        parent::__construct($id, $name, $age);
        $this->specialization = $specialization;
        $this->fee = $fee;
    }
    
    public function getSpecialization() {
        return $this->specialization;
    }
    
    public function getFee() {
        return $this->fee;
    }
    
    public function getInfo() {
        return parent::getInfo() . 
               " | Doctor ({$this->specialization}) | Fee: \${$this->fee}";
    }
}
?>