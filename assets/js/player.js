let previousButton;
const lastTime = JSON.parse(localStorage.getItem('lastTime')) || {};
const animeId = $('#animebtn').data('id');

// Initialize the previous button based on the last watched episode
function initializePreviousButton(animeId, lastTime) {
    if (!lastTime[animeId]) {
        return $('.playbutton').first().prop('disabled', true);
    } else {
        return $(`.playbutton:eq(${lastTime[animeId]})`).prop('disabled', true);
    }
}

// Event listener for episode buttons
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

// Initialize the first load of the player
function initializeFirstLoad() {
    const episodeIndex = lastTime[animeId] || 0;
    $('#eptitleplace').text(`EP ${episodeIndex + 1}`);
    getEpisodes(episodeIndex, animeId);
}

// Fetch episode data from the server
function getEpisodes(episodeIndex, animeId) {
    $('#loadcontainer2').show();
    $.ajax({
        url: `${baseUrl}home/getEpisodeUrl`,
        method: 'POST',
        data: { anime_id: animeId, episode_index: episodeIndex },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.url) {
                $('#eptitleplace').text(`EP ${episodeIndex + 1}`);
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

// Check and set up the appropriate player based on the URL
function checkPlayer(url) {
    const container = $('#iframecontainer');
    const frame = $('#iframeplayer');
    const player = $('.altsourcenotif');
    const typeStream = $('#streamtype');

    container.empty();

    if (url.includes('archive.org')) {
        player.text('Internal Player');
        typeStream.text('Malupet Stream');

        const video = $('<video>', { controls: true, playsinline: true })
            .append($('<source>', { src: url, type: 'video/mp4' }));
        container.append($('<div>', { id: 'iframeplayer' }).append(video));
        new Plyr(video[0]);
    } else {
        if (url.includes('short')) {
            player.text('External Player (Ads)');
            typeStream.text('Video Stream');
        } else {
            player.text('External Player');

            if (url.includes('gdrive')) {
                typeStream.text('Gdrive Stream');
            } else if (url.includes('blogspot')) {
                typeStream.text('Blog Stream');
            } else if (url.includes('terabox')) {
                typeStream.text('Terabox Stream');
            }
        }
        container.append(`
            <iframe allowfullscreen='true' id="iframeplayer" sandbox="allow-scripts allow-same-origin" scrolling='no' src='${url}'/>
        `);
    }
}

// Save the last watched episode to local storage
function saveLastWatched(index, id) {
    const lastTime = JSON.parse(localStorage.getItem('lastTime')) || {};
    lastTime[id] = index;
    localStorage.setItem('lastTime', JSON.stringify(lastTime));
}

// Handle back navigation
function handleBackNavigation() {
    window.addEventListener('popstate', function(event) {
        window.location.href = '/test';
    });

    history.pushState(null, '', window.location.href);
}

// Event listener for widescreen button
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

handleBackNavigation();
initializeFirstLoad();
previousButton = initializePreviousButton(animeId, lastTime);