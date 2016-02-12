/**
 * Created by Tomi Laptop on 28.12.2015..
 */
$(document).ready(function(){$('audio,video').mediaelementplayer(
    {
        alwaysShowControls: true,
        audioVolume: 'horizontal',
        audioWidth: 500,
        audioHeight: 60,

        loop: true,
        shuffle: true,
        playlist: false,
        playlistposition: 'top',
        features: ['playlistfeature', 'prevtrack', 'playpause', 'nexttrack', 'loop', 'shuffle', 'playlist', 'current', 'progress', 'duration', 'volume'],

    }
);});

//$('video,audio').mediaelementplayer();
