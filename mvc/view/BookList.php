<html>
   <head>
      <title>View Book List</title>
      <!-- Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   </head>
   <body>
      <div class="container col-md-6 text-center">
      <table class="table table-secondary mt-3">
         <tr>
            <th>Book Title</th>
            <th>Book Author</th>
         </tr>
         <?php 
            foreach($books as $book) { 
         ?>
            <tr>
               <td>
                  <a href="index.php?title=<?= $book->title ?>">
                     <?= $book->title ?>
                  </a>       
               </td>
               <td> <?= $book->author ?></td>
            </tr>
         <?php
          }
         ?>     
      </table>
      </div>
   </body>
</html>