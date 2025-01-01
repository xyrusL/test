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

function initializeFirstLoad() {
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
                checkPlayer(data.url);
                saveLastWatched(episodeIndex, animeId);
            } else {
                console.error('Episode URL not found');
            }

            setTimeout(() => $('#loadcontainer2').hide(), 1000);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching episode:', error);
        }
    });
}

function checkPlayer(url) {
    const container = $('#iframecontainer');
    
    if (url.includes('archive.org')) {
        $('.altsourcenotif').text('Internal Player');
        container.empty();

        const video = $('<video>', { controls: true, playsinline: true })
            .append($('<source>', { src: url, type: 'video/mp4' }));
        container.append($('<div>', { id: 'iframeplayer' }).append(video));
        new Plyr(video[0]);
    } else {
        if (url.includes('blogspot.com')) {
            $('#iframeplayer').attr('src', url);
        }

    }

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
initializeFirstLoad();

$('#widescreenbtn').click(function() {
    const iframe = $('#iframeplayer');
    const btn = $(this);
    const isFixed = iframe.css('position') === 'fixed';

    iframe.css({
        'position': isFixed ? '' : 'fixed',
        'top': isFixed ? '' : '0px',
        'left': isFixed ? '' : '0px',
        'height': isFixed ? '' : '100%',
        'width': isFixed ? '' : '100%',
        'z-index': isFixed ? '' : '999',
        'text-align': isFixed ? '' : 'center',
        'background-color': isFixed ? '' : 'rgb(23, 23, 23)'
    });

    btn.css({
        'position': isFixed ? '' : 'fixed',
        'bottom': isFixed ? '' : '0px',
        'right': isFixed ? '' : '-10px',
        'z-index': isFixed ? '' : '1000',
        'display': isFixed ? '' : 'block',
        'padding': isFixed ? '' : '6px 10px',
        'background-color': isFixed ? '' : 'rgb(34, 34, 34)',
        'color': isFixed ? '' : 'rgb(255, 110, 110)'
    });

    btn.children('i').attr('class', isFixed ? 'glyphicon glyphicon-fullscreen' : 'glyphicon glyphicon-remove');
});