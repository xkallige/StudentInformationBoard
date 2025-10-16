// Events Page JS
console.log('Events page loaded.');
// Add interactivity as needed

// Add interactivity as needed
document.querySelectorAll('.navbar ul a').forEach(link => {
  link.addEventListener('click', () => {
    document.querySelector('.navbar ul').classList.remove('show-nav');
  });
});
