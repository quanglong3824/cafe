<?php
// ============================================================
// AdminAiController — AI Chatbot / Assistant (Tĩnh)
// ============================================================

class AdminAiController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $this->view('layouts/admin', [
            'view' => 'admin/ai/index',
            'pageTitle' => 'AI Assistant',
            'pageSubtitle' => 'Trung tâm trợ lý ảo thông minh',
        ]);
    }
}
