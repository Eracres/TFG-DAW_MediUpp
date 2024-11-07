$(document).ready(function() {
    $('#logout-btn').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: '',
            type: 'POST',
            success: function(response) {
                
            },
            error: function(error) {
                console.error("No se ha podido cerrar sesión");
            }
        });
    });
});