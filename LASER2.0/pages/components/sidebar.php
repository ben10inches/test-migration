<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
  
  <div class="d-flex align-items-center">
      <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
  </div>
</nav>

<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
<div class="sidebar-inner px-2 pt-3">
<div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
<div class="d-flex align-items-center">
<div class="avatar-lg me-4">
<img src="assets/img/team/profile-picture-3.jpg" class="card-img-top rounded-circle border-white"
  alt="Admin">
</div>
<div class="d-block">
<h2 class="h5 mb-3">Hi, Admin</h2>
<a href="pages/examples/sign-in.html" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
  <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>            
  Sign Out
</a>
</div>
</div>
<div class="collapse-close d-md-none">
<a href="#sidebarMenu" data-bs-toggle="collapse"
  data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true"
  aria-label="Toggle navigation">
  <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
</a>
</div>
</div>
<ul class="nav flex-column pt-3 pt-md-0">
    
<li class="nav-item mb-2">
  <?php 

  if (file_exists('assets/img/brand/'.$_SESSION['userUID'].'.png')){
    // echo("Here");
    echo '
    <a href="/LASER2.0/" class="nav-link d-flex align-items-center">
      <span class="sidebar-icon" style="display: block;margin-left: auto;margin-right: auto;padding-bottom:5%;">
          <img src="assets/img/brand/'.$_SESSION['userUID'].'.png" style="width:100%;" alt="Volt Logo">
      </span>
    ';
  }
  elseif (isset($_SESSION['odoo_id'])) {
   
    $url = 'https://laser.rampslogistics.com/customer_img/' . strval($_SESSION['odoo_id']);
    $json = file_get_contents($url);
    $obj = json_decode($json);
    $base64 = $obj->{'img'};
    if (empty($obj->error) ){
      echo '
        <a href="/LASER2.0/" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon" style="display: block;margin-left: auto;margin-right: auto;padding-bottom:5%;">
              <img src="data:image/jpeg;base64,'.$base64.'" style="width:100%;" alt="Volt Logo">
          </span>
        ';
    }
    
  }
  else { 
    // echo 'assets/img/brand/'.$_SESSION['userUID'].'.svg';
    echo '
    <a href="/LASER2.0/" class="nav-link d-flex align-items-center" style="max-width: 100%;" >
    <span class="sidebar-icon">
      <img src="'.$Logo.'"style="width:100%;" alt="Logo">
    </span>
    ';
  }
  // print_r($_SESSION);
  ?>

  
  </a>
</li>
<li class="nav-item"  <?php if($companyName != 'esso'){echo "hidden";} ?>>
    <select  class="form-select d-flex align-items-center" aria-label="Select a service"  id="shipmentDBSelect" >
      <?php try{ ?>
      <option value='brokerage'  <?php if( isset($_SESSION['currentData']) && $_SESSION['currentData'] == "brokerage"){echo "selected";}?>>Trinidad</option>

      <option value="guyana" <?php if(isset($_SESSION['currentData']) && $_SESSION['currentData'] == "guyana"){echo "selected";}?>>Guyana</option>
      <?php } catch (SomeException $e)
          {
          }
        ?>
    </select>
</li>

<li role="separator" class="dropdown-divider border-gray-700"></li>
<li class="nav-item" <?php if($demo != 1){echo "hidden";} ?> >
        <a href="index.php" class="nav-link">
        <span class="sidebar-icon">
          <svg aria-hidden="true" class="icon icon-xs me-2" focusable="false" data-prefix="fas" data-icon="tachometer-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-tachometer-alt fa-w-18 fa-3x"><path fill="currentColor" d="M288 32C128.94 32 0 160.94 0 320c0 52.8 14.25 102.26 39.06 144.8 5.61 9.62 16.3 15.2 27.44 15.2h443c11.14 0 21.83-5.58 27.44-15.2C561.75 422.26 576 372.8 576 320c0-159.06-128.94-288-288-288zm0 64c14.71 0 26.58 10.13 30.32 23.65-1.11 2.26-2.64 4.23-3.45 6.67l-9.22 27.67c-5.13 3.49-10.97 6.01-17.64 6.01-17.67 0-32-14.33-32-32S270.33 96 288 96zM96 384c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32zm48-160c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32zm246.77-72.41l-61.33 184C343.13 347.33 352 364.54 352 384c0 11.72-3.38 22.55-8.88 32H232.88c-5.5-9.45-8.88-20.28-8.88-32 0-33.94 26.5-61.43 59.9-63.59l61.34-184.01c4.17-12.56 17.73-19.45 30.36-15.17 12.57 4.19 19.35 17.79 15.17 30.36zm14.66 57.2l15.52-46.55c3.47-1.29 7.13-2.23 11.05-2.23 17.67 0 32 14.33 32 32s-14.33 32-32 32c-11.38-.01-20.89-6.28-26.57-15.22zM480 384c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32z" class=""></path></svg>
        </span>
        <span class="sidebar-text">PERFORMANCE</span>
        </a>
      </li>
