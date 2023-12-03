document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const toggleBtn = this.querySelector('.toggle-btn');

            if (answer.style.display === 'block') {
                answer.style.display = 'none';
                toggleBtn.textContent = '+';
            } else {
                answer.style.display = 'block';
                toggleBtn.textContent = '-';
            }
        });
    });
});