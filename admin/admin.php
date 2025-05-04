<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reject Applicant Modal</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .reason-btn.selected {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container text-center mt-5">
        <h2>Rejection Modal Demo</h2>
        <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalGiuliani">
            <i class="fas fa-times"></i> Open Rejection Modal
        </button>
    </div>

    <!-- Rejection Modal -->
    <div class="modal fade" id="deleteModalGiuliani" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reject Applicant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    This action will reject the applicant. Do you want to continue?
                    <form>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Reason:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                            <div class="suggested-reasons mt-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm reason-btn">Incomplete application</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm reason-btn">Does not meet qualifications</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm reason-btn">Failed background check</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.reason-btn').forEach(button => {
            button.addEventListener('click', function() {
                const textarea = document.getElementById('message-text');
                const newReason = this.innerText;
                let currentTextArray = textarea.value.split(", ").filter(reason => reason.trim() !== "");

                const index = currentTextArray.indexOf(newReason);
                if (index > -1) {
                    currentTextArray.splice(index, 1);
                    this.classList.remove('selected');
                } else {
                    currentTextArray.push(newReason);
                    this.classList.add('selected');
                }

                textarea.value = currentTextArray.join(", ");
            });
        });
    </script>

</body>
</html>