<li class="nav-item">
        <span
          class="nav-link  collapsed  d-flex justify-content-between align-items-center"
          data-bs-toggle="collapse" data-bs-target="#submenu-pages">
          <span>
            <span class="sidebar-icon">
              <!-- <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg> -->
              <svg aria-hidden="true" class="icon icon-xs me-2" focusable="false" data-prefix="fas" data-icon="ship" class="svg-inline--fa fa-ship" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M192 32C192 14.33 206.3 0 224 0H352C369.7 0 384 14.33 384 32V64H432C458.5 64 480 85.49 480 112V240L524.4 254.8C547.6 262.5 553.9 292.3 535.9 308.7L434.9 401.4C418.7 410.7 400.2 416.5 384 416.5C364.4 416.5 343.2 408.8 324.8 396.1C302.8 380.6 273.3 380.6 251.2 396.1C234 407.9 213.2 416.5 192 416.5C175.8 416.5 157.3 410.7 141.1 401.3L40.09 308.7C22.1 292.3 28.45 262.5 51.59 254.8L96 239.1V111.1C96 85.49 117.5 63.1 144 63.1H192V32zM160 218.7L267.8 182.7C280.9 178.4 295.1 178.4 308.2 182.7L416 218.7V128H160V218.7zM384 448C410.9 448 439.4 437.2 461.4 421.9L461.5 421.9C473.4 413.4 489.5 414.1 500.7 423.6C515 435.5 533.2 444.6 551.3 448.8C568.5 452.8 579.2 470.1 575.2 487.3C571.2 504.5 553.1 515.2 536.7 511.2C512.2 505.4 491.9 494.6 478.5 486.2C449.5 501.7 417 512 384 512C352.1 512 323.4 502.1 303.6 493.1C297.7 490.5 292.5 487.8 288 485.4C283.5 487.8 278.3 490.5 272.4 493.1C252.6 502.1 223.9 512 192 512C158.1 512 126.5 501.7 97.5 486.2C84.12 494.6 63.79 505.4 39.27 511.2C22.06 515.2 4.853 504.5 .8422 487.3C-3.169 470.1 7.532 452.8 24.74 448.8C42.84 444.6 60.96 435.5 75.31 423.6C86.46 414.1 102.6 413.4 114.5 421.9L114.6 421.9C136.7 437.2 165.1 448 192 448C219.5 448 247 437.4 269.5 421.9C280.6 414 295.4 414 306.5 421.9C328.1 437.4 356.5 448 384 448H384z"></path></svg>
            </span> 
            <span class="sidebar-text">IMPORTS</span>
          </span>
          <span class="link-arrow">
            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
          </span>
        </span>
        <div class="multi-level collapse " role="list"
          id="submenu-pages" aria-expanded="false">
          <ul class="flex-column nav">
            <li class="nav-item">
              <a class="nav-link" href="shipments.php">
                <span class="sidebar-text">Pending Clearance</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cleared-imports-details.php">
                <span class="sidebar-text">Cleared</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <span
          class="nav-link  collapsed  d-flex justify-content-between align-items-center"
          data-bs-toggle="collapse" data-bs-target="#exports-pages">
          <span>
            <span class="sidebar-icon">
              <!-- <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg> -->
              <!-- <svg aria-hidden="true" class="icon icon-xs me-2" focusable="false" data-prefix="fas" data-icon="ship" class="svg-inline--fa fa-ship" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M192 32C192 14.33 206.3 0 224 0H352C369.7 0 384 14.33 384 32V64H432C458.5 64 480 85.49 480 112V240L524.4 254.8C547.6 262.5 553.9 292.3 535.9 308.7L434.9 401.4C418.7 410.7 400.2 416.5 384 416.5C364.4 416.5 343.2 408.8 324.8 396.1C302.8 380.6 273.3 380.6 251.2 396.1C234 407.9 213.2 416.5 192 416.5C175.8 416.5 157.3 410.7 141.1 401.3L40.09 308.7C22.1 292.3 28.45 262.5 51.59 254.8L96 239.1V111.1C96 85.49 117.5 63.1 144 63.1H192V32zM160 218.7L267.8 182.7C280.9 178.4 295.1 178.4 308.2 182.7L416 218.7V128H160V218.7zM384 448C410.9 448 439.4 437.2 461.4 421.9L461.5 421.9C473.4 413.4 489.5 414.1 500.7 423.6C515 435.5 533.2 444.6 551.3 448.8C568.5 452.8 579.2 470.1 575.2 487.3C571.2 504.5 553.1 515.2 536.7 511.2C512.2 505.4 491.9 494.6 478.5 486.2C449.5 501.7 417 512 384 512C352.1 512 323.4 502.1 303.6 493.1C297.7 490.5 292.5 487.8 288 485.4C283.5 487.8 278.3 490.5 272.4 493.1C252.6 502.1 223.9 512 192 512C158.1 512 126.5 501.7 97.5 486.2C84.12 494.6 63.79 505.4 39.27 511.2C22.06 515.2 4.853 504.5 .8422 487.3C-3.169 470.1 7.532 452.8 24.74 448.8C42.84 444.6 60.96 435.5 75.31 423.6C86.46 414.1 102.6 413.4 114.5 421.9L114.6 421.9C136.7 437.2 165.1 448 192 448C219.5 448 247 437.4 269.5 421.9C280.6 414 295.4 414 306.5 421.9C328.1 437.4 356.5 448 384 448H384z"></path></svg> -->
              <svg aria-hidden="true" class="icon icon-xs me-2" focusable="false" data-prefix="fas" data-icon="plane-departure" class="svg-inline--fa fa-plane-departure" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M484.6 62C502.6 52.8 522.6 48 542.8 48H600.2C627.2 48 645.9 74.95 636.4 100.2C618.2 148.9 582.1 188.9 535.6 212.2L262.8 348.6C258.3 350.8 253.4 352 248.4 352H110.7C101.4 352 92.5 347.9 86.42 340.8L13.34 255.6C6.562 247.7 9.019 235.5 18.33 230.8L50.49 214.8C59.05 210.5 69.06 210.2 77.8 214.1L135.1 239.1L234.6 189.7L87.64 95.2C77.21 88.49 78.05 72.98 89.14 67.43L135 44.48C150.1 36.52 169.5 35.55 186.1 41.8L381 114.9L484.6 62zM0 480C0 462.3 14.33 448 32 448H608C625.7 448 640 462.3 640 480C640 497.7 625.7 512 608 512H32C14.33 512 0 497.7 0 480z"></path></svg>
            </span> 
            <span class="sidebar-text">EXPORTS</span>
          </span>
          <span class="link-arrow">
            <svg style="width: 22px;" class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
          </span>
        </span>
        <div class="multi-level collapse " role="list"
          id="exports-pages" aria-expanded="false">
          <ul class="flex-column nav">
            <li class="nav-item">
              <a class="nav-link" href="pending-exports-details.php">
                <span class="sidebar-text">Pending Departure</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shipments-exported-details.php">
                <span class="sidebar-text">Departed</span>
              </a>
            </li>
          </ul>
        </div>
      </li>


      <!-- <li class="nav-item ">
        <a href="shipments-exported-delivered--details.php" class="nav-link">
        <span class="sidebar-icon">
          <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
        </span>
        <span class="sidebar-text" style="font-size:13px;">Exported and Delivered</span>
        </a>
      </li> -->
      <li class="nav-item"  <?php if($companyName != 'esso'){echo "hidden";} ?>>
        <span
          class="nav-link  collapsed  d-flex justify-content-between align-items-center"
          data-bs-toggle="collapse" data-bs-target="#submenu-pages2">
          <span>
            <span class="sidebar-icon">
              <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
            </span> 
            <span class="sidebar-text">Vessel Clearance</span>
          </span>
          <span class="link-arrow">
            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
          </span>
        </span>
        <div class="multi-level collapse " role="list"
          id="submenu-pages2" aria-expanded="false">
          <ul class="flex-column nav">
            <li class="nav-item">
              <a class="nav-link" href="esso-clearance-kpi.php">
                <span class="sidebar-text" style="font-size:12px;">Esso Clearance & Delivery</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="psv-clearance-kpi.php">
                <span class="sidebar-text"  style="font-size:12px;">PSV Clearance & Delivery</span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="invoicing-kpi.php">
                <span class="sidebar-text"  style="font-size:12px;">Invoicing KPI</span>
              </a>
            </li> -->
         
          </ul>
        </div>
      </li>
      <li class="nav-item " <?php if($companyName != 'esso'){echo "hidden";} ?> >
        <a href="license-permit.php" class="nav-link">
        <span class="sidebar-icon">
          <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
        </span>
        <span class="sidebar-text">License/Permit Details</span>
        </a>
      </li>

    



