 <style>
     .toas {
         position: fixed;
         top: 20px;
         right: 20px;
         padding: 15px 20px;
         z-index: 1000;
         background-color: #ffffff;
         overflow: hidden;
         animation: slideInOut 7s ease-out forwards;
         border-radius: 0px;
         min-width: 300px;
     }

     @keyframes slideInOut {
         0% {
             opacity: 1;
             transform: translateX(100%);
         }

         5% {
             opacity: 1;
             transform: translateX(0);
         }

         70% {
             opacity: 1;
             transform: translateX(0);
         }

         100% {
             opacity: 0;
             transform: translateX(100%);
         }
     }

     .fa-circle-check,
     .fa-triangle-exclamation {
         margin-right: 15px;
         font-size: 25px;
         border-radius: 4px;
         padding: 5px 7px;
     }

     .fa-circle-check {
         color: green;
         background-color: white;

     }

     .fa-triangle-exclamation {
         color: red;
         background-color: white;
     }
 </style>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <nav class="navbar bg-dark navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
     <!-- Sidebar Toggle (Topbar) -->
     <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
         <i class="fa fa-bars"></i>
     </button>

     <!-- Topbar Search -->
     <form
         class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
         <div class="input-group">
             <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                 aria-label="Search" aria-describedby="basic-addon2">
             <div class="input-group-append">
                 <button class="btn btn-primary" type="button">
                     <i class="fas fa-search fa-sm"></i>
                 </button>
             </div>
         </div>
     </form>

     <!-- Topbar Navbar -->
     <ul class="navbar-nav ml-auto">


         <!-- Nav Item - Messages -->


         <div class="topbar-divider d-none d-sm-block"></div>

         <!-- Nav Item - User Information -->
         <li class="nav-item dropdown no-arrow">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['user']['full_name'] ?></span>
                 <img class="img-profile rounded-circle"
                     src="uploads/<?= $_SESSION['user']['avatar'] ?>">
             </a>
             <!-- Dropdown - User Information -->
             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                 <a class="dropdown-item" href="#">
                     <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                     Profile
                 </a>
                 <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                     Logout
                 </a>
             </div>
         </li>

     </ul>

 </nav>