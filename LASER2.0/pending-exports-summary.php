<!--

=========================================================
* Volt Free - Bootstrap 5 Dashboard
=========================================================

* Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
* Copyright 2021 Themesberg (https://www.themesberg.com)
* License (https://themesberg.com/licensing)

* Designed and coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal.

-->
<!DOCTYPE html>
<html lang="en">

<?php include('pages/components/header.php'); ?>

<body>

        <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->
        
        <?php include('pages/components/sidebar.php'); ?>
      
    
        <main class="content">

        <?php include('pages/components/right-navbar.php'); ?>
         

          
            <div class="row">
             
                <div class="col-12 col-xl-12">
                    <div class="col-12 px-0 mb-4">
                        <div class="card border-0 shadow">
                            <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                                <div class="d-block">
                                    <div class="h6 fw-normal text-gray mb-2">Total Shipments</div>
                                    <h2 class="h3 fw-extrabold" id="shipmentTotal" >103 </h2>
                                    
                                </div>
                                <div class="d-block ms-auto">
                                    <div class="d-flex align-items-center text-end">
                                        <span class="dot rounded-circle bg-gray-800 me-2"></span>
                                        <span class="fw-normal small">Pending Arrival</span>
                                    </div>
                                    <div class="d-flex align-items-center text-end">
                                        <span class="dot rounded-circle bg-secondary me-2"></span>
                                        <span class="fw-normal small">0-5 Days</span>
                                    </div>
                                    <div class="d-flex align-items-center text-end">
                                        <span class="dot rounded-circle third-legend me-2"></span>
                                        <span class="fw-normal small">6-10 Days</span>
                                    </div>
                                    <div class="d-flex align-items-center text-end">
                                        <span class="dot rounded-circle forth-legend me-2"></span>
                                        <span class="fw-normal small">11-20 Days</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2" style="height: 400px;" >
                                <div class="ct-chart-ranking ct-golden-section ct-series-a" style="height:400px;" ></div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
  
</div>


    <?php include('pages/components/footer.php'); ?>
        </main>


    
</body>

</html>
