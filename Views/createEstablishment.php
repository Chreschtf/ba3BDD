<div class="container">
  <div class="row">
  	<div class="col-md-6">
      
          <?php 
              if (isset($notification) && $notification != "")
                  echo "<div style='color:#FF0000'>" . $notification . "</div>";
          ?>
        
          <form class="form-horizontal" action="?action=createEstablishment" method="post">
          <fieldset>
            <div id="legend">
               <p></p><p></p><p></p><p></p>
              <legend class=""></legend>
            </div>
            <div class="control-group">
              <label class="control-label" for="ename">Establishment's name</label>
              <div class="controls">
                <input type="text" pattern="{3,40}" id="ename" name="ename" placeholder="" required class="form-control input-lg">
                <!--<p class="help-block"><?php echo $enameErr;?></p>-->
              </div>
            </div>
         
            <div class="control-group">
              <label class="control-label" for="street">Street</label>
              <div class="controls">
                <input type="text" pattern=".{0}|.{3,40}" id="street" name="street" placeholder="" required class="form-control input-lg">
                <!--<p class="help-block"><?php echo $streetErr;?></p>-->
              </div>
            </div>
         
            <div class="control-group">
              <label class="control-label" for="house_num">House number </label>
              <div class="controls">
                <input type="text" pattern=".{0}|.{1,7}" id="house_num" name="house_num" placeholder="" required class="form-control input-lg">
              </div>
            </div>
                     
            <div class="control-group">
              <label class="control-label" for="zip">Zip</label>
              <div class="controls">
                <input type="text" pattern=".{0}|.{4,4}" id="zip" name="zip" placeholder="" required class="form-control input-lg">
                <!--<p class="help-block"><?php echo $zipErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="city">City</label>
              <div class="controls">
                <input type="text" pattern=".{0}|.{3,20}" id="city" name="city" placeholder="" required class="form-control input-lg">
                <!--<p class="help-block"><?php echo $cityErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="longitude">Longitude</label>
              <div class="controls">
                <input type="text" pattern=".{0}|.{1,23}" id="longitude" name="longitude" placeholder="" required class="form-control input-lg">
                <!--<p class="help-block"><?php echo $longitudeErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="latitude">Latitude</label>
              <div class="controls">
                <input type="text" pattern=".{0}|.{1,23}" id="latitude" name="latitude" placeholder="" required class="form-control input-lg">
                <!--<p class="help-block"><?php echo $latitudeErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="tel">Telephone</label>
              <div class="controls">
                <input type="text" pattern=".{0}|.{8,20}" id="tel" name="tel" placeholder="" required class="form-control input-lg">
                <!--<p class="help-block"><?php echo $telErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="site">Site</label>
              <div class="controls">
                <input type="text" pattern=".{0}|.{5,60}" id="site" name="site" placeholder="" class="form-control input-lg">
                <!--<p class="help-block"><?php echo $siteErr;?></p>-->
              </div>
            </div>
            

           
           
           
            