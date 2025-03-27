$(document).ready(function() {
    $("#user-navbar").load("/pages/components/user-navbar.html");
    $("#user-footer").load("/pages/components/user-footer.html");

    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
    card.addEventListener('mouseover', () => {
        card.style.transform = 'scale(1.05)';
        card.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
        card.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
        card.style.transition = 'transform 0.3s, box-shadow 0.3s, background-color 0.3s';
    });

    card.addEventListener('mouseout', () => {
        card.style.transform = 'scale(1)';
        card.style.boxShadow = 'none';
    });
    });
});

