let itemsPerLoad = 6;
let offSet = 24;
let currentType = 'all';

function appendLayout(anime) {
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
}

function fetchingAnimeData(type) {
    currentType = type === 'getAllAnime' ? 'all' : (type === 'getDubAnime' ? 'dub' : (type === 'getSubAnime' ? 'sub' : 'movie'));
    $('#loadmorelist').html('<i class="glyphicon glyphicon-menu-down"></i> Load More');

    $.ajax({
        url: `${baseUrl}/Home/${type}`,
        type: 'POST',
        success: function(response) {
            let data = JSON.parse(response);
            if (data) {
                $('.searchresult').empty(); 
                $('#loadmorelist').hide();
                $('#loadingtext').css('display', 'block');
                
                data.forEach(anime => appendLayout(anime));
            }
            $('#loadingtext').css('display', 'none');
            $('#loadmorelist').show();
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
            offSet: offSet, 
            currentType: currentType
        },
        success: function(response) {
            let data = JSON.parse(response);

            console.log(data);
            
            if (data && data.length > 0) {
                data.forEach(anime => appendLayout(anime));
                offSet += itemsPerLoad; 
            } else {
                $loadMoreBtn.html('No More Posts');
            }
        },
        error: function(error) {
            console.log("Error: ", error);
            $loadMoreBtn.html(originalText);
        }
    });
}

$('#showDub').click(() => fetchingAnimeData('getDubAnime'));
$('#showAll').click(() => fetchingAnimeData('getAllAnime'));
$('#showMovie').click(() => fetchingAnimeData('getMovieAnime'));
$('#loadmorelist').click(loadPagination);