// Initialize data table
new DataTable('#data');

// Initialize patient history table, sort by date prescribed
new DataTable('#phil', {
    order: [[2, 'desc']]
});

// Initialize search results table, allow data to be scrolled through
new DataTable('#search-table', {
    scrollY: 400
});

// Make table rows link to new page
$(document).ready(function () {
    $(document.body).on("click", "tr[data-href]", function() {
        window.location.href = this.dataset.href;
    });
});