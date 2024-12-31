let previousButton;
const lastTime = JSON.parse(localStorage.getItem('lastTime')) || {};
const animeId = $('#animebtn').data('id');

function initializePreviousButton(animeId, lastTime) {
    if (!lastTime[animeId]) {
        return $('.playbutton').first().prop('disabled', true);
    } else {
        return $(`.playbutton:eq(${lastTime[animeId]})`).prop('disabled', true);
    }
}

$('.playbutton').on('click', function() {
    const episodeIndex = $(this).index();
    
    getEpisodes(episodeIndex, animeId);
    if (previousButton) {
        previousButton.prop('disabled', false);
    }
    $(this).prop('disabled', true);
    previousButton = $(this);
    saveLastWatched(episodeIndex, animeId);
});

function appendPlayer() {

    const episodeIndex = lastTime[animeId] || 0;
    getEpisodes(episodeIndex, animeId);
}

function getEpisodes(episodeIndex, animeId) {
    $('#loadcontainer2').show();
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

            $('#loadcontainer2').hide();
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
previousButton = initializePreviousButton(animeId, lastTime);
appendPlayer();