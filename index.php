<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://v4-alpha.getbootstrap.com/favicon.ico">

    <title>Fomocam -> Mo</title>

    <!-- Bootstrap core CSS -->
    <link href="indexb_files/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="indexb_files/album.css" rel="stylesheet">
  </head>

<?php
// How many images should be shown on each apge?
$limit = 15;
 
// How many adjacent pages should be shown on each side?
$adjacents = 2;
 
// This is the name of file ex. I saved this file as index.php.
$targetpage = 'index.php';
 
// All iamges holder, defalut value is empty
$allImages = [];
 
// Target images directory
$image_dir = 'mo/';

// Iterator over the directory
$dir = new DirectoryIterator(dirname(__FILE__).DIRECTORY_SEPARATOR.$image_dir);

// Iterator over the files and push jpg and png images to $allImages array.
foreach ($dir as $fileinfo) {
    if ($fileinfo->isFile() && in_array($fileinfo->getExtension(),array('jpg','png'))) {
      array_push($allImages,$image_dir.$fileinfo->getBasename());
    }
  }

rsort($allImages);

$newestImage = array_shift($allImages);

// total number of images
$total_pages = count($allImages);
    
//how many items to show per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
//  if no page var is given, set start to 0
$start = $page ?  (($page - 1) * $limit) : 0;
 
    
$images = array_slice( $allImages, $start, $limit );;
 
/* Setup page vars for display. */
if ($page == 0) $page = 1;                    //if no page var is given, default to 1.
$prev = $page - 1;                            //previous page is page - 1
$next = $page + 1;                            //next page is page + 1
$lastpage = ceil($total_pages/$limit);        //lastpage is = total pages / items per page, rounded up.
$lpm1 = $lastpage - 1;                        //last page minus 1
   
$pagination = "";
if($lastpage > 1)
{    
  $pagination .= "<nav aria-label='Older images'>\n<ul class='pagination justify-content-center'>";
  //previous button
  if ($page > 1)
    $pagination.= "<li class='page-item'>\n<a class='page-link' tabindex='-1' href=\"$targetpage?page=$prev\">Previous</a>\n</li>\n";
  else
    $pagination.= "<li class='page-item disabled'>\n<a class='page-link' tabindex='1-' href='#'>Previous</a>\n</li>\n";    
 
  //pages    
  if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
  {    
    for ($counter = 1; $counter <= $lastpage; $counter++)
    {
      if ($counter == $page)
        $pagination.= "<li class='page-item active'>\n<a class='page-link' href='#'>$counter<span class='sr-only'>(current)</span></a>\n</li>";
      else
        $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$counter'>$counter</a></li>";                    
    }
  }
  elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
  {
    //close to beginning; only hide later pages
    if($page < 1 + ($adjacents * 2))        
    {
      for ($counter = 1; $counter < 2 + ($adjacents * 2); $counter++)
      {
        if ($counter == $page)
          $pagination.= "<li class='page-item active'>\n<a class='page-link' href='#'>$counter<span class='sr-only'>(current)</span></a>\n</li>";
        else
          $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$counter'>$counter</a></li>";                    
      }
      $pagination.= "<li class='page-item disabled'>\n<a class='page-link' href='#'>...</a>\n</li>\n";
      $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$lpm1'>$lpm1</a></li>";
      $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$lastpage'>$lastpage</a></li>";       
    }
    //in middle; hide some front and some back
    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    {
      $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=1'>1</a></li>";
      $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=2'>2</a></li>";
      $pagination.= "<li class='page-item disabled'>\n<a class='page-link' href='#'>...</a>\n</li>\n"; 
      for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
      {
        if ($counter == $page)
          $pagination.= "<li class='page-item active'>\n<a class='page-link' href='#'>$counter<span class='sr-only'>(current)</span></a>\n</li>";
        else
          $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$counter'>$counter</a></li>";                    
      }
      $pagination.= "<li class='page-item disabled'>\n<a class='page-link' href='#'>...</a>\n</li>\n";
      $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$lpm1'>$lpm1</a></li>";
      $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$lastpage'>$lastpage</a></li>";       
    }
    //close to end; only hide early pages
    else
    {
      $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=1'>1</a></li>";
      $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=2'>2</a></li>";
      $pagination.= "<li class='page-item disabled'>\n<a class='page-link' href='#'>...</a>\n</li>\n";
      for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
      {
        if ($counter == $page)
          $pagination.= "<li class='page-item active'>\n<a class='page-link' href='#'>$counter<span class='sr-only'>(current)</span></a>\n</li>";
        else
          $pagination.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$counter'>$counter</a></li>";                    
      }
    }
  }
 //next button
  if ($page < $counter - 1)
    $pagination.= "<li class='page-item'>\n<a class='page-link' href=\"$targetpage?page=$next\">Next</a>\n</li>\n";
  else
    $pagination.= "<li class='page-item disabled'>\n<a class='page-link' href='#'>Next</a>\n</li>\n";
  $pagination.= "</ul>\n</nav>";        
}
?>

  <body>

    <div class="bg-inverse collapse" id="navbarHeader" aria-expanded="false" style="">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 py-4">
            <h4 class="text-white">About</h4>
            <p class="text-muted">Fomocam, coming to Light Night soon.</p>
          </div>
          <div class="col-sm-4 py-4">
            <h4 class="text-white">Contact</h4>
            <ul class="list-unstyled">
              <li><a href="#" class="text-white">Follow on Twitter</a></li>
              <li><a href="#" class="text-white">Like on Facebook</a></li>
              <li><a href="#" class="text-white">Email me</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar navbar-inverse bg-inverse">
      <div class="container d-flex justify-content-between">
        <a href="#" class="navbar-brand">FomoCam</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>

<?php 
if(count($images) > 0) { ?>
      <section class="jumbotron text-center">
      <div class="container">
      <a href="<?php echo $newestImage; ?>"><img class="img-fluid" src="<?php echo $newestImage; ?>" /></a>
      </div>
    </section>

        <div class="container-fluid">
  <?php foreach($images as $image) { ?>
          <a href="<?php echo $image; ?>"><img width="100" class="img-thumbnail" class="img-fluid" src="<?php echo $image; ?>" /></a>
<?php }
} else {
  echo 'No images';
} 
 
echo $pagination;
?>
</div>
    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Back to top</a>
        </p>
        <p>FomoCam is a DoES Liverpool Maker Night project.</p>
        <p>Find us at <a href="https://doesliverpool.com">https://doesliverpool.com</a></p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="indexb_files/jquery-3.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="indexb_files/tether.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="indexb_files/holder.js"></script>
    <script>
      $(function () {
        Holder.addTheme("thumb", { background: "#55595c", foreground: "#eceeef", text: "Thumbnail" });
      });
    </script>
    <script src="indexb_files/bootstrap.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="indexb_files/ie10-viewport-bug-workaround.js"></script>
  

<svg xmlns="http://www.w3.org/2000/svg" width="356" height="280" viewBox="0 0 356 280" preserveAspectRatio="none" style="display: none; visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs><style type="text/css"></style></defs><text x="0" y="18" style="font-weight:bold;font-size:18pt;font-family:Arial, Helvetica, Open Sans, sans-serif">356x280</text></svg></body></html>

