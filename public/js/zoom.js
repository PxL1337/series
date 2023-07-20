window.addEventListener('DOMContentLoaded', (event) => {
    const zoomables = document.querySelectorAll('.zoomable');
    zoomables.forEach(function(zoomable, i) {
        // Set initial state
        zoomable.style.opacity = '0';
        zoomable.style.transform = 'translateY(20px)';
        zoomable.style.transition = 'transform 0.3s ease, opacity 0.3s ease, z-index 0s 0.3s';

        // Add appearing animation to each image
        setTimeout(function() {
            zoomable.style.opacity = '1';
            zoomable.style.transform = 'translateY(0)';
        }, i * 100);

        // Add zoom effect when image is hovered over
        zoomable.addEventListener('mouseover', function() {
            this.style.transform = 'scale3d(1.2, 1.2, 1.2)';
            this.style.zIndex = '2';
        });

        // Reset zoom effect when image is no longer hovered over
        zoomable.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
            this.style.zIndex = '1';
        });
    });
});
