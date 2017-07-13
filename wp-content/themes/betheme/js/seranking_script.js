jQuery(function($){
    $( document ).ready(function(){

        $('#add_update_serankins_site').on('click', function(){

            var dataSource = $('#update-google-page-speed-data');

            var url = dataSource.attr('data-url'),
                postID = dataSource.attr('data-post-id'),
                imageUrl = dataSource.attr('data-image-url'),
                serankinsSiteID = $('#se_rankins_site_id .acf-input input').val();
            $(this).append('<img class="update-google-page-speed-loader" src="'+imageUrl+'" alt="loader">');
            jQuery.ajax({
                url: url,
                type: "POST",
                data: {
                    action          : 'add_update_serankins_site',
                    postID          : postID,
                    serankinsSiteID : serankinsSiteID
                },
                success: function (data) {
                    if(Number.isInteger(data) === true){
                        serankinsSiteID = $('#se_rankins_site_id .acf-input input').val(data);
                        $('#add_update_serankins_site').append('' +
                            '<p class="add-update-serankins-site">Site succsessfully added to seranking with id='+data+', page will reload in 5 seconds.</p>'
                        );
                        setTimeout(function () {
                            $('#publish').click()
                        }, 5000);

                    }
                    $('.update-google-page-speed-loader').remove();
                        $('#add_update_serankins_site').append('' +
                            '<p class="add-update-serankins-site">'+data+'</p>'
                        );
                        setTimeout(function () {
                            $('.add-update-serankins-site').remove();
                        }, 5000);
                        console.log(data);

                }

            });
        });























    });
});