/**
 * waiter-ai.js — AI Chat Functions
 * Extracted from waiter.php inline script
 * Aurora Restaurant
 */

/**
 * Toggle AI chat window visibility
 */
function toggleAiChat() {
    const chatObj = document.getElementById('aiChatWindow');
    chatObj.style.display = chatObj.style.display === 'none' ? 'flex' : 'none';
}

/**
 * Send a message to the AI chat
 */
function sendAiMsg() {
    const input = document.getElementById('aiChatInput');
    const txt = input.value.trim();
    if (!txt) return;
    const body = document.getElementById('aiChatBody');
    body.innerHTML += `
    <div style="display: flex; justify-content: flex-end;">
        <div style="background: var(--gold); color: white; padding: 10px 14px; border-radius: 14px; border-top-right-radius: 4px; font-size: 0.9rem; max-width: 85%; box-shadow: 0 2px 4px rgba(212, 175, 55, 0.2);">
            ${txt.replace(/</g, '&lt;')}
        </div>
    </div>`;
    input.value = '';
    body.scrollTop = body.scrollHeight;
    setTimeout(() => {
        body.innerHTML += `
        <div style="display: flex; gap: 10px;">
            <div style="width: 25px; height: 25px; border-radius: 50%; background: var(--gold); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; flex-shrink: 0;"><i class="fas fa-robot"></i></div>
            <div style="background: var(--surface); padding: 10px 14px; border-radius: 14px; border-top-left-radius: 4px; font-size: 0.9rem; color: var(--text); border: 1px solid var(--border); max-width: 85%;">
                <i class="fas fa-ellipsis-h fa-fade"></i> AI đang suy nghĩ...
            </div>
        </div>`;
        body.scrollTop = body.scrollHeight;
    }, 600);
}
