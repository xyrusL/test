<?php $this->load->view('admin/partials/header'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Featured Posts Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-sm btn-primary">
            <i class="bi bi-star-fill"></i> Add Featured Post
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Featured Posts List
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Featured Until</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Demon Slayer</td>
                    <td>Action</td>
                    <td>2024-01-01</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                        <button class="btn btn-sm btn-outline-danger">Remove</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('admin/partials/footer'); ?>
