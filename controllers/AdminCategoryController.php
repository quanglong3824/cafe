<?php
// ============================================================
// AdminCategoryController — Full CRUD
// ============================================================

require_once BASE_PATH . '/models/MenuCategory.php';

class AdminCategoryController extends Controller
{
    private MenuCategory $model;

    public function __construct()
    {
        $this->model = new MenuCategory();
    }

    /** GET /admin/categories */
    public function index(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);
        $categories = $this->model->getAll();
        $this->view('layouts/admin', [
            'view' => 'admin/categories/index',
            'pageTitle' => 'Danh Mục Món',
            'pageSubtitle' => count($categories) . ' danh mục',
            'categories' => $categories,
            'editItem' => null,
        ]);
    }

    /** POST /admin/categories/store */
    public function store(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $name = trim((string) $this->input('name', ''));
        if (!$name) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Tên danh mục không được để trống.'];
            $this->redirect('/admin/categories');
        }

        $this->model->create([
            'name' => $name,
            'name_en' => trim((string) $this->input('name_en', '')) ?: null,
            'menu_type' => $this->input('menu_type', 'asia'),
            'icon' => $this->input('icon', 'fa-utensils'),
            'sort_order' => (int) $this->input('sort_order', 0),
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã thêm danh mục!'];
        $this->redirect('/admin/categories');
    }

    /** GET /admin/categories/edit?id= */
    public function edit(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $item = $this->model->findById($id);
        if (!$item) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Không tìm thấy danh mục.'];
            $this->redirect('/admin/categories');
        }

        $categories = $this->model->getAll();
        $this->view('layouts/admin', [
            'view' => 'admin/categories/index',
            'pageTitle' => 'Danh Mục Món',
            'pageSubtitle' => count($categories) . ' danh mục',
            'categories' => $categories,
            'editItem' => $item,   // truyền item đang edit
        ]);
    }

    /** POST /admin/categories/update */
    public function update(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $name = trim((string) $this->input('name', ''));
        if (!$name) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Tên không được để trống.'];
            $this->redirect('/admin/categories');
        }

        $this->model->update($id, [
            'name' => $name,
            'name_en' => trim((string) $this->input('name_en', '')) ?: null,
            'menu_type' => $this->input('menu_type', 'asia'),
            'icon' => $this->input('icon', 'fa-utensils'),
            'sort_order' => (int) $this->input('sort_order', 0),
            'is_active' => (int) $this->input('is_active', 1),
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã cập nhật danh mục!'];
        $this->redirect('/admin/categories');
    }

    /** POST /admin/categories/delete */
    public function delete(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $ok = $this->model->delete($id);
        if (!$ok) {
            $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Không thể xóa — danh mục còn chứa món ăn.'];
        } else {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã xóa danh mục.'];
        }
        $this->redirect('/admin/categories');
    }
}
