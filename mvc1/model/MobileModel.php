<?php 
require_once "Mobile.php";

class MobileModel
{
    public function viewAllMobile()
    {
        $mobiles = array(
         new Mobile(
             "iPhone 13 Pro Max",
             1200,
             "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPUe3XdcmRuaZ_RB7omRuW8I2oOPSI7uVTfg&usqp=CAU"
         ),
         new Mobile(
             "Galaxy S22 Ultra",
             1100,
             "https://images.fpt.shop/unsafe/fit-in/585x390/filters:quality(90):fill(white)/fptshop.com.vn/Uploads/Originals/2022/2/9/637800453119346022_samsung-galaxy-s22-ultra-den-4.jpg"
         )
      );
        return $mobiles;
    }

    public function viewMobileDetail($id)
    {
        $mobiles = $this->viewAllMobile();
        return $mobiles[$id];
    }
}
?>