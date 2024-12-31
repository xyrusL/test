let previousButton;
const lastTime = JSON.parse(localStorage.getItem('lastTime')) || {};
const animeId = $('#animebtn').data('id');

if (!lastTime[animeId]) {
    previousButton = $('.playbutton').first().prop('disabled', true);
} else {
    previousButton = $(`.playbutton:eq(${lastTime[animeId]})`).prop('disabled', true);
}

$('.playbutton').on('click', function() {
    const episodeNumber = $(this).text();
    const episodeIndex = $(this).index();
    
    getEpisodes(episodeIndex, animeId);
    if (previousButton) {
        previousButton.prop('disabled', false);
    }
    $(this).prop('disabled', true);
    previousButton = $(this);
    saveLastWatched(episodeIndex, animeId);
});

function getEpisodes(episodeIndex, animeId) {
    $.ajax({
        url: `${baseUrl}home/getEpisodeUrl`,
        method: 'POST',
        data: { anime_id: animeId, episode_index: episodeIndex },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.url) {
                $('#iframeplayer').attr('src', data.url);
                saveLastWatched(episodeIndex, animeId);
            } else {
                console.error('Episode URL not found');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching episode:', error);
        }
    });
}

function saveLastWatched(index, id) {
    const lastTime = JSON.parse(localStorage.getItem('lastTime')) || {};
    lastTime[id] = index;
    localStorage.setItem('lastTime', JSON.stringify(lastTime));
}

function handleBackNavigation() {
    window.addEventListener('popstate', function(event) {
        window.location.href = '/test';
    });

    history.pushState(null, '', window.location.href);
}

handleBackNavigation();