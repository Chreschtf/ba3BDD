<div class="container">
  <div class="row">
  	<div class="col-md-6">
    
          <form class="form-horizontal" action="?action=createEstablishment" method="post">
          <fieldset>
            <div id="legend">
               <p></p><p></p><p></p><p></p>
              <legend class=""></legend>
            </div>
            <div class="control-group">
              <label class="control-label" for="ename">Establishment's name</label>
              <div class="controls">
                <input type="text" id="ename" name="ename" placeholder="" class="form-control input-lg">
                <!--<p class="help-block"><?php echo $enameErr;?></p>-->
              </div>
            </div>
         
            <div class="control-group">
              <label class="control-label" for="street">Street</label>
              <div class="controls">
                <input type="street" id="street" name="street" placeholder="" class="form-control input-lg">
                <!--<p class="help-block"><?php echo $streetErr;?></p>-->
              </div>
            </div>
         
            <div class="control-group">
              <label class="control-label" for="housenum">House number </label>
              <div class="controls">
                <input type="housenum" id="housenum" name="housenum" placeholder="" class="form-control input-lg">
              </div>
            </div>
                     
            <div class="control-group">
              <label class="control-label" for="zip">Zip</label>
              <div class="controls">
                <input type="zip" id="zip" name="zip" placeholder="" class="form-control input-lg">
                <!--<p class="help-block"><?php echo $zipErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="city">City</label>
              <div class="controls">
                <input type="city" id="city" name="city" placeholder="" class="form-control input-lg">
                <!--<p class="help-block"><?php echo $cityErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="longitude">Longitude</label>
              <div class="controls">
                <input type="longitude" id="longitude" name="longitude" placeholder="" class="form-control input-lg">
                <!--<p class="help-block"><?php echo $longitudeErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="latitude">Latitude</label>
              <div class="controls">
                <input type="latitude" id="latitude" name="latitude" placeholder="" class="form-control input-lg">
                <!--<p class="help-block"><?php echo $latitudeErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="tel">Telephone</label>
              <div class="controls">
                <input type="tel" id="tel" name="tel" placeholder="" class="form-control input-lg">
                <!--<p class="help-block"><?php echo $telErr;?></p>-->
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="site">Site</label>
              <div class="controls">
                <input type="site" id="site" name="site" placeholder="" class="form-control input-lg">
                <!--<p class="help-block"><?php echo $siteErr;?></p>-->
              </div>
            </div>
            
            <h3>Opening hours :</h3>
           <div class="control-group">
              
              <div class="controls">
                <label class="control-label" for="Mon">Monday : </label><p>
                <input type="radio" value="Mon_open" name="Mon"  checked >Open all day</input>
                <input type="radio" value="Mon_am" name="Mon" >Closed AM</input>
                <input type="radio" value="Mon_pm" name="Mon" >Closed PM</input>
                <input type="radio" value="Mon_complete" name="Mon"  >Closed all day</input>
                <br>
                <label class="control-label" for="Tue">Tuesday : </label><p>
                <input type="radio" value="Tue_open" name="Tue"  checked >Open all day</input>
                <input type="radio" value="Tue_am" name="Tue" >Closed AM</input>
                <input type="radio" value="Tue_pm" name="Tue" >Closed PM</input>
                <input type="radio" value="Tue_complete" name="Tue"  >Closed all day</input>
                <br>
                <label class="control-label" for="Wed">Wednesday : </label><p>
                <input type="radio" value="Wed_open" name="Wed"  checked >Open all day</input>
                <input type="radio" value="Wed_am" name="Wed" >Closed AM</input>
                <input type="radio" value="Wed_pm" name="Wed" >Closed PM</input>
                <input type="radio" value="Wed_complete" name="Wed"  >Closed all day</input>
                <br>
                <label class="control-label" for="Thu">Thursday : </label><p>
                <input type="radio" value="Thu_open" name="Thu"  checked >Open all day</input>
                <input type="radio" value="Thu_am" name="Thu" >Closed AM</input>
                <input type="radio" value="Thu_pm" name="Thu" >Closed PM</input>
                <input type="radio" value="Thu_complete" name="Thu"  >Closed all day</input>
                <br>
                <label class="control-label" for="Fri">Friday : </label><p>
                <input type="radio" value="Fri_open" name="Fri"  checked >Open all day</input>
                <input type="radio" value="Fri_am" name="Fri" >Closed AM</input>
                <input type="radio" value="Fri_pm" name="Fri" >Closed PM</input>
                <input type="radio" value="Fri_complete" name="Fri"  >Closed all day</input>
                <br>
                <label class="control-label" for="Sat">Saturday : </label><p>
                <input type="radio" value="Sat_open" name="Sat"  checked >Open all day</input>
                <input type="radio" value="Sat_am" name="Sat" >Closed AM</input>
                <input type="radio" value="Sat_pm" name="Sat" >Closed PM</input>
                <input type="radio" value="Sat_complete" name="Sat"  >Closed all day</input>
                <br>  
                <label class="control-label" for="Sun">Sunday : </label><p>
                <input type="radio" value="Sun_open" name="Sun"  checked >Open all day</input>
                <input type="radio" value="Sun_am" name="Sun" >Closed AM</input>
                <input type="radio" value="Sun_pm" name="Sun" >Closed PM</input>
                <input type="radio" value="Sun_complete" name="Sun"  >Closed all day</input>
              </div>
            </div>
           
           
           
            <br>
            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <button class="btn btn-success" name="form_signup" type="submit">Submit</button>
              </div>
            </div>
          
          
          
          
          
          
          </fieldset>
          
        </form>
    
    </div> 
  </div>
</div>