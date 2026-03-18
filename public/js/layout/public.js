/**
 * public.js — Public View Functions
 * Extracted from public.php inline script
 * Aurora Cafe
 */

/**
 * Request support or payment from the table
 * @param {number} tableId - The table ID requesting service
 * @param {string} type - Type of request: 'support' or 'payment'
 */
function requestSupport(tableId, type) {
    const confirmMsg = type === 'payment' ? __('payment_confirm') : __('call_waiter_confirm');
    if (!confirm(confirmMsg)) return;

    const data = new FormData();
    data.append('table_id', tableId);
    data.append('type', type);

    fetch(BASE_URL + '/support/request', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(res => {
        if (res.ok) {
            alert(res.message);
        } else {
            alert(res.message || __('request_fail'));
        }
    })
    .catch(err => alert(__('conn_error')));
}
