window.addEventListener('DOMContentLoaded', (event) => {
    const zoomables = document.querySelectorAll('.zoomable');
    zoomables.forEach(function(zoomable, i) {
        // Set initial state
        zoomable.style.opacity = '0';
        zoomable.style.transform = 'translateY(20px)';
        zoomable.style.transition = 'transform 0.3s ease, opacity 0.3s ease, z-index 0s 0.3s';
        zoomable.classList.add('appeared');

        // Add appearing animation to each image
        setTimeout(function() {
            zoomable.style.opacity = '1';
            zoomable.style.transform = 'translateY(0)';
        }, i * 50);

        // Add zoom effect when image is hovered over
        zoomable.addEventListener('mouseover', function() {
            this.style.transform = 'scale3d(1.15, 1.15, 1.15)';
            this.style.zIndex = '2';
        });

        // Reset zoom effect when image is no longer hovered over
        zoomable.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
            this.style.zIndex = '1';
        });
    });

    let loadedSeries = 50;

    window.addEventListener('scroll', function() {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
            // User has scrolled to bottom of page, load more data
            fetch('/series/more?offset=' + loadedSeries)
                .then(response => response.json())
                .then(data => {
                    // Append the new data to the page
                    for (const serie of data) {
                        const article = document.createElement('article');
                        article.classList.add('zoomable');
                        const link = document.createElement('a');
                        link.href = '/series/details/' + serie.id;
                        link.title = 'View serie\'s details | ' + serie.seasons + ' seasons';
                        const img = document.createElement('img');
                        img.src = '/img/posters/series/' + serie.poster;
                        img.alt = serie.name;
                        link.appendChild(img);
                        article.appendChild(link);
                        document.querySelector('.series-list').appendChild(article);
                    }

                    // Update the count of loaded series
                    loadedSeries += data.length;

                    // Apply appearing effect to new series
                    const newSeries = document.querySelectorAll('.zoomable:not(.appeared)');
                    newSeries.forEach(function(serie, i) {
                        // Set initial state
                        serie.style.opacity = '0';
                        serie.style.transform = 'translateY(20px)';
                        serie.style.transition = 'transform 0.3s ease, opacity 0.3s ease, z-index 0s 0.3s';
                        serie.classList.add('appeared');

                        // Add appearing animation to each serie
                        setTimeout(function() {
                            serie.style.opacity = '1';
                            serie.style.transform = 'translateY(0)';
                        }, i * 50);

                        // Add zoom effect when serie is hovered over
                        serie.addEventListener('mouseover', function() {
                            this.style.transform = 'scale3d(1.2, 1.2, 1.2)';
                            this.style.zIndex = '2';
                        });

                        // Reset zoom effect when serie is no longer hovered over
                        serie.addEventListener('mouseout', function() {
                            this.style.transform = 'translateY(0)';
                            this.style.zIndex = '1';
                        });
                    });
                });
        }
    });

    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    }

});
