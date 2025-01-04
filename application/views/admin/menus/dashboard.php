<?php $this->load->view('admin/partials/header'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<!-- Stats Cards -->
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <h2 class="card-text"><?= $total_users ?? 0 ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Active Users</h5>
                <h2 class="card-text">120</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">New Users</h5>
                <h2 class="card-text">25</h2>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Recent Activity
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Activity</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>Login</td>
                            <td>2023-12-01</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>Update Profile</td>
                            <td>2023-12-01</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/footer'); ?>