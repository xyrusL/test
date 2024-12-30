const ITEMS_PER_LOAD = 24; // Number of items to load per request
let currentOffset = ITEMS_PER_LOAD;
let currentType = 'all'; // Tracks current view type (all, sub, dub)

function showAll() {
    currentOffset = 24;
    currentType = 'all';
    $('.searchresult').empty();
    $('#loadmorelist').hide();
    $('#loadingtext').css('display', 'block'); // Show loading

    $.ajax({
        url: baseUrl + 'Home/getAllAnime',
        type: 'POST',
        success: function(response) {
            let data =  JSON.parse(response);

            if (data) {
                data.forEach(function(anime) {
                $('.searchresult').append(`
                        <li>
                        <a href="/anime/${anime.id}" title="${anime.title}">
                            <div class="searchimg">
                                <img 
                                    alt="${anime.title} - Free Online" 
                                    class="resultimg" 
                                    src="${anime.poster}" 
                                />
                                <div class="timetext">${anime.date}</div>
                                <div class="rating"><i class="glyphicon glyphicon-star"></i> ${anime.mal_score}</div>
                            </div>
                            <div class="details">
                                <p class="name">${anime.title}</p>
                                <p class="infotext">EP ${anime.total_episodes}${anime.status === 'Finished Airing' ? '' : '/?'}</p>
                            </div>
                        </a>
                    </li>
                `);
            });
        }
        $('#loadingtext').css('display', 'none'); // Hide loading
        $('#loadmorelist').show();
    },
    error: function(xhr, status, error) {
        console.error('Error fetching anime:', error);
        $('#loadingtext').css('display', 'none'); // Hide loading on error
        $('#loadmorelist').show();
    }
    });
}

function showDub() {
    currentOffset = 24;
    currentType = 'dub';
    $('.searchresult').empty();
    $('#loadmorelist').hide();
    $('#loadingtext').css('display', 'block'); // Show loading

    $.ajax({
        url: baseUrl + 'Home/getDubAnime',
        type: 'POST',
        success: function(response) {
            let data = JSON.parse(response);
            if (data) {
                data.forEach(function(anime) {
                    $('.searchresult').append(`
                        <li>
                            <a href="/anime/${anime.id}" title="${anime.title}">
                                <div class="searchimg">
                                    <img 
                                        alt="${anime.title} - Free Online" 
                                        class="resultimg" 
                                        src="${anime.poster}" 
                                    />
                                    <div class="timetext">${anime.date}</div>
                                    <div class="rating"><i class="glyphicon glyphicon-star"></i> ${anime.mal_score}</div>
                                </div>
                                <div class="details">
                                    <p class="name">${anime.title}</p>
                                    <p class="infotext">EP ${anime.total_episodes}${anime.status === 'Finished Airing' ? '' : '/?'}</p>
                                </div>
                            </a>
                        </li>
                    `);
                });
            }
            $('#loadingtext').css('display', 'none'); // Hide loading
            $('#loadmorelist').show();
        },
        error: function(xhr, status, error) {
            console.error('Error fetching dubbed anime:', error);
            $('#loadingtext').css('display', 'none'); // Hide loading on error
            $('#loadmorelist').show();
        }
    });
}

function showSub() {
    currentOffset = 24;
    currentType = 'sub';
    $('.searchresult').empty();
    $('#loadmorelist').hide();
    $('#loadingtext').css('display', 'block'); // Show loading

    $.ajax({
        url: baseUrl + 'Home/getSubAnime',
        type: 'POST',
        success: function(response) {
            let data = JSON.parse(response);
            if (data) {
                data.forEach(function(anime) {
                    $('.searchresult').append(`
                        <li>
                            <a href="/anime/${anime.id}" title="${anime.title}">
                                <div class="searchimg">
                                    <img 
                                        alt="${anime.title} - Free Online" 
                                        class="resultimg" 
                                        src="${anime.poster}" 
                                    />
                                    <div class="timetext">${anime.date}</div>
                                    <div class="rating"><i class="glyphicon glyphicon-star"></i> ${anime.mal_score}</div>
                                </div>
                                <div class="details">
                                    <p class="name">${anime.title}</p>
                                    <p class="infotext">EP ${anime.total_episodes}${anime.status === 'Finished Airing' ? '' : '/?'}</p>
                                </div>
                            </a>
                        </li>
                    `);
                });
            }
            $('#loadingtext').css('display', 'none'); // Hide loading
            $('#loadmorelist').show();
        },
        error: function(xhr, status, error) {
            console.error('Error fetching subbed anime:', error);
            $('#loadingtext').css('display', 'none'); // Hide loading on error
            $('#loadmorelist').show();
        }
    });
}

// Add new function to load more items
function loadMore() {
    const $loadMoreBtn = $('#loadmorelist');
    const originalText = $loadMoreBtn.html();
    
    // Show loading text
    $loadMoreBtn.html('<i class="glyphicon glyphicon-refresh"></i> Loading...');
    
    $.ajax({
        url: baseUrl + 'Home/loadMore',
        type: 'POST',
        data: {
            offset: currentOffset,
            type: currentType
        },
        success: function(response) {
            let data = JSON.parse(response);
            if (data && data.length > 0) {
                data.forEach(function(anime) {
                    $('.searchresult').append(`
                        <li>
                            <a href="/anime/${anime.id}" title="${anime.title}">
                                <div class="searchimg">
                                    <img 
                                        alt="${anime.title} - Free Online" 
                                        class="resultimg" 
                                        src="${anime.poster}" 
                                    />
                                    <div class="timetext">${anime.date}</div>
                                    <div class="rating"><i class="glyphicon glyphicon-star"></i> ${anime.mal_score}</div>
                                </div>
                                <div class="details">
                                    <p class="name">${anime.title}</p>
                                    <p class="infotext">EP ${anime.total_episodes}${anime.status === 'Finished Airing' ? '' : '/?'}</p>
                                </div>
                            </a>
                        </li>
                    `);
                });
                currentOffset += ITEMS_PER_LOAD;
                
                // Restore original text
                $loadMoreBtn.html(originalText);
                
                // Hide button if no more results
                if (data.length < ITEMS_PER_LOAD) {
                    $loadMoreBtn.hide();
                }
            } else {
                $loadMoreBtn.hide();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading more anime:', error);
            // Restore original text on error
            $loadMoreBtn.html(originalText);
        }
    });
}

// Add click handlers
$('#showSub').click(showSub);
$('#showDub').click(showDub);
$('#showAll').click(showAll);

// Add click handler for load more button
$('#loadmorelist').click(loadMore);