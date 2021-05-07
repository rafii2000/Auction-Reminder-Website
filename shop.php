<!DOCTYPE html>
<html lang="en" dir="ltr">

   <head>
      <meta charset="utf-8">
      <title>Auction Reminder - Shop</title>
      <link rel="stylesheet" href="css/shop.css">
      <link rel="stylesheet" href="css/home_shop_navbar.css">
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,300&display=swap" rel="stylesheet">
   </head>

   <body>

      <div id="wrapper">

         <?php include_once "html_elements/index_left_container.php" ?>

         <div id="right_container">

            <?php include_once "html_elements/index_navbar.php" ?>

            <div id="information_label">
               Shop section is not ready yet. Only trial licence versions are available now.
            </div>

            <div id="trial_licence_container"></div>


            <div id="shop_container">

               <div id="licence_oferts">
                  <div class="section_title">Licences</div>

                  <div id="1_month" class="shop_radius_button licence_button" onclick="chose_licence_price('1_month')">
                     <div class="period">1 month</div>
                     <div class="price">1$</div>
                  </div>

                  <div id="6_months" class="shop_radius_button licence_button" onclick="chose_licence_price('6_months')">
                     <div class="period">6 months</div>
                     <div class="price">5$</div>
                  </div>

                  <div id="12_months" class="shop_radius_button licence_button" onclick="chose_licence_price('12_months')">
                     <div class="period">12 months</div>
                     <div class="price">10$</div>
                  </div>

               </div>


               <div id="payments_methods">
                  <div class="section_title">Payments Methods</div>

                  <div id="PayPal" class="shop_radius_button payments_button" onclick="chose_payments_method('PayPal')">
                     <div class="">Pay Pal</div>
                  </div>

                  <div id="CreditCard" class="shop_radius_button payments_button" onclick="chose_payments_method('CreditCard')">
                     <div class="">Credit Card</div>
                  </div>

                  <div id="BankTransfer" class="shop_radius_button payments_button" onclick="chose_payments_method('BankTransfer')">
                     <div class="">Video (free)</div>
                  </div>

               </div>

               <div id="sessions_container">
                  <form class="" action="" method="post">
                     <label for="">Sessions:</label>
                     <input id="sessions_amount"type="text" name="" maxlength="3" value="1" onblur="set_sessions_amount()">

                  </form>
               </div>

               <div id="order_resume_container">
                  <div id="order_total_cost_container">
                     <div id="total_cost_label">Total cost:</div>
                     <div id="total_cost_price">$$$</div>
                  </div>

                  <div id="shop_buy_button" class="radius_button" onclick="show_trial_licence()">Get Trial</div>
               </div>

            </div>

            <div id="payments_methods_list">
               <img id="visa" src="img/visa.png" alt="">
               <img id="mastercard" src="img/mastercard.png" alt="">
               <img id="maestro" src="img/maestro.png" alt="">
               <img id="paypal" src="img/paypal.png" alt="">
               <img id="western_union" src="img/western-union.png" alt="">
            </div>



         </div>
      </div>

      <script src="scripts/jquery-min.js" type="text/javascript"></script>
      <script src="scripts/shop.js" type="text/javascript"></script>




   </body>
</html>
