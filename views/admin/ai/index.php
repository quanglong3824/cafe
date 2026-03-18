<?php // views/admin/ai/index.php ?>
<style>
    .ai-hero {
        background: var(--surface);
        padding: 3rem 2rem;
        border-radius: var(--radius-xl);
        text-align: center;
        border: 1px solid var(--border);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .ai-icon-wrap {
        width: 80px;
        height: 80px;
        background: var(--gold-light);
        color: var(--gold-dark);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem auto;
    }
</style>

<div class="page-content">
    <div class="ai-hero">
        <div class="ai-icon-wrap">
            <i class="fas fa-robot"></i>
        </div>
        <h2 style="font-size: 1.8rem; margin-bottom: 0.5rem; color: var(--text);">Aurora AI - Assistant</h2>
        <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto 2rem auto; line-height: 1.6;">
            Chào mừng bạn đến với trung tâm điều khiển AI. Tính năng đang trong quá trình phát triển (Beta).
            Sắp tới AI sẽ giúp bạn tự động trả lời khách hàng, đề xuất thực đơn thông minh, và phân tích doanh thu hàng
            tuần.
        </p>

        <button class="btn btn-gold btn-lg" onclick="alert('Tính năng đang được phát triển!')"
            style="padding: 0.75rem 2rem; border-radius: var(--radius-lg);">
            <i class="fas fa-plug text-white"></i> Kích hoạt kết nối AI
        </button>
    </div>
</div>