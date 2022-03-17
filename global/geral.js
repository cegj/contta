function initScrollToTarget(){

    const internalLinks = document.querySelectorAll('a[href^="#"]');

    function scrollToTarget(event){
        event.preventDefault();
        const href = event.currentTarget.getAttribute('href');
        const target = document.querySelector(href);

        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        })
    }

    internalLinks.forEach((link) => {
        link.addEventListener('click', scrollToTarget);    
    });
}

initScrollToTarget();