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


// ============================
// 4. APPOINTMENT CLASS
// ============================
class Appointment {
    private $patient;
    private $doctor;
    private $date;
    private $time;
    
    public function __construct(Patient $patient, Doctor $doctor, $date, $time) {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->date = $date;
        $this->time = $time;
    }
    
    public function getDetails() {
        return "📅 {$this->date} at {$this->time} — " .
               "Patient: {$this->patient->getName()} with " .
               "Dr. {$this->doctor->getName()} " .
               "({$this->doctor->getSpecialization()})";
    }
}
// ============================
// 5. HOSPITAL CLASS (Manages Everything)
// ============================
class Hospital {
    private $name;
    private $doctors = [];
    private $patients = [];
    private $appointments = [];
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    public function addDoctor(Doctor $doctor) {
        $this->doctors[] = $doctor;
        echo "👨‍⚕️ Doctor added: {$doctor->getName()}<br>";
    }
    
    public function addPatient(Patient $patient) {
        $this->patients[] = $patient;
        echo "🧑 Patient added: {$patient->getName()}<br>";
    }
    
    public function bookAppointment(Patient $patient, Doctor $doctor, $date, $time) {
        $apt = new Appointment($patient, $doctor, $date, $time);
        $this->appointments[] = $apt;
        $patient->assignDoctor($doctor);
        echo "📌 Appointment booked!<br>";
    }
    
    public function showDoctors() {
        echo "<h3>👨‍⚕️ Doctors List</h3>";
        foreach ($this->doctors as $d) {
            echo $d->getInfo() . "<br>";
        }
    }
    
    public function showPatients() {
        echo "<h3>🧑 Patients List</h3>";
        foreach ($this->patients as $p) {
            echo $p->getInfo() . "<br>";
        }
    }
    
    public function showAppointments() {
        echo "<h3>📅 Appointments</h3>";
        if (empty($this->appointments)) {
            echo "No appointments yet.<br>";
            return;
        }
        foreach ($this->appointments as $a) {
            echo $a->getDetails() . "<br>";
        }
    }
    
    public function stats() {
        return [
            'doctors' => count($this->doctors),
            'patients' => count($this->patients),
            'appointments' => count($this->appointments)
        ];
    }
}
// ============================
// 6. USING THE SYSTEM
// ============================

$hospital = new Hospital("City Care Hospital");

echo "<h2>🏥 {$hospital->stats()['doctors']} Welcome to City Care Hospital</h2><hr>";

// ---- Add Doctors ----
$doc1 = new Doctor(1, "Ahmed Khan", 45, "Cardiologist", 150);
$doc2 = new Doctor(2, "Sara Ali", 38, "Dermatologist", 100);
$doc3 = new Doctor(3, "Bilal Raza", 50, "Neurologist", 200);

$hospital->addDoctor($doc1);
$hospital->addDoctor($doc2);
$hospital->addDoctor($doc3);
?>