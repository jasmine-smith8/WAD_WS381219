function showAlert(message, type) {
    const alertBox = $('<div class="alert"></div>')
        .text(message)
        .addClass(`alert-${type}`)
        .css({
            'background-color': type === 'success' ? '#D99293' : '#710000', // Dark Red for success, Light Red for error
            'color': 'pink',
            'padding': '10px 20px',
            'border-radius': '15px',
            'margin': '10px 0',
            'text-align': 'center',
            'font-weight': '700'
        });

    $('body').prepend(alertBox);

    setTimeout(() => {
        alertBox.fadeOut(500, function() {
            $(this).remove();
        });
    }, 3000);
}

$(document).ready(function() {
    // Example usage:
    // showAlert('Login successful!', 'success');
    // showAlert('Invalid credentials, please try again.', 'error');
});