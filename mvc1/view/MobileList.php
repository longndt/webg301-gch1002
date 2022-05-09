<html>
   <head> 
      <title>View Mobile List</title>
      <!-- Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   </head>
   <body>
      <div class="container col-md-4 text-center">
      <table class="table table-primary mt-3">
         <tr>
            <th>Mobile Name</th>
            <th>Mobile Image</th>
         </tr>
         <?php 
            $i=0; //first index in array
            foreach ($mobiles as $mobile) { 
         ?>
            <tr>
               <td> <?= $mobile->name ?></td>
               <td>   
                  <a href="index.php?id=<?= $i ?>">
                     <img src="<?= $mobile->image ?>" width="100" height="100">
                  </a>       
               </td>
            </tr>
         <?php
          $i++; //increase index after each loop
          }
         ?>     
      </table>
      </div>
   </body>
</html>