<?php
//liên kết đến MobileModel
require_once "model/MobileModel.php";

class MobileController {
   public $model;
   public function __construct() 
   {
      $this->model = new MobileModel;
   }

   //tạo function để handle request từ client (browser)
   public function handle() {
      if (!(isset($_GET['id']))) {
         //tạo biến để lấy dữ liệu từ model và đẩy sang view
         $mobiles = $this->model->viewAllMobile();
         //render view tương ứng để show ra mobile list
         require_once "view/MobileList.php";
      }

      else {
         //tạo biến để lấy dữ liệu từ model và đẩy sang view
         $mobile = $this->model->viewMobileDetail($_GET['id']);
         //render view tương ứng để show ra mobile detail
         require_once "view/MobileDetail.php";
      }
   }
}
?>