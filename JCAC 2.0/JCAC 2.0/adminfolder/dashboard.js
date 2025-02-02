document.addEventListener('DOMContentLoaded', function() {
    const dashboard = document.querySelector('.dashboard');
    const dailyDevotion = document.querySelector('.daily-devotion');

    function handleScroll() {
        const scrollPosition = window.scrollY + window.innerHeight;
        const devotionPosition = dailyDevotion.offsetTop;
        const dashboardPosition = dashboard.offsetTop + dashboard.offsetHeight;

        if (scrollPosition > devotionPosition) {
            dailyDevotion.classList.add('animate');
        } else {
            dailyDevotion.classList.remove('animate');
        }

        if (window.scrollY < dashboardPosition) {
            dashboard.classList.add('animate');
        } else {
            dashboard.classList.remove('animate');
        }
    }

    window.addEventListener('scroll', handleScroll);
});
