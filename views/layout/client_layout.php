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

 <?php
    require VIEW_FOLDER . "common/client/header.php";
    getToast();
    require $content;
    if (!empty($_SESSION['error'])) unset($_SESSION['error']);
    require VIEW_FOLDER . "common/client/footer.php";
    ?>