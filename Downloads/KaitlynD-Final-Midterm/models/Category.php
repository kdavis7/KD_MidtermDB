<?php
  
    class Category {
        //DB stuff
        private $conn;
        private $table = 'categories';

        //Category Properties
        public $id;
        public $category;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get Categories
        public function read() {
        //Create Query
        $query = "SELECT 
            id, category
            FROM 
                {$this->table}
            ORDER BY id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();
        
        return $stmt;
            
        }

        //Get single Category
        public function read_single() {
             //Create query
             $query = "SELECT 
             category
             FROM 
                {$this->table}
             WHERE
             id = ?";

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(1, $this->id); 
            
            //Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set properties
            if($row)
            {
              
              $this->category = $row['category'];
             
            }
            
        
        }

        //Create Category
        public function create() {
            //create query
            $query = "INSERT INTO {$this->table} (category)
            VALUES (:category)";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            //Bind data 
            $stmt->bindParam(':category', $this->category);

            //execute query
            if ($stmt->execute()) {
                return true;
            }else{           
            printf("Error: %s. \n", $stmt->error);

            return false;
            }
        }

        //Update Category
        public function update() {
            //Update query
            $query = "UPDATE {$this->table} 
            SET category = :category
            WHERE id = :id";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            //Bind data 
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':category', $this->category);

            //Execute query
            if ($stmt->execute()) 
            {
                return true;
            }else{           
            printf("Error: %s. \n", $stmt->error);
            return false;
            }
        }

        //Delete Category
        public function delete() {
            //Create delete query
            $query = "DELETE FROM {$this->table} WHERE id = :id";

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':id', $this->id);

            //execute query
            if ($stmt->execute()) 
            {
                return true;
            }else{           
            printf("Error: %s. \n", $stmt->error);

            return false;
            }

        }
    }


?>