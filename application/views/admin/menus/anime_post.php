<?php $this->load->view('admin/partials/header'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Anime Posts Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Anime
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>All Anime Posts</span>
        <div class="input-group w-25">
            <input type="text" class="form-control form-control-sm" placeholder="Search anime...">
            <button class="btn btn-outline-light btn-sm" type="button">Search</button>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>One Piece</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>2023-12-01</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('admin/partials/footer'); ?>
