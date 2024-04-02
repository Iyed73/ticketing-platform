<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search For Events:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <?php include 'prefix.php' ?>
                <form class="input-group w-75 mx-auto d-flex" action=<?= "{$prefix}/search" ?> method="POST">
                    <input type="search" class="form-control p-3" placeholder="Search for events, organizers, venues..."
                        aria-describedby="search-icon-1" name="searchInput" required>
                    <button type="submit" id="search-icon-1" class="input-group-text p-3"><i
                            class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>