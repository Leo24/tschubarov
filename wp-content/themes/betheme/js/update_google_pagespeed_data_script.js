jQuery(function($){
    $( document ).ready(function(){
        $('#update-google-page-speed-data').on('click', function(){
            var url = $(this).attr('data-url'),
                postID = $(this).attr('data-post-id'),
                imageUrl = $(this).attr('data-image-url');
            $(this).parent().append('<img class="update-google-page-speed-loader" src="'+imageUrl+'" alt="loader">');
                jQuery.ajax({
                url: url,
                type: "POST",
                data: {
                    action: 'update_google_page_speed_data',
                    postID: postID
                },
                success: function (data) {
                    $('.update-google-page-speed-loader').remove();
                    if(data.success == false){
                        $('#update-google-page-speed-action').append('' +
                            '<p class="update-google-page-speed-message">Error while updating, please, check browser console for details.</p>'
                        );
                        setTimeout(function () {
                            $('.update-google-page-speed-message').remove();
                        }, 5000);
                        console.log(data.data);
                    }else {
                        $('#update-google-page-speed-action').append('<p class="update-google-page-speed-message">Google PageSpeed Data Successfully updated!</p>');
                        setTimeout(function () {
                            $('.update-google-page-speed-message').remove();
                        }, 5000);
                    }
                }

            });
        });
    });
});