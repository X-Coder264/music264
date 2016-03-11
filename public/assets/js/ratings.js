/**
 * Created by Tomi Laptop on 7.1.2016..
 */

//While song is loading, it takes source of current song and gets info from database about that song
$(document).ready(function(){
    var vid = document.getElementById("audio-player");


    vid.onloadedmetadata = function() {

        $.ajax({
            url: '/ratings/song',
            data: {source : vid.currentSrc},

            dataType: 'json',

            success: function(data)
            {
                song = data[0];
                var $songName = data[0]['name'];
                songOwner = data[0]['user_id'];

                $("#song-name").text($songName);

                $.ajax({
                    url: '/ratings',
                    data: {songId: song['id']},

                    dataType: 'json',
                    success: function(data)
                    {

                        var $value = 0;
                        $value = data[0]['value'];

                        if ($value == 1){
                            $('.rating').find(':radio[name=rate][value="1"]').prop('checked', true);
                        }
                        else  if ($value == 2){
                            $('.rating').find(':radio[name=rate][value="2"]').prop('checked', true);
                        }
                        else  if ($value == 3){
                            $('.rating').find(':radio[name=rate][value="3"]').prop('checked', true);
                        }
                        else  if ($value == 4){
                            $('.rating').find(':radio[name=rate][value="4"]').prop('checked', true);
                        }
                        else  if ($value == 5){
                            $('.rating').find(':radio[name=rate][value="5"]').prop('checked', true);
                        }
                        else{
                            $('.rating').find(':radio[name=rate][value="1"]').prop('checked', false);
                            $('.rating').find(':radio[name=rate][value="2"]').prop('checked', false);
                            $('.rating').find(':radio[name=rate][value="3"]').prop('checked', false);
                            $('.rating').find(':radio[name=rate][value="4"]').prop('checked', false);
                            $('.rating').find(':radio[name=rate][value="5"]').prop('checked', false);
                        }
                    },

                    type: 'GET'
                });
            },

            type: 'GET'
        });

    };
});

//When rating radio button i pressed gets the value and sends it to database with the rest info needed for ratings table in database
$('.rating').click(function(event) {
    event.preventDefault();

    var $starValue='';

    if ($('.rate-1').is(':checked')){
        $starValue = 1;
    }
    else  if ($('.rate-2').is(':checked')){
        $starValue = 2;
    }
    else  if ($('.rate-3').is(':checked')){
        $starValue = 3;
    }
    else  if ($('.rate-4').is(':checked')){
        $starValue = 4;
    }
    else  if ($('.rate-5').is(':checked')){
        $starValue = 5;
    }
    else {
        $starValue = 0;
    }


    $.ajax({
        url: '/ratings',

        //TODO: sredi sta salje
        data:{ rate: $starValue, songId: song['id'], user: songOwner},

        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },

        success: function($starValue) {

            if ($starValue == 1){
                $('.rating').find(':radio[name=rate][value="1"]').prop('checked', true);
            }
            else  if ($starValue == 2){
                $('.rating').find(':radio[name=rate][value="2"]').prop('checked', true);
            }
            else  if ($starValue == 3){
                $('.rating').find(':radio[name=rate][value="3"]').prop('checked', true);
            }
            else  if ($starValue == 4){
                $('.rating').find(':radio[name=rate][value="4"]').prop('checked', true);
            }
            else  if ($starValue == 5){
                $('.rating').find(':radio[name=rate][value="5"]').prop('checked', true);
            }
            else{
                $('.rating').find(':radio[name=rate][value="1"]').prop('checked', false);
                $('.rating').find(':radio[name=rate][value="2"]').prop('checked', false);
                $('.rating').find(':radio[name=rate][value="3"]').prop('checked', false);
                $('.rating').find(':radio[name=rate][value="4"]').prop('checked', false);
                $('.rating').find(':radio[name=rate][value="5"]').prop('checked', false);
            }

        },

        type: 'POST'
    });
});
