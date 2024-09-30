<?php
namespace App\Controllers;

use Config\Services;

class Sys extends BaseController {

public function index() {
helper('form');
echo view('sys/login');
}

public function view_add_new_category() {
helper('form');
$user_type = strtolower(session()->get('UserType'));

echo view('sys/header');
echo view('sys/menu_' . $user_type);
echo view('sys/add_new_category');
echo view('sys/footer');
}

}

<main id = "main" class = "main">
    <div class = "pagetitle">
        <h1>Add Category</h1>
        <nav>
            <ol class = "breadcrumb">
                <li class = "breadcrumb-item"><a href = "<?= base_url('/'); ?>">Home</a></li>
                <li class = "breadcrumb-item active">Add Category</li>
            </ol>
        </nav>
    </div>
    <section class = "section">
        <div class = "row">
            <div class = "col-lg-8">
                <div class = "card">
                    <div class = "card-body">
                        <? = form_open('sys/saveCategory', ['novalidate' => 'novalidate', 'role' => 'form']);
                        ?>
                        <div class="form-group">
                            <label for="Item_Category">Category</label>
                            <input type="text" class="form-control" id="Item_Category" name="Item_Category">
                            <span class="text-danger"><?= service('validation')->getError('Item_Category') ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

public function saveCategory() {
        helper('form');
        $data = array();
        $Item_Category = new CategoryModel();

        $user_type = strtolower(session()->get('UserType'));

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'Item_Category' => ['label' => 'Item Category', 'rules' => 'required|is_unique[category.Item_Category]'],
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $Item_Category = new CategoryModel();
                $Item_Category->save(['Item_Category' => $this->request->getPost('Item_Category')]);
                // Set flash message
                session()->setFlashdata('message', 'Category successfully added.');

                // Redirect back to add new category view
                return redirect()->to('sys/view_add_new_category');
            }
            echo view('sys/header');
            echo view('sys/menu_' . $user_type);
            echo view('sys/add_new_category', $data);
            echo view('sys/footer');
        }
    }
    
        public function listCategories() {
        $model = new CategoryModel();

        // Fetch categories where deleted_at is not set
        $data['categories'] = $model->where('deleted_at', null)->findAll();

        // Load views
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/list_categories', $data);
        echo view('sys/footer');
    }
    
    
    <main id="main" class="main">
    <div class="pagetitle">
        <h1>Categories</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </nav>
    </div>
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Item Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?= $category['Category_ID']; ?></td>
                                        <td><?= $category['Item_Category']; ?></td>
                                        <td>
                                            <a href="<?= base_url('sys/editCategory/' . $category['Category_ID']); ?>" class="btn btn-primary">Edit</a>
                                            <a href="<?= base_url('sys/deleteCategory/' . $category['Category_ID']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

    
        public function editCategory($Category_ID) {
        $model = new CategoryModel();
        $category = $model->find($Category_ID);

        if (!$category) {
            // If no category found, redirect or show an error
            return redirect()->to('sys/listCategories'); // Adjust as needed
        }

        $data['category'] = $category;

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/edit_category', $data);
        echo view('sys/footer');
    }
    
    <main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Category</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('sys/updateCategory') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="Category_ID" value="<?= $category['Category_ID'] ?>">

                            <div class="form-group">
                                <label for="Item_Category">Category Name</label>
                                <input type="text" class="form-control" id="Item_Category" name="Item_Category" value="<?= $category['Item_Category'] ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

    
        public function updateCategory() {
        $model = new CategoryModel();
        $Category_ID = $this->request->getPost('Category_ID');
        $data = [
            'Item_Category' => $this->request->getPost('Item_Category'),
        ];

        $model->where('Category_ID', $Category_ID)->set($data)->update();

        return redirect()->to('/sys/listCategories')->with('message', 'Category successfully Updated.');
    }
    
        public function deleteCategory($Category_ID) {
        $model = new CategoryModel();

        if (!$Category_ID) {
            $Category_ID = $this->request->getPost('Category_ID');
        }

        if ($Category_ID) {
            $model->where('Category_ID', $Category_ID)->set(['deleted_at' => date("Y-m-d")])->update();

            return redirect()->to('/sys/listCategories')->with('message', 'Category successfully deleted.');
        } else {
            return redirect()->back()->with('errors', ['Could not delete the category.']);
        }
    }
    
        public function listDeletedCategories() {
        $model = new CategoryModel();
        $data['categories'] = $model->where('deleted_at IS NOT NULL')->findAll();

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/list_deleted_categories', $data);
        echo view('sys/footer');
    }
    
    <main id="main" class="main">
    <div class="pagetitle">
        <h1>Deleted Categories</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Deleted Categories</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Item Category</th>
                                    <th>Deleted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category['Category_ID']; ?></td>
                                    <td><?= $category['Item_Category']; ?></td>
                                    <td><?= $category['deleted_at'] ? $category['deleted_at'] : 'N/A'; ?></td>
                                    <td>
                                        <?php if ($category['deleted_at']): ?>
                                            <a href="<?= base_url('/sys/restoreCategory/' . $category['Category_ID']); ?>" class="btn btn-success">Restore</a>
                                            <a href="<?= base_url('/sys/permanentlyDeleteCategory/' . $category['Category_ID']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure? This cannot be undone!')">Permanently Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

    
    
    
    public function restoreCategory($CategoryID) {
        $model = new CategoryModel();
        if ($model->update($CategoryID, ['deleted_at' => null])) {
            return redirect()->to('/sys/listDeletedCategories')->with('message', 'Category restored successfully');
        } else {
            return redirect()->back()->with('errors', ['Could not restore the category.']);
        }
    }

    public function permanentlyDeleteCategory($CategoryID) {
        $model = new CategoryModel();
        if ($model->delete($CategoryID, true)) { // The second parameter `true` indicates a hard delete.
            return redirect()->to('/sys/listDeletedCategories')->with('message', 'Category permanently deleted successfully');
        } else {
            return redirect()->back()->with('errors', ['Could not delete the category permanently.']);
        }
    }
    



