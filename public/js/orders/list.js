// ============================================================
// orders-list.js — Active Orders List Filter Logic
// ============================================================

// Area filter functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('is-active'));
        btn.classList.add('is-active');

        // Filter rows
        const filterArea = btn.getAttribute('data-area');
        const rows = document.querySelectorAll('.order-row-card');
        let visibleCount = 0;

        rows.forEach(row => {
            if (filterArea === 'all' || row.getAttribute('data-area') === filterArea) {
                row.style.display = 'flex';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide empty state
        const emptyState = document.getElementById('emptyFilterState');
        if (emptyState) {
            emptyState.style.display = (visibleCount === 0 && rows.length > 0) ? 'block' : 'none';
        }
    });
});

// Update total count display
function updateTotalCount() {
    const countEl = document.getElementById('totalCountDisplay');
    if (countEl) {
        const count = document.querySelectorAll('.order-row-card:not([style*="display: none"])').length;
        countEl.textContent = count;
    }
}