<li class="nav-item">
        <span
          class="nav-link  collapsed  d-flex justify-content-between align-items-center"
          data-bs-toggle="collapse" data-bs-target="#submenu-pages3">
          <span>
            <span class="sidebar-icon">
            <!-- <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg> -->

            <svg aria-hidden="true" focusable="false" class="icon icon-xs me-2" data-prefix="fas" data-icon="credit-card" class="svg-inline--fa fa-credit-card" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M512 32C547.3 32 576 60.65 576 96V128H0V96C0 60.65 28.65 32 64 32H512zM576 416C576 451.3 547.3 480 512 480H64C28.65 480 0 451.3 0 416V224H576V416zM112 352C103.2 352 96 359.2 96 368C96 376.8 103.2 384 112 384H176C184.8 384 192 376.8 192 368C192 359.2 184.8 352 176 352H112zM240 384H368C376.8 384 384 376.8 384 368C384 359.2 376.8 352 368 352H240C231.2 352 224 359.2 224 368C224 376.8 231.2 384 240 384z"></path></svg>
            </span> 
            <span class="sidebar-text">INVOICES</span>
          </span>
          <span class="link-arrow">
            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
          </span>
        </span>
        <div class="multi-level collapse " role="list"
          id="submenu-pages3" aria-expanded="false">
          <ul class="flex-column nav">
            <li class="nav-item">
              <a class="nav-link" href="invoices.php">
                <span class="sidebar-text">Outstanding</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="paid-invoices.php">
                <span class="sidebar-text">Paid</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      
      <li role="separator" class="dropdown-divider border-gray-700"></li>
