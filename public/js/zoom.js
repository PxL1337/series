window.addEventListener('DOMContentLoaded', (event) => {
    var zoomables = document.querySelectorAll('.zoomable');
    zoomables.forEach(function(zoomable) {
        zoomable.addEventListener('mouseover', function() {
            this.style.transform = 'scale3d(1.2, 1.2, 1.2)';
            this.style.zIndex = 2;
        });

        zoomable.addEventListener('mouseout', function() {
            this.style.transform = '';
            this.addEventListener('transitionend', function() {
                this.style.zIndex = 1;
            }, { once: true });  // Execute the listener only once
        });
    });
});
