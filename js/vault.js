$(document).ready(function() {
    $('#search').on('input', function() {
        var searchQuery = $(this).val();
        var type = $(this).data('type');
        $.ajax({
            url: 'search_vault.php',
            method: 'GET',
            data: { query: searchQuery, type: type },
            success: function(response) {
                $('#results').html(response);
            }
        });
    });
});

