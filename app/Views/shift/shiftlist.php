<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Shift Menu List
                <button class="btn btn-primary btn-sm float-end btnAddRole" data-bs-toggle="modal"
                    data-bs-target="#formRoleModal">Create New Shift</button>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Id</th>
                        <th>Shift Name</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach($Shifts as $shifts): ?>
                        <tr>
                            <td><?= $shifts['id'] ?></td>
                            <td><?= $shifts['shift_name'] ?></td>
                            <td><?= $shifts['start_time'] ?></td>
                            <td><?= $shifts['end_time'] ?></td>
                            <td><?= $shifts['created_by'] ?></td>
                            <td><?= $shifts['created_at'] ?></td>
                            <td><?= $shifts['updated_at'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#formRoleModal"
                                    onclick="editShift(<?= $shifts['id'] ?>)">Update</button>
                                <form action="<?= base_url('shift/deleteShifts/' . $shifts['id']) ?>" method="post"
                                    style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this shift?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formRoleModal" tabindex="-1" aria-labelledby="formUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="formUserModalLabel">Create New Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="shiftForm" action="<?= base_url('shift/createShifts'); ?>" method="post">
                <input type="hidden" name="inputShiftsID" id="inputShiftsID">
                <div class="form-group">
                    <label for="inputShiftName">Shift Name</label>
                    <input type="text" class="form-control" name="inputShiftName" id="inputShiftName" required>
                </div>
                <div class="form-group">
                    <label for="inputStartTime">Start Time</label>
                    <input type="time" class="form-control" name="inputStartTime" id="inputStartTime" required>
                </div>
                <div class="form-group">
                    <label for="inputEndTime">End Time</label>
                    <input type="time" class="form-control" name="inputEndTime" id="inputEndTime" required>
                </div>
                <div class="form-group">
                    <input type="hidden" value="<?= $user['id']; ?>" class="form-control" name="inputCreatedBy"
                        id="inputCreatedBy">
                </div>
                <div class="form-group">
                    <label for="inputCreatedAt">Created At</label>
                    <input type="datetime-local" class="form-control" name="inputCreatedAt" id="inputCreatedAt"
                        value="<?= date('Y-m-d\TH:i'); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="inputUpdatedAt">Updated At</label>
                    <input type="datetime-local" class="form-control" name="inputUpdatedAt" id="inputUpdatedAt"
                        value="<?= date('Y-m-d\TH:i'); ?>" readonly>
                </div>
                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-primary" type="submit">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editShift(id) {
    $.ajax({
        url: "<?= base_url('shift/getShiftData/'); ?>" + id,
        type: 'GET',
        success: function(response) {
            const shift = JSON.parse(response);
            $('#inputShiftsID').val(shift.id);
            $('#inputShiftName').val(shift.shift_name);
            $('#inputStartTime').val(shift.start_time);
            $('#inputEndTime').val(shift.end_time);
            $('#inputCreatedBy').val(shift.created_by);
            $('#inputCreatedAt').val(shift.created_at);
            $('#inputUpdatedAt').val(shift.updated_at);
            $('#shiftForm').attr('action', "<?= base_url('shift/updateShifts'); ?>");
        }
    });
}
</script>
<?= $this->endSection(); ?>