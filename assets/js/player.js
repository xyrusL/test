let previousButton = $('.playbutton').first().prop('disabled', true);
$('.playbutton').on('click', function() {
    const episodeNumber = $(this).text(); 
    const animeId = $('#animebtn').data('id');
    
    getEpisodes(episodeNumber - 1, animeId); 
    if (previousButton !== null) {
        previousButton.prop('disabled', false);
    }
    $(this).prop('disabled', true);
    previousButton = $(this);
});

function getEpisodes(episodeIndex, animeId) {
    $.ajax({
        url: `${baseUrl}home/getEpisodeUrl`,
        method: 'POST',
        data: {
            anime_id: animeId,
            episode_index: episodeIndex
        },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.url) {
                $('#iframeplayer').attr('src', data.url);
            } else {
                console.error('Episode URL not found');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching episode:', error);
        }
    });
}