
    //todo
    function cordairways_api_create_modal(modal_id) {
    }

    $('#closeModal').on('click', function(e) {
        e.preventDefault();
        $('.modal').hide();
    });

    /**
     * Muestra mensajes en un contenedor dado en los parametros.
     * @param container
     * @param content
     * @param type
     */
    function cordairways_api_show_error_message(container, content, type='tag is-warning') {
        var $wrapper = $(container);
        var html = '<div id="error-message-api" class="'+type+'">'+content+'</div>';
        if($wrapper){
            if(!$wrapper.is(':empty')) {
                $wrapper.empty("");
            }
            $wrapper.empty("");
            $($wrapper).html(html);
            $wrapper.removeClass('is-invisible');

            // setTimeout(function() {
            //     $wrapper.addClass('is-invisible');
            // }, 15000);
        }
    }

    function cordairways_api_create_loader(container) {
        var html = '<img src="'+site_url +'/statics/images/loading.svg" id="loading" class="is-hidden" alt="">';
        $(container).prepend(html);
    }

