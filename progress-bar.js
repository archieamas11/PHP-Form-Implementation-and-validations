const steps = document.querySelectorAll('.StepProgress-item');
const contents = document.querySelectorAll('.content');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');
let currentIndex = 0;

function updateProgress() {
    steps.forEach((step, index) => {
        step.classList.remove('is-done', 'current');
        if (index < currentIndex) step.classList.add('is-done');
        if (index === currentIndex) step.classList.add('current');
    });

    // Update progress line
    const progressLine = document.querySelector('.StepProgress');
    const progressPercentage = (currentIndex / (steps.length - 1)) * 100;
    progressLine.style.setProperty('--progress', `${progressPercentage}%`);
}

function updateContent() {
    contents.forEach((content, index) => {
        content.classList.toggle('content-active', index === currentIndex);
    });
}

nextBtn.addEventListener('click', () => {
    if (currentIndex < steps.length - 1) {
        currentIndex++;
        updateProgress();
        updateContent();
    }
});

prevBtn.addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
        updateProgress();
        updateContent();
    }
});