<?php
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die('Could not connect to MySQL DB ') . mysqli_error();
$db = mysqli_select_db($link, DB_NAME); 
$tbl_name="flowers";
global $link;
class validation {

    public $item_name;
    public $price;
    public $quantity;
    public $img;
    public $tmp_name;
    
    function __construct($link) {
        $this->link=$link;
    }
    
    public function nameValidation() {
        $this->item_name=$_POST['item_name'];
        $this->item_name=  strip_tags($this->item_name);
        $this->quantity= mysqli_real_escape_string($this->link,$this->item_name);
        if(strlen($this->item_name)>50){
            die("Item name cannot be more then 50 characters.");
        }else{
            return $this->item_name;
        }
    }
    
        public function priceValidation() {

            $this->price=$_POST['price'];
            $this->price=  strip_tags($this->price);
            $this->quantity= mysqli_real_escape_string($this->link,$this->price);
            if(!$this->price){
                die("Please fill in all the fields.");
            }
            if(!is_numeric($this->price)){
                die("Price must contain only numbers.");
            }else{
                return $this->price;
            }
        }
        public function quantityValidation() {
            $this->quantity=$_POST['quantity'];
            $this->quantity=  strip_tags($this->quantity);
            $this->quantity= mysqli_real_escape_string($this->link,$this->quantity);
            if(!is_numeric($this->quantity)){
                die("Quantity must contain only numbers.");
            }else{
                return $this->quantity;
            }
        }
        public function imgValidation() {
            $max_file_size=4097152;
            $path="../images/";
            $valid_formats = array("image/jpeg","image/jpg", "image/png", "image/gif", "image/zip", "image/bmp");
            $this->img=$_FILES['img']['tmp_name'];
            $file_name=$_FILES['img']['name'];
            if($_FILES['img']['name']){
                $img_info=  getimagesize($this->img);
                if(!in_array($img_info['mime'], $valid_formats)){
                    die("This file type isn't supported.");
                }
                if(filesize($this->img)>$max_file_size){
                    die("This file is too big.");
                }

                //all good, move the file to the folder
                $file_name= strip_tags($file_name);
                $file_name= mysqli_real_escape_string($this->link,$file_name);
                $target_path=$path.$file_name;
                if(move_uploaded_file($this->img, $target_path)){
                    $new_image=$path.$file_name;
                    echo basename($new_image) . " was uploaded.";
                    return basename($new_image);
                }else{
                    die("cant move");
                }
            }    
            echo 'No image was uploaded.';
        }

}
?>