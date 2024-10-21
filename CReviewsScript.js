const header = document.getElementById('header');
const container = document.querySelector('.Container');
const boxes = document.querySelectorAll('.RContainer .box1, .RContainer .box2, .RContainer .box3, .RContainer .box4, .RContainer .box5, .RContainer .box6');

// Track the scroll position
let lastScrollTop = 0;
window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    // If scrolling down, hide the header and container; if scrolling up, show them
    if (scrollTop > lastScrollTop) {
        header.classList.add('hidden');
        container.classList.add('hidden');
    } else {
        header.classList.remove('hidden');
        container.classList.remove('hidden');
    }

    // Now, handle the boxes hiding when scrolling down and reappearing when scrolling up
    boxes.forEach(box => {
        const boxTop = box.getBoundingClientRect().top + window.scrollY;
        const boxBottom = boxTop + box.offsetHeight;

        // If scrolling past the box, add 'hide-again', if scrolling up to it, remove 'hide-again'
        if (scrollTop > boxBottom) {
            box.classList.add('hide-again'); // Hide the box when scrolled past it
        } else if (scrollTop < boxBottom - box.offsetHeight) {
            box.classList.remove('hide-again'); // Make the box reappear when scrolling back up
        }
    });

    lastScrollTop = scrollTop;
});

// IntersectionObserver for initially appearing review boxes
const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show'); // Fade in the boxes the first time
            observer.unobserve(entry.target); // Stop observing after it fades in
        }
    });
}, {
    threshold: 0.1 // Trigger when 10% of the element is in view
});

// Observe each review box
boxes.forEach(box => {
    observer.observe(box);
});