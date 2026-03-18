<?php
// ============================================================
// AdminMenuSetController — Admin: Manage Sets & Combos
// ============================================================

require_once BASE_PATH . '/models/MenuSet.php';
require_once BASE_PATH . '/models/MenuItem.php';

class AdminMenuSetController extends Controller
{
    private MenuSet $setModel;
    private MenuItem $itemModel;

    public function __construct()
    {
        $this->setModel = new MenuSet();
        $this->itemModel = new MenuItem();
    }

    /** GET /admin/menu/sets */
    public function index(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $sets = $this->setModel->getAll();
        foreach ($sets as &$set) {
            $set['items'] = $this->setModel->getSetItems($set['id']);
        }

        $this->view('layouts/admin', [
            'view' => 'admin/menu/sets',
            'pageTitle' => 'Quản lý Set & Combo',
            'pageSubtitle' => count($sets) . ' sets',
            'sets' => $sets,
        ]);
    }

    /** POST /admin/menu/sets/store */
    public function store(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $data = $this->collectFormData();
        $id = $this->setModel->create($data);

        // Add items to set
        $this->saveSetItems($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã thêm set mới!'];
        $this->redirect('/admin/menu/sets');
    }

    /** POST /admin/menu/sets/update */
    public function update(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $data = $this->collectFormData();
        $this->setModel->update($id, $data);

        // Update items
        $this->setModel->removeAllItems($id);
        $this->saveSetItems($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã cập nhật set!'];
        $this->redirect('/admin/menu/sets');
    }

    /** POST /admin/menu/sets/delete */
    public function delete(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $this->setModel->delete($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã xóa set.'];
        $this->redirect('/admin/menu/sets');
    }

    /** POST /admin/menu/sets/toggle */
    public function toggle(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $this->setModel->toggleActive($id);

        $set = $this->setModel->findById($id);
        $this->json(['ok' => true, 'is_active' => $set['is_active']]);
    }

    private function collectFormData(): array
    {
        return [
            'name' => trim((string) $this->input('name', '')),
            'name_en' => trim((string) $this->input('name_en', '')) ?: null,
            'description' => trim((string) $this->input('description', '')) ?: null,
            'price' => (float) $this->input('price', 0),
            'sort_order' => (int) $this->input('sort_order', 0),
            'is_active' => (int) $this->input('is_active', 1),
        ];
    }

    private function saveSetItems(int $setId): void
    {
        $itemIds = $this->input('item_ids', []);
        $quantities = $this->input('quantities', []);
        $isRequired = $this->input('is_required', []);

        if (empty($itemIds)) return;

        foreach ($itemIds as $idx => $menuItemId) {
            $menuItemId = (int) $menuItemId;
            if ($menuItemId > 0) {
                $this->setModel->addItem(
                    $setId,
                    $menuItemId,
                    (int) ($quantities[$idx] ?? 1),
                    !empty($isRequired[$idx]),
                    $idx
                );
            }
        }
    }
}
