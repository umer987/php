<?php

// 1. Class with properties and methods
class Book {
    public $title;
    public $author;
    public $price;
    
    // Constructor
    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }
    
    // Method
    public function getInfo() {
        return "Book: {$this->title} by {$this->author} - \${$this->price}";
    }
}

// 2. Inheritance
class EBook extends Book {
    public $fileSize;
    
    public function __construct($title, $author, $price, $fileSize) {
        parent::__construct($title, $author, $price);
        $this->fileSize = $fileSize;
    }
    
    // Method overriding
    public function getInfo() {
        return parent::getInfo() . " [EBook - {$this->fileSize}MB]";
    }
}

// 3. Class with encapsulation
class Library {
    private $books = [];
    
    public function addBook(Book $book) {
        $this->books[] = $book;
        echo "Added: {$book->title}<br>";
    }
    
    public function showAllBooks() {
        echo "<h3>Library Books:</h3>";
        foreach ($this->books as $book) {
            echo $book->getInfo() . "<br>";
        }
    }
    
    public function countBooks() {
        return count($this->books);
    }
}

// ---- Using the classes ----

// Create book objects
$book1 = new Book("PHP Basics", "John Doe", 25);
$book2 = new Book("Learn OOP", "Jane Smith", 30);
$ebook1 = new EBook("Advanced PHP", "Bob Wilson", 15, 5);

// Create library and add books
$library = new Library();
$library->addBook($book1);
$library->addBook($book2);
$library->addBook($ebook1);

// Display results
$library->showAllBooks();
echo "<br>Total books: " . $library->countBooks();

?>