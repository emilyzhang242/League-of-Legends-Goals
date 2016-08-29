<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>LoL Goals</title>
  <link href="css/styles.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Fredericka+the+Great|Source+Sans+Pro' rel='stylesheet' type='text/css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <link href="css/index.css" rel="stylesheet">
    </head>
    <body>

      <?php include 'header.php'; ?>

      <div class="container-full">

        <div class="row">

          <div class="col-lg-12 text-center v-center">

            <h1 id='title'>LEAGUE OF LEGENDS GOALS</h1>
            <p class='sub-title'>Your Comprehensive Source for All ELO-related Stats</p>
          </div>

          <div class="col-lg-12 text-center v-center container-fluid user-input">
            <p style="color:grey; font-family:Candara; font-size: 15px;"> Please Select the ELO you would like to achieve.<br> Or merely select your region and username for general statistics.</p>
            
            <div class="row">
              <div class="col-lg-3"></div>
              <div class="col-lg-6">
                <form id="index" role="form" action='userstats.php' class='form-group' method="get">
                  <div class="input-group">
                    <select class='form-control selectpicker user-data' id='region' name='region'>
                      <option value=''>Region</option>
                      <option value='br'>BR</option>
                      <option value='eune'>EUNE</option>
                      <option value='euw'>EUW</option>
                      <option value='kr'>KR</option>
                      <option value='lan'>LAN</option>
                      <option value='las'>LAS</option>
                      <option value='na'>NA</option>
                      <option value='oce'>OCE</option>
                      <option value='ru'>RU</option>
                      <option value='tr'>TR</option>  
                    </select>
                    <select class='form-control selectpicker user-data' id='elo' name='elo'>
                      <option value=''>ELO</option>
                      <option value='Bronze_V'>Bronze V</option>
                      <option value='Bronze_IV'>Bronze IV</option>
                      <option value='Bronze_III'>Bronze III</option>
                      <option value='Bronze_II'>Bronze II</option>
                      <option value='Bronze_I'>Bronze I</option>
                      <option value='Silver_V'>Silver V</option>
                      <option value='Silver_IV'>Silver IV</option>
                      <option value='Silver_III'>Silver III</option>
                      <option value='Silver_II'>Silver II</option>
                      <option value='Silver_I'>Silver I</option>
                      <option value='Gold_V'>Gold V</option>
                      <option value='Gold_IV'>Gold IV</option>
                      <option value='Gold_III'>Gold III</option>
                      <option value='Gold_II'>Gold II</option>
                      <option value='Gold_I'>Gold I</option>
                      <option value='Platinum_V'>Platinum V</option>
                      <option value='Platinum_IV'>Platinum IV</option>
                      <option value='Platinum_III'>Platinum III</option>
                      <option value='Platinum_II'>Platinum II</option>
                      <option value='Platinum_I'>Platinum I</option>
                      <option value='Diamond_V'>Diamond V</option>
                      <option value='Diamond_IV'>Diamond IV</option>
                      <option value='Diamond_III'>Diamond III</option>
                      <option value='Diamond_II'>Diamond II</option>
                      <option value='Diamond_I'>Diamond I</option>
                    </select>
                    <input id='summoner' name='summoner' type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Enter your summoner name">
                    <span class="input-group-btn">
                      <input name='go' class="btn btn-secondary" id="go" type="submit" value="Go!">
                    </span>
                  </div>
                </form>
              </div>
              <div class="col-lg-3"></div>
            </div>

            <div class='row'>
              <p id='errors' class='warning'></p>
            </div>
          </div>
        </div>
      </div>
    </body>
    </html>