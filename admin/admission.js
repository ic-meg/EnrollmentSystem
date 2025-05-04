$(document).ready(function(){
    $(".confirm-reject-btn").click(function(){
        var userID = $(this).data("userid"); // Get user ID
        var reason = $("#message-text" + userID).val().trim(); // Get the reason text

        if(reason === "") {
            alert("Please provide a reason for rejection.");
            return;
        }

        $.ajax({
            url: "reject.php",
            type: "POST",
            data: { userID: userID, reason: reason },
            success: function(response) {
                if(response.trim() === "success") {
                    alert("Application rejected successfully.");
                    location.reload(); 
                } else {
                    alert("Error: " + response);
                }
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".reason-btn").forEach(button => {
        button.addEventListener("click", function () {
            let modal = this.closest(".modal"); 
            let textarea = modal.querySelector("textarea"); 
            let newReason = this.innerText.trim();

            let currentReasons = textarea.value.split(", ").filter(reason => reason.trim() !== "");
            const index = currentReasons.indexOf(newReason);

            if (index > -1) {
              
                currentReasons.splice(index, 1);
                this.classList.remove("selected");
            } else {
               
                currentReasons.push(newReason);
                this.classList.add("selected");
            }

            textarea.value = currentReasons.join(", ");
        });
    });

    function checkAndUpdateReasons(modal) {
        let textarea = modal.querySelector("textarea");
        let currentTextArray = textarea.value.split(", ").filter(reason => reason.trim() !== "");

        modal.querySelectorAll(".reason-btn").forEach(button => {
            if (currentTextArray.includes(button.innerText.trim())) {
                button.classList.add("selected");
            } else {
                button.classList.remove("selected");
            }
        });
    }

    // Attach modal show event listener to update button states
    document.querySelectorAll(".modal").forEach(modal => {
        modal.addEventListener("shown.bs.modal", function () {
            checkAndUpdateReasons(this);
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".reject-btn").forEach(button => {
        button.addEventListener("click", function () {
            let userID = this.getAttribute("data-userid");
            let userName = this.getAttribute("data-username");
            let status = this.getAttribute("data-status");

            if (status === "Rejected") {
                // Show "Already Rejected" modal
                let rejectedModal = new bootstrap.Modal(document.getElementById("alreadyRejectedModal"));
                document.getElementById("alreadyRejectedText").innerText = `You have already rejected ${userName}'s application.`;
                rejectedModal.show();
            } else {
                
                let rejectModal = new bootstrap.Modal(document.getElementById(`deleteModal${userID}`));
                rejectModal.show();
            }
        });
    });
})