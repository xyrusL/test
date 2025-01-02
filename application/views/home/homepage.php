<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
	<title>RioAnimePlay - Watch anime online for Free</title>
	
	<!--fonts-->
	<link href='https://fonts.googleapis.com' rel='preconnect'/>
	<link crossorigin='' href='https://fonts.gstatic.com' rel='preconnect'/>
	<link href='https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&family=Lexend:wght@100..900&family=Lexus+Sans+Serif:wght@300;400;700&display=swap' rel='stylesheet'/>

    <!--JS-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script>
        let baseUrl = '<?php echo base_url(); ?>';
    </script>
	<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

	<!--CSS-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
	<?php include 'navbar.php'; ?>
	<div class="middle">
		<div id="flexcontainer">
			<div class="leftside">
				<div id="pwaContainer">
					AniMixPlay PWA available<button id="pwaButton" class="btn btn-primary">Install PWA</button>
				</div>
				<div id="featuredcard">
					<div id="featuredbgcont">
						<img id="featuredbg" src="https://imgcdn.bunnycdn.to/poster/ninja-kamui.jpg" />
					</div>
					<div id="featuredcont">
						<a href="/anime/281425"><img id="featuredimg" src="https://imgcdn.bunnycdn.to/poster/ninja-kamui.jpg" /></a>
						<div id="featuredtitle"><a href="/anime/281425">Ninja Kamui</a></div>
						<div id="featuredtext">Anime Details Here</div>
						<div id="featuredgenre"><i class="glyphicon glyphicon-tag"></i> Action, Fantasy, Sci-Fi</div>
						<a id="featuredNext" onclick="showFeatured(curFeatured + 1)"><i class="glyphicon glyphicon-chevron-right"></i></a>
						<a id="featuredBack" onclick="showFeatured(curFeatured - 1)"><i class="glyphicon glyphicon-chevron-left"></i></a>
					</div>
				</div>
				<div id="announcement">
					<span style="color:#ff3d3d;">Note: We need money to maintain services, Ads are enabled temporarily!</span><br>
					<a rel="noopener ugc nofollow noreferrer" href="https://twitter.com/Animixplay_" target="_blank"><img src="/assets/twitter.png"> Twitter </a> |
					<a href="https://discord.gg/2jqb8XPV2C" rel="noopener ugc nofollow noreferrer" target="_blank"> <span class="customicon discordicon" style="margin: 0;margin-bottom: -4px;"></span> Discord </a> | 
					<a href="https://medium.com/@Animixplay_" rel="noopener ugc nofollow noreferrer" target="_blank"> <img src="/assets/blog.png" style=" width: 16px; height: 16px; "> Blog | </a>
					<span style="color:#c1ba93;">AniMixPlay.name</span> is our Current Site/Domain. <br> 
					Don't rely on google search! use bookmark instead.<br>
					<br> 
					If you got problem try <i class="glyphicon glyphicon-repeat"></i> reload the player several times, or just switch to external player.<br> 
					Also worth to try in incognito mode, disabling browser extension, or clearing cache.<br>
					<br> 
					For mobile users, you can swipe left / right to open menu, schedule, and stream list.<br> 
					You can also install PWA (add to homescreen) to launch AniMixPlay like an app.<br>
					<br> 
					Read more info in our <a href="https://animixplay.to/info.html">info</a> page.<br>
				</div>
				<button type="button" id="readmorebtn" class="btn btn-secondary btn-sm btn-lg btn-block">
					<i class="glyphicon glyphicon-menu-down"></i>
				</button>
				<button type="button" id="openschedulebtn" onclick="showschedulemenu()">
					<i class="glyphicon glyphicon-time"></i> Schedule
				</button>
				<div id="navtab">
					<ul class="nav nav-tabs">
						<li id="showSub"><a>Sub</a></li>
						<li id="showDub"><a>Dub</a></li>
						<li id="showAll"><a>All</a></li>
						<li id="showFollowed"><a>Followed <span id="ttl_foitm"></span></a></li>
						<li id="showPopular"><a>Popular</a></li>
						<li id="showMovie"><a>Movie</a></li>
					</ul>
				</div>
				<div id="seasontopnav">
					<div id="prevseasonbtn" onclick="seasonPrev()">&lt; Previous season</div>
					<div id="nextseasonbtn" onclick="seasonNext()">Next season &gt;</div>
				</div>
				<div id="genresortbtn">
					Sort by:
					<select id="topsortselect" onchange="filterSortChange()">
						<option value="any">None</option>
						<option value="popular" selected>Popularity</option>
						<option value="rating">Rating</option>
						<option value="latest">Recent Update</option>
						<option value="most_Members">Most Members</option>
						<option value="high_Scored">High Scored</option>
						<option value="low_Scored">Low Scored</option>
						<option value="favorites">Favorites</option>
						<option value="long_Duration">Long Duration</option>
						<option value="short_Duration">Short Duration</option>
						<option value="year_Old">Year &#8593; Old</option>
						<option value="year_New">Year &#8595; New</option>
						<option value="huge_Shows">Huge Shows &#8593;</option>
						<option value="small_Shows">Small Shows &#8595;</option>
					</select>
				</div>
				<div id="resultplace">
					<ul class="searchresult">
						<?php foreach (array_slice($animeSeries, 0, 24) as $anime): ?>
							<li>
								<?php 
								// Remove special characters
								$clean_title = preg_replace('/[♥♡☆→()]/u', '', $anime->title);						
								$url_title = strtolower($clean_title);
								$url_title = str_replace([':', '+', '!', '?', '.', ' '], '-', $url_title);
								$url_title = preg_replace('/-+/', '-', $url_title);
								$url_title = trim($url_title, '-');
								?>
								<a href="<?= base_url('watch/' . $url_title) ?>" data-id="<?= $anime->id ?>" class="anime-link" title="<?= $anime->title ?>">
									<div class="searchimg">
										<img 
											alt="<?= $anime->title ?> - Free Online" 
											class="resultimg" 
											src="<?= $anime->poster ?>" 
										/>
										<div class="timetext"><?= $anime->date ?></div>
										<div class="rating"><i class="glyphicon glyphicon-star"></i> <?= $anime->mal_score ?></div>
									</div>
									<div class="details">
										<p class="name"><?= $anime->title ?></p>
										<p class="infotext">EP <?= $anime->total_episodes ?><?= $anime->status === 'Finished Airing' ? '' : '/?'?></p>
									</div>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
					<div id="bottommsg">
						<div id="loadmorelist"><i class="glyphicon glyphicon-menu-down"></i> Load more</div>
					</div>
				</div>
				<div id="bottommsgx">
					
				</div>
				<div id="loadingtext">
					<svg class="spinner" width="75px" height="75px" viewbox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
						<circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
					</svg><br><br>Loading...
				</div>
				<div id="resultAlt">
					<div id="loadmoresearch">Loading...</div>
				</div>
				<br>
			</div>
			<div class="rightside" id="rightsidee">
				<div class="rightcard">
					<div class="loadingreplacement">Loading...</div>
					<div class="usercard"></div>
				</div>
				<div class="rightcard signinhome" id="gsignsection">
					<div class="subtitleright" style="border-bottom:none"></div>
					<div id="gconnectbtn"><img id="gconnectbtnimg" onclick="connectGoogle()" src="<?php echo base_url('assets/imgs/gsign.jpg'); ?>"></div>
				</div>
				<div class="rightcard mobilemenureplace">
					<a class="topmenubtn" onclick="showschedulemenu()"><i class="glyphicon glyphicon-time"></i>Schedule</a>
					<a class="topmenubtn" title="Random anime" href="/random"><i class="glyphicon glyphicon-random"></i>Random</a>
					<a class="topmenubtn" title="A-Z List" href="/list">A-Z List</a>
				</div>
				<div class="rightcard">
					<div class="flexrightcard" id="seasonfilter">
						
						<div id="seasonleft">
							<label for="seasonselect">Season:</label>
							<select id="seasonselect">
								<option value="Winter">Winter</option>
								<option value="Spring">Spring</option>
								<option value="Summer">Summer</option>
								<option value="Fall">Fall</option>
							</select>
						</div>
						<div id="yearright">
							<label for="yearselect">Year:</label>
							<select id="yearselect"></select>
						</div>
						<div style="flex:1">
							<div id="seasonalgobtn" onclick="seasonGo()">GO</div>
						</div>
					</div>
				</div>
				<div class="rightcard">
					<div class="subtitleright">Genres</div>
					<div class="flexrightcard" id="genreplace" style="visibility: visible;">
						<?php
						$genres = [
							"Action", "Adult Cast", "Adventure", "Anthropomorphic", "Avant Garde", "Award Winning", "Cgdct", "Childcare", 
							"Combat Sports", "Comedy", "Crossdressing", "Delinquents", "Detective", "Drama", "Ecchi", "Educational", 
							"Erotica", "Fantasy", "Gag Humor", "Gore", "Gourmet", "Harem", "High Stakes Game", "Historical", "Horror", 
							"Idols Female", "Idols Male", "Isekai", "Iyashikei", "Josei", "Kids", "Love Polygon", "Magical Sex Shift", 
							"Mahou Shoujo", "Martial Arts", "Mecha", "Medical", "Military", "Music", "Mystery", "Mythology", 
							"Organized Crime", "Otaku Culture", "Parody", "Performing Arts", "Pets", "Psychological", "Racing", 
							"Reincarnation", "Reverse Harem", "Romance", "Romantic Subtext", "Samurai", "School", "Sci-Fi", "Shoujo", 
							"Seinen", "Shounen", "Showbiz", "Slice Of Life", "Space", "Sports", "Strategy Game", "Super Power", 
							"Supernatural", "Survival", "Suspense", "Team Sports", "Time Travel", "Vampire", "Video Game", "Visual Arts", 
							"Workplace"
						];
						echo '<div class="genresgrid form-check">';

						foreach ($genres as $genre) {
							$id = 'gen-' . str_replace(' ', '', $genre); 
							echo '<div>';
							echo '<input class="form-check-input" type="checkbox" id="' . $id . '" value="' . $genre . '">';
							echo '<label class="form-check-label" for="' . $id . '">' . $genre . '</label>';
							echo '</div>';
						}
						echo '</div>';
						?>
					</div>
					<button type="button" id="expandbtn" class="btn btn-secondary btn-sm btn-lg btn-block">
						<i class="glyphicon glyphicon-menu-down"></i>
					</button>
				</div>
				<div class="rightcard" style="display:none; border-top: 1px solid #3c3c3c;">
					<div class="flexrightcard" id="filterplace">
						<div class="halfleft">
							<label for="typeselect">Stream:</label>
							<select id="typeselect" onchange="typechange()">
								<option value="0">Any</option>
								<option value="1">GOGO Stream</option>
								<option value="11">AL Stream</option>
								<option value="6">RUSH Stream</option>
							</select>
						</div>
						<div class="halfright">
							<label for="langselect">Sub/Dub:</label>
							<select id="langselect" onchange="langchange()">
								<option value="any">Any</option>
								<option value="sub">Sub</option>
								<option value="dub">Dub</option>
							</select>
						</div>
						<div style="flex:1">
							<div id="seasonalgobtn" onclick="seasonGo()">GO</div>
						</div>
					</div>
				</div>
				<div class="rightcard" style="margin-bottom:20px">
					<div class="subtitleright">Weekly Top</div>
					<div id="ongoingplace" style="height:unset"></div>
					<button type="button" id="expandbtn2" onclick="expandweekly()" class="btn btn-secondary btn-sm btn-lg btn-block">
						<i class="glyphicon glyphicon-menu-down"></i>
					</button>
				</div>
			</div>
		</div>
		<div id="topmid"></div>
	</div>
	<div id="playerleftsidebar" class="schedulemenucontainer">
		<button id="recomendedclosebtn" style="margin-left:10px" onclick="showschedulemenu()">
			<i class="glyphicon glyphicon-arrow-left"></i>
		</button>
		<div id="seasontitle"></div>
		<div id="scheduletimezone"></div>
		<div id="recomendedlist" style="padding-top:unset"></div>
		<div id="schedulenotice">Release time is estimated</div>
	</div>
	<div class="leftbottom">
		<span id="donatelabel">RSS</span>
		<a class="customicon rssicon"></a>
		<div class="floatright">
			<div class="togglelabel">Chat</div>
			<label class="switch">
				<input type="checkbox" id="enablechat">
				<span class="slider round"></span>
			</label>
			<a style="font-size:17px;margin-left:4px">
				<i class="glyphicon glyphicon-info-sign"></i>
			</a>
			<br>
		</div>
	</div>
	<div class="footer">
		<span class="bottomtext">Watch HD Anime for Free 2024 AniMixPlay</span>
		Disclaimer: This site does not store any files on its server. All contents are provided by non-affiliated third parties.
	</div>
	<div id="notifiaction"></div>
	<div id="lastwatch">
		<i id="lastwatchclosebtn" class="glyphicon glyphicon-remove"></i>
		Continue watching :<br>
		<a id="lastwatchlink">
			<div id="lastwatchtitle"></div>
			<div id="lastwatchurl"></div>
		</a>
	</div>
</body>
</html>
