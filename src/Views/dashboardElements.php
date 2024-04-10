<style>
    .box-button {
        cursor: pointer;
        height: 120px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<div style="margin-top: 40vh;"></div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary rounded-3" id="all-events">
                <div class="card-body text-center text-white box-button">
                    <h5 class="card-title text-white">All Events</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary rounded-3" id="all-users">
                <div class="card-body text-center text-white box-button">
                    <h5 class="card-title text-white">All Users</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary rounded-3" id="add-event">
                <div class="card-body text-center text-white box-button">
                    <h5 class="card-title text-white">Add Event</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary rounded-3" id="all-tickets">
                <div class="card-body text-center text-white box-button">
                    <h5 class="card-title text-white">All Tickets</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom: 50vh;"></div>
<script>
    // Get references to each card div
    const allEventsDiv = document.querySelector('#all-events');
    const allUsersDiv = document.querySelector('#all-users');
    const addEventDiv = document.querySelector('#add-event');
    const allTicketsDiv = document.querySelector('#all-tickets');

    allEventsDiv.addEventListener('click', function() {
        window.location.href = 'all_events';
    });

    allUsersDiv.addEventListener('click', function() {
        window.location.href = 'all_users';
    });

    addEventDiv.addEventListener('click', function() {
        window.location.href = 'event_addition';
    });

    allTicketsDiv.addEventListener('click', function() {
        window.location.href = 'all_tickets';
    });
</script>
