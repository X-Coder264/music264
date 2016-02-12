/**
 * Created by Tomi Laptop on 7.1.2016..
 */
// todo:testing erase when finsihed

$('.rating').click(function(event) {
    event.preventDefault();


        if ($('.rate-1').is(':checked')){
            $starValue = $('.rate-1').val();
        }
        else  if ($('.rate-2').is(':checked')){
            $starValue = $('.rate-2').val();
        }
        else  if ($('.rate-3').is(':checked')){
            $starValue = $('.rate-3').val();
        }
        else  if ($('.rate-4').is(':checked')){
            $starValue = $('.rate-4').val();
        }
        else  if ($('.rate-5').is(':checked')){
            $starValue = $('.rate-5').val();
        }


    $.ajax({
        url: 'testing',

        data:{ rate: $starValue},

        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },

        success: function($starValue) {
            //var $bla = $('.klasatext').val();

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


            $('.rating')

                .append($starValue);
            console.log($starValue);
        },

        type: 'POST'
    });
});