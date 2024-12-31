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
                <a id="animebtn" href="/anime/<?php echo $anime->id; ?>" style="display: inline;">
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
                <button class="playbutton btn btn-primary">1</button>
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