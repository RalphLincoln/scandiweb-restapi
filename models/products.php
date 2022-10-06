<?php
    class Products {
        private $conn;
        private $table = "products";

        //product properties
        public $sc_sku;
        public $sc_name;
        public $sc_price;
        public $sc_attr;

        public function __construct($db) {
            $this->conn = $db;
        }

        //GET ALL PRODUCTS
        public function read() {
            $query = "SELECT * FROM $this->table";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        //CREATE A PRODUCT
        public function create() {
            $query = 'INSERT INTO '.$this->table.' SET sc_sku = :sc_sku, sc_name = :sc_name, sc_price = :sc_price, sc_attr = :sc_attr';

            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':sc_sku', $this->sc_sku);
            $stmt->bindParam(':sc_name', $this->sc_name);
            $stmt->bindParam(':sc_price', $this->sc_price);
            $stmt->bindParam(':sc_attr', $this->sc_attr);

            // Execute query
            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        // DELETE A PRODUCT
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE sc_sku = :sc_sku';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->sc_sku = htmlspecialchars(strip_tags($this->sc_sku));

            // Bind data
            $stmt->bindParam(':sc_sku', $this->sc_sku);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error deleting product: %s.\n", $stmt->error->getMessage());

            return false;
        }
    }
