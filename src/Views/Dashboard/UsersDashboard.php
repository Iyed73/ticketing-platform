<?php $prefix = $_ENV['prefix']; ?>

<div class="container-fluid py-5" style="margin-top: 20vh">
    <h2>All Users</h2>
    <br>
    <div class="row d-flex justify-content-center">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Created At</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allUsers as $u): ?>
                <tr>
                    <td><?php echo $u->id; ?></td>
                    <td><?php echo $u->firstname; ?></td>
                    <td><?php echo $u->lastname; ?></td>
                    <td><?php echo $u->email; ?></td>
                    <td><?php echo $u->role; ?></td>
                    <td><?php echo $u->created_at; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav aria-label="page_nav" class="d-flex justify-content-center">
        <ul class="pagination d-inline-flex justify-content-between">
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>


<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });
    });
</script>

<style>
    [data-title]:hover:after {
        opacity: 1;
        transition: all 0.1s ease 0.5s;
        visibility: visible;
    }
    [data-title]:after {
        content: attr(data-title);
        background-color: #FFFFFF;
        color: #111;
        font-size: 80%;
        position: absolute;
        padding: 5px;
        border-radius: 5px;
        bottom: -1.6em;
        left: 100%;
        white-space: nowrap;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        opacity: 0;
        z-index: 99999;
        visibility: hidden;
    }
    [data-title] {
        position: relative;
    }
</style>

