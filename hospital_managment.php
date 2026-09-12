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

// ============================
// 3. PATIENT CLASS (extends Person)
// ============================
class Patient extends Person {
    private $disease;
    private $assignedDoctor = null;
    
    public function __construct($id, $name, $age, $disease) {
        parent::__construct($id, $name, $age);
        $this->disease = $disease;
    }
    
    public function getDisease() {
        return $this->disease;
    }
    
    public function assignDoctor(Doctor $doctor) {
        $this->assignedDoctor = $doctor;
        echo "✅ Patient '{$this->name}' assigned to Dr. {$doctor->getName()}<br>";
    }
    
    public function getAssignedDoctor() {
        return $this->assignedDoctor;
    }
    
    public function getInfo() {
        $doc = $this->assignedDoctor 
             ? $this->assignedDoctor->getName() 
             : "Not assigned";
        return parent::getInfo() . 
               " | Patient ({$this->disease}) | Doctor: {$doc}";
    }
}

?>