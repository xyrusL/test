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
$('.playbutton').on('click', function () {
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
    const followedByUser = localStorage.getItem('followedByUser');
    
    if (followedByUser) {
        const followed = JSON.parse(followedByUser);
        if (followed.includes(animeId)) {
            $('#followbtn').html('<i class="glyphicon glyphicon-bell"></i> Followed');
        } 
    }

    const episodeIndex = lastTime[animeId] || 0;
    $('#eptitleplace').text(`EP ${episodeIndex + 1}`);
    getEpisodes(episodeIndex, animeId);
}

// Fetch episode data from the server
function getEpisodes(episodeIndex, animeId) {
    $('#loadcontainer2').show();
    $.ajax({
        url: `${baseUrl}api/getEpisodeUrl`,
        method: 'POST',
        data: { anime_id: animeId, episode_index: episodeIndex },
        success: function (response) {
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
        error: function (xhr, status, error) {
            console.error('Error fetching episode:', error);
        }
    });
}

// Check and set up the appropriate player based on the URL
function checkPlayer(url) {
    const container = $('#iframecontainer');
    const player = $('.altsourcenotif');
    const typeStream = $('#streamtype');

    container.empty();

    if (url.includes('archive.org')) {
        player.text('Internal Player');
        typeStream.text('Malupet Stream');


        const video = $('<video>', { id: 'videoPlayer', controls: true, playsinline: true })
            .append($('<source>', { src: url, type: 'video/mp4' }));
        container.append($('<div>', { id: 'iframeplayer' }).append(video));
        new Plyr('#videoPlayer');
    } else {
        if (url.includes('short')) {
            player.text('External Player (Ads)');
            typeStream.text('Video Stream');
        } else {
            player.text('External Player');

            if (url.includes('gdrive')) {
                typeStream.text('Gdrive Stream');
            } else if (url.includes('blogger')) {
                typeStream.text('Blog Stream');
            } else if (url.includes('terabox')) {
                typeStream.text('Terabox Stream');
            } else if (url.includes('youtube')) {
                typeStream.text('YouTube Stream');
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

let reloadCanClick = true;
let downloadCanClick = true;
let reloadCooldownTimer, downloadCooldownTimer;

// Function to handle notifications with cooldown
function popNotif(buttonType, time, message) {
    const notif = $('#notifiaction');
    const waitingTime = 8000;

    notifPop = (message) => {
        notif.text(message);
        notif.fadeIn(500);
        setTimeout(() => {
            notif.fadeOut(500);
        }, time);
    };

    if (buttonType === 'reload') {
        if (reloadCanClick) {
            notifPop(message);
            reloadCanClick = false;

            reloadCooldownTimer = setInterval(() => {
                reloadCanClick = true;
                clearInterval(reloadCooldownTimer);
            }, waitingTime);
        } else {
            notifPop("Don't spam click!");
        }
        return reloadCanClick;
    }

    if (buttonType === 'download') {
        if (downloadCanClick) {
            notifPop(message);
            downloadCanClick = false;

            downloadCooldownTimer = setInterval(() => {
                downloadCanClick = true;
                clearInterval(downloadCooldownTimer);
            }, waitingTime);
        } else {
            notifPop("Don't spam click!");
        }
        return downloadCanClick;
    }
}

// Handle back navigation
function handleBackNavigation() {
    window.addEventListener('popstate', function (event) {
        window.location.href = '/test';
    });

    history.pushState(null, '', window.location.href);
}

// Event listener for widescreen button
$('#widescreenbtn').click(function () {
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


// Event listener for light toggle
$('#lighttoggleBtn').click(() => {
    const player = $('#iframeplayer');
    if (player.css('position') === 'relative') {
        $('#coverlight').fadeOut(400, function () {
            player.css({
                'min-height': '',
                'z-index': '',
                'position': ''
            });
            $('#toprightplayer').css({
                'z-index': '',
                'position': ''
            });
        });
    } else {
        $('#coverlight').fadeIn(400);
        player.css({
            'min-height': '0px',
            'z-index': '22',
            'position': 'relative'
        });
        $('#toprightplayer').css({
            'z-index': '22',
            'position': 'relative'
        })
    }
});


// Event listener for download button
$('#downloadBtn').click(function () {
    const isIframe = $('#iframeplayer').is('iframe');
    const streamType = $('#streamtype').text().trim();
    const videoUrl = $('#videoPlayer').find('source').attr('src');
    const time = 1500;

    if (downloadCanClick) {
        if (isIframe && ['Gdrive', 'Terabox'].some(type => streamType.includes(type))) {
            setTimeout(() => {
                window.open($('#iframeplayer').attr('src'), '_blank');
            }, time);
        } else {
            setTimeout(() => {
                window.open(videoUrl, '_blank');
            }, time);
        }
    }

    popNotif('download', time, 'Opening download link...');
});

// Event listener for reload button
$('#reloadbtn').click(function () {
    const isIframe = $('#iframeplayer').is('iframe');
    const message = 'Reloading...';
    const time = 900;

    if (isIframe && reloadCanClick) {
        popNotif('reload', time, message);
        const currentSrc = $('#iframeplayer').attr('src');
        $('#iframeplayer').attr('src', '');
        setTimeout(() => {
            $('#iframeplayer').attr('src', currentSrc);
        }, time);
    } else if (!isIframe && reloadCanClick) {
        popNotif('reload', time, message);
        const currentSrc = $('#videoPlayer').find('source').attr('src');
        $('#videoPlayer').find('source').attr('src', '');
        setTimeout(() => {
            $('#videoPlayer').find('source').attr('src', currentSrc);
        }, time);
    } else {
        popNotif('reload', time, message);
    }
});

// Event listener for follow button
$('#followbtn').click(function () {
    let followedByUser = localStorage.getItem('followedByUser');
    let followed = followedByUser ? JSON.parse(followedByUser) : [];
    let index = followed.indexOf(animeId);

    if (index === -1) {
        followed.push(animeId);
        $(this).html('<i class="glyphicon glyphicon-bell"></i> Followed');
        console.log('Anime added to followed list');
    } else {
        followed.splice(index, 1);
        $(this).html('<i class="glyphicon glyphicon-bell"></i> Follow');
        console.log('Anime removed from followed list');
    }

    localStorage.setItem('followedByUser', JSON.stringify(followed));
});


handleBackNavigation();
initializeFirstLoad();
previousButton = initializePreviousButton(animeId, lastTime);