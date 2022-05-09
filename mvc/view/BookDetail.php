<html>
   <head>
      <title>View Book Detail</title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   </head>
   <body>
      <div class="container col-md-8 text-center">
         <div class="row mt-3">
            <div class="col">
               <img src="<?= $book->image ?>" width="200" height="200">   
            </div>
            <div class="col">
               <h2>Title: <?= $book->title ?></h2>
               <h2>Author: <?= $book->author ?></h2>
               <h2>Price: <?= $book->price ?> $ </h2>
            </div>
         </div>
      </div>
   </body>
</html>