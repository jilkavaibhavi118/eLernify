// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function () {
    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 50
        });
    }

    var myCarousel = document.getElementById('heroCarousel');
    var pageNum = document.getElementById('carouselPageNum');
    var progressBar = document.getElementById('carouselProgressBar');

    // Listen for the Bootstrap carousel slide event
    myCarousel.addEventListener('slide.bs.carousel', function (e) {
        // e.to is the index of the next slide (0 or 1)
        var nextSlideIndex = e.to + 1; // Convert 0-index to 1-based count

        // Update Text
        pageNum.innerText = '0' + nextSlideIndex + ' / 02';

        // Update Progress Bar Width
        if (nextSlideIndex === 1) {
            progressBar.style.width = '50%';
        } else {
            progressBar.style.width = '100%';
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {

    // Select all counter elements
    const counters = document.querySelectorAll('.counter');

    // Function to start the counting animation
    const startCounter = (entry, observer) => {
        entry.forEach(change => {
            if (change.isIntersecting) {
                const counter = change.target;
                const target = +counter.getAttribute('data-target');
                const speed = 200; // The higher the slower

                const updateCount = () => {
                    const count = +counter.innerText;
                    // Lower the increment to make it smoother
                    const inc = target / speed;

                    if (count < target) {
                        // Add inc to count and round up
                        counter.innerText = Math.ceil(count + inc);
                        // Call function every 10ms
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
                // Stop observing once animation has started
                observer.unobserve(counter);
            }
        });
    };

    // Create the observer
    const observer = new IntersectionObserver(startCounter, {
        root: null, // Viewport
        threshold: 0.5 // Trigger when 50% of the element is visible
    });

    // Attach observer to each counter
    counters.forEach(counter => {
        observer.observe(counter);
    });
});

document.addEventListener("DOMContentLoaded", () => {

    // --- 1. NUMBER COUNTER LOGIC (Existing) ---
    const counters = document.querySelectorAll('.counter');

    // --- 2. CATEGORY ANIMATION LOGIC (New) ---
    const categoryRow = document.getElementById('categoryRow');

    // Shared Observer Function
    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {

                // Logic for Counters
                if (entry.target.classList.contains('counter')) {
                    const counter = entry.target;
                    const target = +counter.getAttribute('data-target');
                    const speed = 200;

                    const updateCount = () => {
                        const count = +counter.innerText;
                        const inc = target / speed;
                        if (count < target) {
                            counter.innerText = Math.ceil(count + inc);
                            setTimeout(updateCount, 20);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    updateCount();
                    observer.unobserve(counter); // Stop watching once done
                }

                // Logic for Category Grid (Add 'active' class)
                if (entry.target.id === 'categoryRow') {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target); // Stop watching once triggered
                }
            }
        });
    };

    // Create the observer
    const observer = new IntersectionObserver(observerCallback, {
        root: null,
        threshold: 0.2 // Trigger when 20% of the item is visible
    });

    // Attach observer to Counters
    counters.forEach(counter => observer.observe(counter));

    // Attach observer to Category Row (if it exists)
    if (categoryRow) {
        observer.observe(categoryRow);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('courseContainer');
    const leftBtn = document.getElementById('scrollLeftBtn');
    const rightBtn = document.getElementById('scrollRightBtn');

    // Scroll amount (300px roughly width of one card + gap)
    const scrollAmount = 320;

    rightBtn.addEventListener('click', () => {
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });

    leftBtn.addEventListener('click', () => {
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
});

const textElement = document.getElementById('typing-text');

// The phrases you want to type out
const phrases = [
    "To Launch Your Career.",
    "For Modern Development.",
    "In Graphic Design.",
    "To Grow Your Skills."
];

let phraseIndex = 0;
let charIndex = 0;
let isDeleting = false;
let typeSpeed = 100; // Speed of typing (ms)

function typeWriter() {
    const currentPhrase = phrases[phraseIndex];

    if (isDeleting) {
        // Remove character
        textElement.textContent = currentPhrase.substring(0, charIndex - 1);
        charIndex--;
        typeSpeed = 50; // Faster when deleting
    } else {
        // Add character
        textElement.textContent = currentPhrase.substring(0, charIndex + 1);
        charIndex++;
        typeSpeed = 100; // Normal typing speed
    }

    if (!isDeleting && charIndex === currentPhrase.length) {
        // Finished typing phrase, wait before deleting
        isDeleting = true;
        typeSpeed = 2000; // Pause at end of sentence
    } else if (isDeleting && charIndex === 0) {
        // Finished deleting, move to next phrase
        isDeleting = false;
        phraseIndex = (phraseIndex + 1) % phrases.length; // Loop back to start
        typeSpeed = 500; // Pause before typing next
    }

    setTimeout(typeWriter, typeSpeed);
}

// Start the effect when page loads
document.addEventListener('DOMContentLoaded', typeWriter);