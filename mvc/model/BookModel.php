<?php
// tạo kết nối đến file Book.php
require_once "Book.php";

class BookModel {
   //tạo function hiển thị toàn bộ book list
   public function viewBookList() {
      //tạo array giả lập là dữ liệu của bảng trong database
      //index của element trong array chính là title của book 
      $bookList = array (
         "Symfony" => new Book("Symfony","David",99.99,
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXOOicUH43q_tGQ_y1YqSadeik87JALKTV5DwCs5Klk9Q8GxOCqr6kqB7heYU_qTDsNX0&usqp=CAU"),
         "ReactJS Practice" => new Book("ReactJS Practice", "Michael",88.66,
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSDMwCOZC-SoLrBtcshQHOq4yDTtQaCI_OiEA&usqp=CAU"),
         "Spring Boot Tutorial" => new Book("Spring Boot Tutorial", "John", 34.56,
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKRD8qqR7KSOjfuxGVF8q3mSC9oJnwyy74eg&usqp=CAU")
      );
      return $bookList;
   }

   //tạo function hiển thị book detail theo title
   public function viewBookByTitle ($title) {
      $books = $this->viewBookList();
      return $books[$title];
   }
}
?>