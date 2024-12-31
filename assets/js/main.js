const ANIME_TYPES = {
    ALL: 'all',
    DUB: 'dub',
    SUB: 'sub',
    MOVIE: 'movie'
};

const CONFIG = {
    itemsPerLoad: 6,
    initialOffset: 24
};

let offSet = CONFIG.initialOffset;
let currentType = ANIME_TYPES.ALL;

// Appends an anime item to the layout
function appendLayout(anime) {
    // Clean and format the title
    const cleanTitle = anime.title.replace(/[♥♡☆→()]/g, '');
    const formattedTitle = cleanTitle.toLowerCase()
        .replace(/[:+!?. ]/g, '-')
        .replace(/-+/g, '-')
        .trim()
        .replace(/^-+|-+$/g, '');

    const template = `
        <li>
            <a href="${baseUrl}watch/${formattedTitle}" data-id="${anime.id}" title="${anime.title}">
                <div class="searchimg">
                    <img 
                        alt="${anime.title} - Free Online" 
                        class="resultimg" 
                        src="${anime.poster}" 
                        loading="lazy"
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
    `;
    $('.searchresult').append(template);
}

// Displays a message for followed animes
function showFollowed() {
    $('.searchresult, #bottommsg').empty();
    $('#bottommsg').append("You have no followed animes");
}

// Fetches anime data based on the specified type
function fetchingAnimeData(type) {
    currentType = type === 'getAllAnime' ? ANIME_TYPES.ALL : 
                 type === 'getDubAnime' ? ANIME_TYPES.DUB : 
                 type === 'getSubAnime' ? ANIME_TYPES.SUB : ANIME_TYPES.MOVIE;
                 
    $('.searchresult, #bottommsg').empty();
    $('#loadingtext').show();

    $.ajax({
        url: `${baseUrl}/Home/${type}`,
        type: 'POST',
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data?.length) { 
                    console.log(data);
                    $('#loadingtext').hide();
                    data.forEach(appendLayout);
                    $('#bottommsg').append(`
                        <div id="loadmorelist"><i class="glyphicon glyphicon-menu-down"></i> Load more</div>
                    `);
                }
            } catch (error) {
                console.error('Error parsing response:', error);
                $('#loadingtext').hide();
                $('#bottommsg').append('<div class="error-message">Error loading data</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Ajax error:', error);
            $('#loadingtext').hide();
            $('#bottommsg').append('<div class="error-message">Error loading data</div>');
        }
    });
}

// Loads more anime items for pagination
function loadPagination() {
    const $loadMoreBtn = $('#loadmorelist');
    const originalText = $loadMoreBtn.html();
    $loadMoreBtn.html('<i class="glyphicon glyphicon-refresh glyphicon-spin"></i> Load More...');
    
    $.ajax({
        url: `${baseUrl}/Home/loadMore`,
        type: 'POST',
        data: { 
            offSet, 
            currentType
        },
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data?.length) {
                    data.forEach(appendLayout);
                    offSet += CONFIG.itemsPerLoad; 
                    $loadMoreBtn.html(originalText);
                } else {
                    $loadMoreBtn.html('No More Posts');
                }
            } catch (error) {
                console.error('Error parsing response:', error);
                $loadMoreBtn.html('Error loading more posts');
            }
        },
        error: function(xhr, status, error) {
            console.error('Ajax error:', error);
            $loadMoreBtn.html(originalText);
        }
    });
}

// Cleans and formats the title for URL use
function cleanTitle(title) {
    return title
        .toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s-]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

// Event listener for quick search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('q');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchQuery = this.value.trim();
            
            if (searchQuery.length === 0) {
                $('.quicksearchcontainer').hide();
                $('.quickresult').empty();
                return;
            }

            $('.quicksearchcontainer').show();
            
            if (searchQuery.length >= 2) {
                $.ajax({
                    url: `${baseUrl}Home/searchAnime`,
                    type: 'POST',
                    data: { query: searchQuery },
                    success: function(response) {
                        $('.quickresult').empty();
                        try {
                            const data = JSON.parse(response);
                            if (data?.length) {
                                data.forEach(anime => {
                                    $('.quickresult').append(`
                                        <a href="${baseUrl}watch/${cleanTitle(anime.title)}" title="${anime.title}">
                                            <li>
                                                <div class="searchimg">
                                                    <img class="resultimg2" src="${anime.poster}">
                                                </div>
                                                <div class="details">
                                                    <p class="name">${anime.title}</p>
                                                    <p class="infotext">${anime.title}<br>${anime.category}</p>
                                                </div>
                                            </li>
                                        </a>
                                    `);
                                });
                            } else {
                                $('.quickresult').append('<li>No results found</li>');
                            }
                        } catch (error) {
                            console.error('Error parsing search results:', error);
                            $('.quickresult').append('<li>Error loading results</li>');
                        }
                    },
                    error: function() {
                        $('.quickresult').empty().append('<li>Error loading results</li>');
                    }
                });
            } else {
                $('.quickresult').empty();
            }
        });
        
        // Hide the quick search container when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.quicksearchcontainer') && !e.target.closest('#searchbox')) {
                $('.quicksearchcontainer').hide();
            }
        });
    }

    // Event listener for Random button
    $(document).on('click', '.topmenubtn', function(e) {
        e.preventDefault();
        $.ajax({
            url: baseUrl + 'home/getRandomAnime',
            type: 'GET',
            success: function(response) {
                try {
                    const anime = JSON.parse(response);
                    if (anime && anime.title) {
                        const cleanedTitle = cleanTitle(anime.title);
                        console.log(cleanedTitle);
                        window.location.href = baseUrl + 'home/watch/' + cleanedTitle;
                    } else {
                        console.error('Invalid anime data received');
                    }
                } catch (error) {
                    console.error('Error parsing random anime data:', error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching random anime:', error);
            }
        });
    });

    $(document).on('click', '#loadmorelist', loadPagination);
    $('#showDub').click(() => fetchingAnimeData('getDubAnime'));
    $('#showAll').click(() => fetchingAnimeData('getAllAnime'));
    $('#showMovie').click(() => fetchingAnimeData('getMovieAnime'));
    $('#showFollowed').click(showFollowed);
});