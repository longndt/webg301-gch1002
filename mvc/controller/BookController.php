<?php
//liên kết đến BookModel
require_once "model/BookModel.php";

class BookController {
   public $model;
   public function __construct() 
   {
      $this->model = new BookModel;
   }

   //tạo function để handle request từ client (browser)
   public function handle() {
      //Trường hợp 1: Nếu người dùng không click vào title của book
      //thì hiển thị toàn bộ book list (default case)
      if (!(isset($_GET['title']))) {
         //tạo biến để lấy dữ liệu từ model và đẩy sang view
         $books = $this->model->viewBookList();
         //render view tương ứng để show ra book list
         require_once "view/BookList.php";
      }

      //Trường hợp 2: Nếu người dùng click vào title của book
      //thì hiển thị thông tin chi tiết của book đấy
      else {
         //tạo biến để lấy dữ liệu từ model và đẩy sang view
         $book = $this->model->viewBookByTitle($_GET['title']);
         //render view tương ứng để show ra book detail
         require_once "view/BookDetail.php";
      }
   }
}
?>