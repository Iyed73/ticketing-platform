<?php $prefix = $_ENV['prefix'];

require "src/Models/CategoryModel.php";

$categoryRepo = new CategoryModel();
$categories = $categoryRepo->findAll();

$eventData = $_SESSION['eventData'];

$error = $_SESSION['error'] ?? null;

unset($_SESSION['error']);
?>


<div class = "container py-5">

    <div style="margin-top: 20vh;"></div>
    <?php if ($error): ?>
        <div class="alert alert-danger text-center mb-5" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="<?="{$prefix}/event_update"?>" method="post" enctype="multipart/form-data" style = "margin-top: 30vh">
        <input type="hidden" name="id" value="<?= $eventData ? $eventData->id: '' ?>">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="name" value="<?= $eventData ? $eventData->name : '' ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Venue</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="venue" value="<?= $eventData ? $eventData->venue : '' ?>">
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Category</label>
            <div class="col-sm-6">
                <select class="form-select" aria-label="Categories" name="category">
                    <option selected disabled>Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->name ?>" <?= $eventData && $category->name == $eventData->category ? 'selected' : '' ?>>
                            <?= $category->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Date</label>
            <div class = "col-sm-6">
                <input type="date" class="form-control" name="eventDate" value="<?= $eventData ? $eventData->eventDate : '' ?>">
            </div>
        </div>

        <div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Short Description</label>
            <div class = "col-sm-6">
                <input type="text" class="form-control" name="shortDescription" value="<?= $eventData ? $eventData->shortDescription : '' ?>">
            </div>
        </div>

        <div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Long Description</label>
            <div class = "col-sm-6">
                <input type="text" class="form-control" name="longDescription" value="<?= $eventData ? $eventData->longDescription : '' ?>">
            </div>
        </div>

        <div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Organizer</label>
            <div class = "col-sm-6">
                <input type="text" class="form-control" name="organizer" value="<?= $eventData ? $eventData->organizer : '' ?>">
            </div>
        </div>

        <div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Start-Sell Time</label>
            <div class = "col-sm-6">
                <input type="date" class="form-control" name="startSellTime" value="<?= $eventData ? $eventData->startSellTime : '' ?>">
            </div>
        </div>

        <div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Total Tickets</label>
            <div class = "col-sm-6">
                <input type="number" class="form-control" name="totalTickets" value="<?= $eventData ? $eventData->totalTickets : '' ?>">
            </div>
        </div>

        <div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Available Tickets</label>
            <div class = "col-sm-6">
                <input type="number" class="form-control" name="availableTickets" value="<?= $eventData ? $eventData->availableTickets : '' ?>">
            </div>
        </div>

        <div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Ticket Price</label>
            <div class = "col-sm-6">
                <input type="number" class="form-control" name="ticketPrice" value="<?= $eventData ? $eventData->ticketPrice : '' ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Image</label>
            <div class="col-sm-6">
                <input type="hidden" name="imagePath" value="<?= $eventData ? $eventData->imagePath: '' ?>">
                <input type="file" class="form-control" name="image" id="image" placeholder="Select image">
            </div>
        </div>

        <div class = "row mb-3">
            <div class = "offset-sm-3 col-sm-3 d-grid">
                <button type = "submit" value ="register" class = "btn btn-primary text-white">Submit</button>
            </div>
            <div class = "col-sm-3 d-grid">
                <a class = "btn btn-outline-primary" href = "<?="{$prefix}/all_events"?>" role = "button">Cancel</a>
            </div>
        </div>
    </form>
</div>
