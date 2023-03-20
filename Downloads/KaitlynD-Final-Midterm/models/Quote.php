<?php
    class Quote {
        //DB stuff
        private $conn;
        private $table = 'quotes';

        //Quote Properties
        public $id;
        public $quote;
        public $category;
        public $author;
        public $author_id;
        public $category_id;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get ALL Quotes
        public function read() {
            //Create query
            $query = "SELECT 
            a.author as author,
            c.category as category,
            q.quote, 
            q.id
            FROM 
                {$this->table} q
            LEFT JOIN 
                authors a ON author_id = a.id
            LEFT JOIN
                categories c ON category_id = c.id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();
        return $stmt;
            
        }

        //Get One Quote
        public function read_single() {
            
            if(isset($_GET['id'])){
             //Create query
             $query = "SELECT 
             a.author as author,
             c.category as category,
             q.quote,
             q.id
             FROM 
                  {$this->table} q
             LEFT JOIN 
                 authors a ON author_id = a.id
             LEFT JOIN
                 categories c ON category_id = c.id
             WHERE
             q.id = :id";

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Bind data
            $stmt->bindParam(':id', $this->id);

            //Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($row) {
                $this->quote = $row['quote'];
                $this->author = $row['author'];
                $this->category = $row['category'];

                return $row;
                
            } else{
                echo json_encode(array('message' => 'No Quotes Found'));
                exit();
            }

            }else if (isset($_GET['author_id']) && isset($_GET['category_id'])){
                //Create query
                $query = "SELECT 
                a.author as author,
                c.category as category,
                q.quote,
                q.id
                FROM 
                     {$this->table} q
                LEFT JOIN 
                    authors a ON author_id = a.id
                LEFT JOIN
                    categories c ON category_id = c.id
                WHERE
                q.author_id = :author_id AND q.category_id = :category_id";

                $this->author_id = $_GET['author_id'];
                $this->category_id = $_GET['category_id'];

                //Prepare statement
                $stmt = $this->conn->prepare($query);

                //Bind data
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':category_id', $this->category_id);

                //Execute query
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if($stmt)  {
                    return $stmt;
                } else{
                    echo json_encode(array('message' => 'No Quotes Found'));
                    exit();
                }
            }else if (isset($_GET['author_id'])){
                //Create query
                $query = "SELECT 
                a.author as author,
                c.category as category,
                q.quote,
                q.id
                FROM 
                     {$this->table} q
                LEFT JOIN 
                    authors a ON author_id = a.id
                LEFT JOIN
                    categories c ON category_id = c.id
                WHERE
                q.author_id = :author_id";

                //Prepare statement
                $stmt = $this->conn->prepare($query);

                //Bind ID
                $stmt->bindParam(':author_id', $this->author_id);

                //Execute query
                $stmt->execute();

                if($stmt)  {
                    return $stmt;
                    
                } else{
                    echo json_encode(array('message' => 'No Quotes Found'));
                    exit();
                }
            }
            else if (isset($_GET['category_id'])){
                //Create query
                $query = "SELECT 
                a.author as author,
                c.category as category,
                q.quote,
                q.id
                FROM 
                     {$this->table} q
                LEFT JOIN 
                    authors a ON author_id = a.id
                LEFT JOIN
                    categories c ON category_id = c.id
                WHERE
                q.category_id = :category_id";
               }

                //Prepare statement
                $stmt = $this->conn->prepare($query);

                //Bind data
                $stmt->bindParam(':category_id', $this->category_id);

                //Execute query
                $stmt->execute();

                if($stmt){
                    return $stmt;
                } else{
                    echo json_encode(array('message' => 'No Quotes Found'));
                    exit();
                }
        }

        //Create Quote
        public function create() {
            //create query
            $query = "INSERT INTO {$this->table} (quote, author_id, category_id)
            VALUES (:quote, :author_id, :category_id)";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            //Bind data 
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            //execute query
            if ($stmt->execute()) {
                return true;
            }else{           
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
            if (!empty($categories->category)){
                  $cat_arr = array(
                      'id'=> $categories->id,
                      'category'=>$categories->category
                  );
                  echo json_encode($cat_arr);
            }else{
                  echo json_encode(array('message'=> 'category_id Not Found'));
            }
            if (!empty($authors->author)){
                  $auth_arr = array(
                      'id' => $author->id,
                      'author' => $author->author
                  );
                  echo json_encode($auth_arr); 
            }else{
                  echo json_encode(array('message'=> 'author_id Not Found'));
            }
        }


        //Update Quote
        public function update() {
            //Update query
            $query = "UPDATE {$this->table} 
            SET quote = :quote,
            author_id = :author_id,
            category_id = :category_id
            WHERE id = :id";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));


            //Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            //execute query
            if ($stmt->execute()) {
                return true;
            }else{           
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
        }
      
        //Delete Quote
        public function delete() {
            //Create delete query
            $query = "DELETE FROM {$this->table} WHERE id = :id";

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':id', $this->id);

            if ($stmt->execute()) {
                return true;
            }else{           
                printf("Error: %s. \n", $stmt->error);
                echo json_encode(array('message'=>'No Quotes Found'));
                return false;
              
            }
     
        }
    }


?>