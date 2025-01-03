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

function expandGenre() {
    const $genreplace = $('#genreplace');
    const $expandBtn = $('#expandbtn i');
    
    const isExpanded = $genreplace.height() === 872;
    $genreplace.css('height', isExpanded ? '205px' : '872px');
    $expandBtn.toggleClass('glyphicon-menu-up glyphicon-menu-down');
}

function expandAnnouncement() {
    const $announcement = $('#announcement');
    const $expandBtn = $('#readmorebtn i');
    
    const isExpanded = $announcement.height() > 100;
    $announcement.animate({ height: isExpanded ? '48px' : '214px' });
    $expandBtn.toggleClass('glyphicon-menu-up glyphicon-menu-down');
}

function appendLayout(anime) {
    const cleanTitle = anime.title.replace(/[♥♡☆→()]/g, '');
    const formattedTitle = cleanTitle.toLowerCase()
        .replace(/[:+!?. ]/g, '-')
        .replace(/-+/g, '-')
        .trim()
        .replace(/^-+|-+$/g, '');

    const watchUrl = baseUrl + 'watch/' + formattedTitle;

    const template = `
        <li>
            <a href="${watchUrl}" data-id="${anime.id}" title="${anime.title}">
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

function showFollowed() {
    $('.searchresult, #bottommsg').empty();
    $('#loadingtext').show();
    
    const followedByUser = localStorage.getItem('followedByUser');

    if (!followedByUser || JSON.parse(followedByUser).length === 0) {
        $('#loadingtext').hide();
        $('#bottommsg').append("You have no followed animes");
        return;
    }

    const followedIds = JSON.parse(followedByUser);
    let loadedCount = 0;

    followedIds.forEach(id => {
        $.ajax({
            url: `${baseUrl}/api/getAnimeById`,
            type: 'POST',
            data: { id },
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    if (data) {
                        appendLayout(data);
                    }
                } catch (error) {
                    console.error('Error parsing response:', error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            },
            complete: function() {
                loadedCount++;
                if (loadedCount === followedIds.length) {
                    $('#loadingtext').hide();
                }
            }
        });
    });
}

function fetchingAnimeData(type) {
    currentType = type === 'getAllAnime' ? ANIME_TYPES.ALL : 
                  type === 'getDubAnime' ? ANIME_TYPES.DUB : 
                  type === 'getSubAnime' ? ANIME_TYPES.SUB : ANIME_TYPES.MOVIE;
                 
    $('.searchresult, #bottommsg').empty();
    $('#loadingtext').show();

    $.ajax({
        url: `${baseUrl}/api/${type}`,
        type: 'POST',
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data?.length) { 
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

function loadPagination() {
    const $loadMoreBtn = $('#loadmorelist');
    const originalText = $loadMoreBtn.html();
    $loadMoreBtn.html('<i class="glyphicon glyphicon-refresh glyphicon-spin"></i> Load More...');
    
    $.ajax({
        url: `${baseUrl}/home/loadMore`,
        type: 'POST',
        data: { offSet, currentType },
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

function cleanTitle(title) {
    return title
        .toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s-]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

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
                    url: `${baseUrl}api/searchAnime`,
                    type: 'POST',
                    data: { query: searchQuery },
                    success: function(response) {
                        $('.quickresult').empty();
                        try {
                            const data = JSON.parse(response);
                            if (data?.length) {
                                data.forEach(anime => {
                                    const watchUrl = baseUrl + 'watch/' + cleanTitle(anime.title);
                                    $('.quickresult').append(`
                                        <a href="${watchUrl}" title="${anime.title}">
                                            <li>
                                                <div class="searchimg">
                                                    <img class="resultimg2" src="${anime.poster}" alt="${anime.title}">
                                                </div>
                                                <div class="details">
                                                    <p class="name">${anime.title}</p>
                                                    <p class="infotext">${anime.category}</p>
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
        
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.quicksearchcontainer') && !e.target.closest('#searchbox')) {
                $('.quicksearchcontainer').hide();
            }
        });
    }

    $(document).on('click', '.topmenubtn', function(e) {
        e.preventDefault();
        $.ajax({
            url: `${baseUrl}api/getRandomAnime`,
            type: 'GET',
            success: function(response) {
                try {
                    const anime = JSON.parse(response);
                    if (anime && anime.title) {
                        const cleanedTitle = cleanTitle(anime.title);
                        const watchUrl = baseUrl + 'watch/' + cleanedTitle;
                        window.location.href = watchUrl;
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

    $('#expandbtn').click(expandGenre);
    $('#readmorebtn').click(expandAnnouncement);
});