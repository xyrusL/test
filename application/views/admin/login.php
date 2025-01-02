<style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #e1e1e1;
        }
        .card {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .card-body {
            color: #e1e1e1;
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e1e1e1;
        }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
        }
        .form-control::placeholder {
            color: #a0a0a0;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0056b3 0%, #007bff 100%);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #004494 0%, #0056b3 100%);
            transform: translateY(-1px);
        }
        .form-check-label {
            color: #e1e1e1;
        }
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.2);
            color: #ff6b6b;
        }
    </style>
</head>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4">Admin Login</h4>
                    <form action="<?php echo base_url('auth/process_login'); ?>" method="POST">
                        <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="username_email" name="username_email" placeholder="Email address or Username" required>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                    </form>
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger mt-3">
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>