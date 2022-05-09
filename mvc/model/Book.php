<?php  
class Book {
   //khai báo thuộc tính (attribute)
   public $title;
   public $author;
   public $price;
   public $image;

   //khai báo hàm tạo (constructor)
   public function __construct($t, $a, $p, $i) {
      $this->title = $t;
      $this->author = $a;
      $this->price = $p;
      $this->image = $i;
   }  
}
?>