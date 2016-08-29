<ul class='nav-bar'>
	<li><a href='index.php'>Home</a></li>
	<li><a href='champions.php'>Champion Information</a></li>
	<li><a href='userstats.php'>User Statistics</a></li>
	<li> 
		<form class="navbar-form" role="search" action='userstats.php' method="post">
			<div class="input-group search_group">
				<select class='form-control input-sm selectpicker user-data' id='search_region' name='search_region'>
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
				<input type="text" class="form-control input-sm search_box" placeholder="Please enter Summoner Name" name="search_summoner" id="search_summoner"/>
				<div class="input-group-btn">
					<button id='search_go' class="btn btn-sm btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
		</form>
	</li>
</ul>