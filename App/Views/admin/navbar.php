<?php 

use Simpleframework\RABC\PrivilegedUser;
use Simpleframework\Helpers\Util;
util::startSession();
$privuser = new PrivilegedUser();

$privuserID = $_SESSION['UserID'] ?? 0;


$privuser->getPriUserByID($privuserID);
?>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#">miniShop</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
    	<?php if (isset($_SESSION['userlogin']) && $_SESSION['userlogin']) :?>
      
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/Users/logout">Logga ut</a>
      </li>
      <?php else:?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/Users/login">Logga in</a>
      </li>
      
      <?php endif;?>
      <?php if ($privuser->hasPrivileage('adminsettings')) :?>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Admin
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="<?php echo URLROOT;?>/Admin/addproduct">Lägg till produkt</a>
        <a class="dropdown-item" href="<?php echo URLROOT;?>/Admin/showproducts">Visa alla produkter</a>
      </div>
    </li>
       <?php endif;?>
       
       <li>
       	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#shoppingCartModal">Kundvagn</button>
       </li>
    </ul>
  </div> 
</nav>