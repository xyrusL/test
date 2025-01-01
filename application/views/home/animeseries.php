<head>
    <title><?php echo $title; ?></title>

    <!--fonts-->
	<link href='https://fonts.googleapis.com' rel='preconnect'/>
	<link crossorigin='' href='https://fonts.gstatic.com' rel='preconnect'/>
	<link href='https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&family=Lexend:wght@100..900&family=Lexus+Sans+Serif:wght@300;400;700&display=swap' rel='stylesheet'/>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/plyr@3.7.8/dist/plyr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/plyr@3.7.8/dist/plyr.min.js"></script>
    <script>
        let baseUrl = '<?php echo base_url(); ?>';
    </script>
    <script src="<?php echo base_url('assets/js/player.js'); ?>" defer></script>
</head>

<body>
    <div id="coverlight" style="z-index:8"></div>
    <div id="loadcontainer" style="display: none;">
        <div class="loadindicator"></div>
    </div>
    
    <div class="toppart">
        <h1 style="display:none;">Watch anime online animixplay</h1>
        <div id="songContent" class="floattopsearch">
            <a id="backiconhome"><i class="glyphicon glyphicon-chevron-left"></i></a>
            <a id="homeicon" href="http://localhost/test/"><i class="glyphicon glyphicon-home"></i></a>
            <div id="searchbox">
                <input type="text" style="display:none">
                <input type="password" style="display:none">
                <a href="http://localhost/test/"><img class="webtitle" alt="AnimixPlay" src="http://localhost/test/assets/logo.png"></a>
                <input class="form-control searchbar" placeholder="Search" autocomplete="off" id="q" type="search">
                <button id="searchbutton"><i class="glyphicon glyphicon-search"></i></button>
                <a class="topmenubtn" title="Random anime" href=""><i class="glyphicon glyphicon-random"></i> Random</a>
                <a class="topmenubtn" title="A-Z List" href="">A-Z List</a>
            </div>
            <span id="usernametop"></span>
            <button id="menumobilebtn"><i class="glyphicon glyphicon-menu-hamburger"></i></button>
            <button id="showsearchbtn"><i class="glyphicon glyphicon-search"></i></button>
        </div>
    </div>

    <div class="playersidebar">
        <div style="border: 1px solid #2a2a 2a;">
            <i class="closebtn glyphicon glyphicon-remove" id="menuclose" onclick="showmobilemenu()"></i>
            <div class="rightcard">
                <div class="loadingreplacement" style="display: none;">Loading...</div>
                <div class="usercard" style="display: block;">
                    <div id="userpanel">
                        <span class="usernameplace"></span>
                        <span id="premiumcrown"></span>
                        <br><br>
                        <div id="iconmenu">
                            <a class="linkpersonal glyphicon glyphicon-th-list" href="/user/">
                                <br>
                                <span class="subtextmenuicon">User Panel</span>
                            </a>
                            <i class="autotrackbtn glyphicon glyphicon-refresh" onclick="autotrackbtnclick();">
                                <br>
                                <span class="subtextmenuicon">Autotracking</span>
                            </i>
                            <i class="glyphicon glyphicon-off" onclick="logout();">
                                <br>
                                <span class="subtextmenuicon">Logout</span>
                            </i>
                            <a class="linkhome glyphicon glyphicon-search" href="/">
                                <br>
                                <span class="subtextmenuicon">Explore</span>
                            </a>
                            <i class="linkhome glyphicon glyphicon-lock" onclick="openchangepass();">
                                <br>
                                <span class="subtextmenuicon">Account</span>
                            </i>
                            <i class="linkhome glyphicon glyphicon-wrench" onclick="openpremiumpanel();">
                                <br>
                                <span class="subtextmenuicon">Settings</span>
                            </i>
                        </div>
                        <div id="logoutmsg"></div>
                    </div>
                    <div id="loginform" style="display: block;">
                        <div class="flexrightcard">
                            <div class="halfleft">
                                <input class="logininput" placeholder="Username" id="username" type="text" autocomplete="username">
                                <input class="logininput" placeholder="Password" id="password" type="password" autocomplete="current-password">
                                <input type="checkbox" value="" id="rememberme" checked="">
                                <label class="form-check-label rememberlabel" for="rememberme">Remember me</label>
                            </div>
                            <div class="halfright">
                                <div class="loginbtn" onclick="login();">Login</div>
                                <a class="openregisterbtn" onclick="openregister();">Register</a>
                            </div>
                        </div>
                        <div id="statuslogin"></div>
                    </div>
                    <form id="registerform">
                        <a class="openloginbtn" onclick="backlogin();">&lt; back</a>
                        <br><br>
                        <span id="alretinfo">Note: we don't use email (no reset password), please use password manager so you not forget</span>
                        <div id="formregister">
                            <input class="logininput" placeholder="Username" id="usernameregis" type="text" autocomplete="off">
                            <div class="formsubtext">letters/numbers/_.-| max 25 chars</div>
                            <input class="logininput" placeholder="Password" id="passwordregis" type="password" autocomplete="off">
                            <div class="formsubtext">any 4 - 200 chars</div>
                            <input class="logininput" placeholder="Confirm Password" id="confirm" type="password" autocomplete="off">
                            <div class="formsubtext">retype password</div>
                            <div class="g-recaptcha" data-theme="dark" data-sitekey="6LdyotYjAAAAAGg2NNTePg3ocVVY6Xpd1jne5F5o"></div>
                        </div>
                        <div id="statusregister"></div>
                        <div class="registerbtn" onclick="register();">Register</div>
                    </form>
                    <div id="gsignsection" style="display: block;">
                        <br>
                        <div class="subtitleright" style="border-bottom:none"></div>
                        <div id="gconnectbtn">
                            <img id="gconnectbtnimg" onclick="connectGoogle()" src="/assets/imgs/gsign.jpg">
                        </div>
                    </div>
                    <div id="changepassform">
                        <a class="openloginbtn" onclick="backlogin2();">Back</a>
                        <br><br><br><br><br>
                        <span id="alretinfo">Account setting moved to <a id="accountmovelink" href="/user/?openmenu=yes">User Panel</a>.</span>
                        <br><br><br>
                    </div>
                    <div id="premiumpanel">
                        <a class="openloginbtn" onclick="backlogin3();">Back</a>
                        <br><br>
                        <span id="premiumnotice">This set default setting on page loads.</span>
                        <div id="iconmenu">
                            <i class="glyphicon glyphicon-bullhorn" id="toggleadbtn" onclick="toggleAds();">
                                <br>
                                <span class="subtextmenuicon">Ads</span>
                            </i>
                            <i class="glyphicon glyphicon-subtitles" id="preferbtn" onclick="togglePreferSub();">
                                <br>
                                <span class="subtextmenuicon">Default</span>
                            </i>
                            <i class="glyphicon glyphicon-sunglasses" id="autolightsbtn" onclick="toggleAutoLightoff();">
                                <br>
                                <span class="subtextmenuicon">Auto Lights</span>
                            </i>
                            <i class="glyphicon glyphicon-flash" id="userautoplaybtn" onclick="toggleDefaultAutoplay();">
                                <br>
                                <span class="subtextmenuicon">Default</span>
                            </i>
                            <i class="glyphicon glyphicon-time" id="autoplaybackbtn" onclick="shownotif('Playback save is always on');">
                                <br>
                                <span class="subtextmenuicon">Playback</span>
                            </i>
                            <i class="glyphicon glyphicon-comment" id="autocommentbtn" style="color:gray" onclick="toggleAutoComment();">
                                <br>
                                <span class="subtextmenuicon">Autoload</span>
                            </i>
                        </div>
                        <div id="logoutmsg"></div>
                    </div>
                </div>
            </div>
            <div class="rightcardCenter" id="manualTrackingCard">
                <div class="subtitleright" id="trackingTitle">Sengoku Youko: Senma Konton-hen</div>
                <span id="watchingstatus">Status : Watching</span>
                <div onclick="deleteanime(this)" id="untrackbtn">Untrack <i class="glyphicon glyphicon-remove"></i></div>
                <select id="manualTrackingSelect">
                    <option value="Watching">Watching</option>
                    <option value="Planned">On-Hold</option>
                    <option value="PTW">Plan to Watch</option>
                    <option value="Finished">Finished</option>
                </select>
                <div class="flexrightcard">
                    <div class="halfleft2">
                        Current : <div id="progressnumber">22</div>
                    </div>
                    <div class="halfright">
                        Tracked : <div id="tracknumber"></div>
                    </div>
                </div>
                <button id="manualtrackbtn" onclick="startTrack();" style="cursor: pointer; opacity: 1;">Start tracking</button>
            </div>
            <div id="infocard" style="display:none" class="rightcard"></div>
        </div>
    </div>
    <div id="playerleftsidebar"></div>
    <div class="playerpage" style="background-color: rgb(35, 35, 35);">
        <div class="subpart eptitle">
            <div id="eptitle">
                <span id="eptitleplace">EP ?</span>
                <span class="altsourcenotif">External Player</span>
            </div>
            <div id="toprightplayer">
                <i onclick="switchToLive();" class="proxybtn glyphicon glyphicon glyphicon-transfer" style="color: white;">
                    <span class="tooltiptext">Switch</span>
                </i>
                <i onclick="lighttoggle();" class="lightbtn glyphicon glyphicon-sunglasses">
                    <span class="tooltiptext">Lights</span>
                </i>
                <i onclick="download();" class="dlbutton glyphicon glyphicon-download-alt">
                    <span class="tooltiptext">Download</span>
                </i>
                <i onclick="toggleautoplay();" class="autoplaybutton glyphicon glyphicon-flash">
                    <span class="tooltiptext">Autoplay</span>
                </i>
                <i onclick="playnext()" id="nextbtn" class="glyphicon glyphicon-forward" style="cursor: pointer;">
                    <span class="tooltiptext">Next ep</span>
                </i>
            </div>
        </div>
        <div id="loadcontainer2" style="display: block; overflow: hidden;">
            <div class="loadindicator"></div>
        </div>
        <div id="iframecontainer">
            <iframe id="iframeplayer" allowfullscreen="true"  sandbox="allow-scripts allow-same-origin" scrolling="no" src="" style="min-height: 0px;"></iframe>
        </div>
        <select id="srcselect" onchange="srcChange()" style="display: none;"></select>
        <div id="lowerplayerpage">
            <div id="aligncenter">
                <div id="streamtypecontainer">
                    <div id="streamtype">VideoStream</div>
                    <div id="showrecomendbtn" style="display: inline-block;">
                        <i class="glyphicon glyphicon-cog"></i>
                        <span id="changetext">Change</span>
                    </div>
                    <div id="sharebtn">
                        <i class="glyphicon glyphicon-share-alt"></i>
                        <span id="shareText" style="display: inline;">Share</span>
                    </div>
                    <div id="openreport" style="display: block;">
                        <i class="glyphicon glyphicon-exclamation-sign"></i>
                        <span class="reportText">Report</span>
                    </div>
                    <div id="reloadbtn" style="display: block;">
                        <i class="glyphicon glyphicon-repeat"></i>
                        <span class="reportText">Reload</span>
                    </div>
                    <div id="widescreenbtn">
                        <i class="glyphicon glyphicon-fullscreen"></i>
                    </div>
                </div>
                <a id="animebtn" data-id="<?php echo $anime->id; ?>" style="display: inline;">
                    <svg stroke="currentColor" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="25" width="25" id="foldersvg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path>
                    </svg>
                </a>
                <span class="animetitle"><?php echo $title; ?></span>
                <button id="trackbtn">
                    <i class="glyphicon glyphicon-plus"></i> Watchlist
                </button>
                <button id="followbtn" style="display: inline;">
                    <i class="glyphicon glyphicon-bell"></i> Follow
                </button>
                <br>
                <div id="animeimage"></div>
                <span id="notice" style="display: none;">
                    <br><br><br>Try clear cache &amp; make sure your browser extension not block javascript<br><br><br>
                </span>
            </div>
            <div id="epslistplace" style="display: grid;">
                <?php for ($i = 1; $i <= $episode_count; $i++): ?>
                    <button class="playbutton btn btn-primary"><?php echo $i; ?></button>
                <?php endfor; ?>
            </div>
            <div id="flexbottom" style="display: flex;">
                <div id="bottomleft">
                    <span id="genres">Genres: <?php echo $genres; ?></span>
                    <br>
                    <span id="status">Status: <?php echo $status; ?></span>
                    <span id="animeinfobottom" style="display: block;">
                        <a id="animebtn2">More info</a>
                    </span>
                    <br>
                    <span id="status" class="scrollable"></span>
                </div>
                <div class="epsavailable">
                    Ep total: <span id="epsavailable"><?php echo $total_episodes; ?></span>
                    <a id="updatebtn">
                        <i class="glyphicon glyphicon-refresh"></i>
                    </a>
                    <div id="playercountdown">Unknown</div>
                </div>
            </div>
        </div>
    </div>
    <div id="flexstreambottom">
        <div style="flex:1">
            <div id="disquscommentnew" style="display: block;">
                <button id="showcommentbtn" onclick="showcomment()">Show 0 Comments</button>
                <div id="disqus_thread"></div>
            </div>
            <div id="belowcomment"></div>
        </div>
        <div id="streambottomright"></div>
    </div>
    <div id="belowbox"></div>
    <div id="notifiaction">Test</div>
</body>