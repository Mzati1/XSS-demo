document.addEventListener('DOMContentLoaded', () => {
    console.log('Gadget Store demo lab loaded.');
    
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            const queryInput = searchForm.querySelector('input[name="query"]');
            if (queryInput && queryInput.value.trim() === '') {
                e.preventDefault();
                alert('Please enter a search term!');
            }
        });
    }
});
