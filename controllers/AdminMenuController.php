<?php
// ============================================================
// AdminMenuController — Admin: Manage Menu Items
// ============================================================

require_once BASE_PATH . '/models/MenuItem.php';
require_once BASE_PATH . '/models/MenuCategory.php';

class AdminMenuController extends Controller
{
    private MenuItem $itemModel;
    private MenuCategory $categoryModel;

    public function __construct()
    {
        $this->itemModel = new MenuItem();
        $this->categoryModel = new MenuCategory();
    }

    /** GET /admin/menu */
    public function index(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $items = $this->itemModel->getAll();
        $categories = $this->categoryModel->getAll();

        $this->view('layouts/admin', [
            'view' => 'admin/menu/index',
            'pageTitle' => 'Quản lý Món ăn',
            'pageSubtitle' => count($items) . ' món',
            'items' => $items,
            'categories' => $categories,
        ]);
    }

    /** GET /admin/menu/create */
    public function create(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $categories = $this->categoryModel->getActive();
        $this->view('layouts/admin', [
            'view' => 'admin/menu/form',
            'pageTitle' => 'Thêm Món',
            'categories' => $categories,
            'item' => null,
        ]);
    }

    /** POST /admin/menu/store */
    public function store(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $data = $this->collectFormData();

        if (!empty($_FILES['image']['name'])) {
            $uploaded = uploadMenuImage($_FILES['image']);
            if ($uploaded)
                $data['image'] = $uploaded;
        }

        $id = $this->itemModel->create($data);
        $this->handleGalleryUpload($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã thêm món thành công!'];
        $this->redirect('/admin/menu');
    }

    /** GET /admin/menu/edit?id= */
    public function edit(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $item = $this->itemModel->findById($id);
        if (!$item)
            $this->redirect('/admin/menu');

        $categories = $this->categoryModel->getActive();
        $this->view('layouts/admin', [
            'view' => 'admin/menu/form',
            'pageTitle' => 'Sửa Món',
            'categories' => $categories,
            'item' => $item,
        ]);
    }

    /** POST /admin/menu/update */
    public function update(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $data = $this->collectFormData();

        if (!empty($_FILES['image']['name'])) {
            $uploaded = uploadMenuImage($_FILES['image']);
            if ($uploaded) {
                $data['image'] = $uploaded;
                $this->itemModel->updateImage($id, $uploaded);
            }
        }

        $this->itemModel->update($id, $data);
        $this->handleGalleryUpload($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã cập nhật món!'];
        $this->redirect('/admin/menu');
    }

    /** POST /admin/menu/delete */
    public function delete(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $this->itemModel->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã xóa món.'];
        $this->redirect('/admin/menu');
    }

    /** POST /admin/menu/toggle — Toggle hết hàng/còn hàng */
    public function toggle(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $type = (string) $this->input('type', 'available'); // available | active

        if ($type === 'active') {
            $this->itemModel->toggleActive($id);
        } else {
            $this->itemModel->toggleAvailable($id);
        }

        $item = $this->itemModel->findById($id);
        $this->json(['ok' => true, 'is_available' => $item['is_available'], 'is_active' => $item['is_active']]);
    }

    private function collectFormData(): array
    {
        $tags = $this->input('tags', []);
        return [
            'category_id' => (int) $this->input('category_id'),
            'name' => trim((string) $this->input('name', '')),
            'name_en' => trim((string) $this->input('name_en', '')) ?: null,
            'description' => trim((string) $this->input('description', '')) ?: null,
            'price' => (float) $this->input('price', 0),
            'stock' => (int) $this->input('stock', -1),
            'tags' => is_array($tags) ? implode(',', $tags) : null,
            'sort_order' => (int) $this->input('sort_order', 0),
            'is_active' => (int) $this->input('is_active', 1),
        ];
    }

    private function handleGalleryUpload(int $itemId): void
    {
        if (empty($_FILES['gallery']['name'][0]))
            return;

        foreach ($_FILES['gallery']['name'] as $key => $name) {
            if ($_FILES['gallery']['error'][$key] === UPLOAD_ERR_OK) {
                $file = [
                    'name' => $name,
                    'type' => $_FILES['gallery']['type'][$key],
                    'tmp_name' => $_FILES['gallery']['tmp_name'][$key],
                    'error' => $_FILES['gallery']['error'][$key],
                    'size' => $_FILES['gallery']['size'][$key]
                ];
                $uploaded = uploadMenuImage($file);
                if ($uploaded) {
                    $this->itemModel->addGalleryImage($itemId, $uploaded);
                }
            }
        }
    }
}