<li class="nav-item"  >
        <a href="functions/logout.php" class="nav-link">
        <span class="sidebar-icon">
          <!-- <svg aria-hidden="true" class="icon icon-xs me-2" focusable="false" data-prefix="fas" data-icon="tachometer-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-tachometer-alt fa-w-18 fa-3x"><path fill="currentColor" d="M288 32C128.94 32 0 160.94 0 320c0 52.8 14.25 102.26 39.06 144.8 5.61 9.62 16.3 15.2 27.44 15.2h443c11.14 0 21.83-5.58 27.44-15.2C561.75 422.26 576 372.8 576 320c0-159.06-128.94-288-288-288zm0 64c14.71 0 26.58 10.13 30.32 23.65-1.11 2.26-2.64 4.23-3.45 6.67l-9.22 27.67c-5.13 3.49-10.97 6.01-17.64 6.01-17.67 0-32-14.33-32-32S270.33 96 288 96zM96 384c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32zm48-160c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32zm246.77-72.41l-61.33 184C343.13 347.33 352 364.54 352 384c0 11.72-3.38 22.55-8.88 32H232.88c-5.5-9.45-8.88-20.28-8.88-32 0-33.94 26.5-61.43 59.9-63.59l61.34-184.01c4.17-12.56 17.73-19.45 30.36-15.17 12.57 4.19 19.35 17.79 15.17 30.36zm14.66 57.2l15.52-46.55c3.47-1.29 7.13-2.23 11.05-2.23 17.67 0 32 14.33 32 32s-14.33 32-32 32c-11.38-.01-20.89-6.28-26.57-15.22zM480 384c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32z" class=""></path></svg> -->

          <svg xmlns="http://www.w3.org/2000/svg" focusable="false" data-prefix="fas" class="icon icon-xs me-2 svg-inline--fa  fa-w-18 fa-3x" aria-hidden="true" viewBox="0 0 512 512"><path d="M160 416H96c-17.67 0-32-14.33-32-32V128c0-17.67 14.33-32 32-32h64c17.67 0 32-14.33 32-32S177.7 32 160 32H96C42.98 32 0 74.98 0 128v256c0 53.02 42.98 96 96 96h64c17.67 0 32-14.33 32-32S177.7 416 160 416zM502.6 233.4l-128-128c-12.51-12.51-32.76-12.49-45.25 0c-12.5 12.5-12.5 32.75 0 45.25L402.8 224H192C174.3 224 160 238.3 160 256s14.31 32 32 32h210.8l-73.38 73.38c-12.5 12.5-12.5 32.75 0 45.25s32.75 12.5 45.25 0l128-128C515.1 266.1 515.1 245.9 502.6 233.4z" fill="currentColor" /></svg>
        </span>
        <span class="sidebar-text">LOGOUT</span>
        </a>
      </li>
      <i class="fa-solid fa-arrow-right-from-bracket"></i>




</ul>
</div>
</nav>