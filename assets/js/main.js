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

function appendLayout(anime) {
    // Clean title for URL - match PHP version
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

function showFollowed() {
    $('.searchresult, #bottommsg').empty();
    $('#bottommsg').append("You have no followed animes");
}

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


$(document).on('click', '#loadmorelist', loadPagination);
$('#showDub').click(() => fetchingAnimeData('getDubAnime'));
$('#showAll').click(() => fetchingAnimeData('getAllAnime'));
$('#showMovie').click(() => fetchingAnimeData('getMovieAnime'));
$('#showFollowed').click(showFollowed);