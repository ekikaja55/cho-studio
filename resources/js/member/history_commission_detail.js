function submitReview(commissionId, revisionNotes, type) {
    var title = type === "accept" ? "Work Approved!" : "Revision Sent!";
    var message =
        type === "accept"
            ? "Your approval has been recorded! The artist will now proceed to the next stage of the commission. We'll notify you upon their next progress update."
            : "Your revision request has been sent to the artist. They will begin working on the changes and upload the updated progress soon. You'll be notified when it's ready for review.";

    $.ajax({
        url: `/member/history/commission/review/${commissionId}`,
        type: "POST",
        data: {
            revision_notes: revisionNotes,
            type: type,
        },
        beforeSend: function (xhr) {
            // disable buttons to prevent multiple submissions
            $("#submit-revision-btn").prop("disabled", true);
            $("#accept-work-btn").prop("disabled", true);

            // show loading indicator
            Swal.fire({
                title: "Processing...",
                text: "Please wait while we process your request.",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
        },
        success: function (response) {
            Swal.fire({
                title: title,
                text: message,
                icon: "success",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            setTimeout(() => location.reload(), 1000);
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: "Error",
                text: "There was an error processing your request. Please try again later.",
                icon: "error",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
        },
    });
}

$(document).ready(function () {
    // Toggle the visibility of the revision form when the button is clicked
    $("#revision-toggle-btn").click(function () {
        // Check if the form is currently hidden (using the Tailwind 'hidden' class)
        if ($("#revision-form-area").hasClass("hidden")) {
            // Remove 'hidden' class first so jQuery can calculate dimensions for slideDown
            $("#revision-form-area")
                .removeClass("hidden")
                .hide()
                .slideDown(300);
            $("#revision-form-area").find("textarea").focus();
        } else {
            // If it's visible, slide it up and then re-add the 'hidden' class
            $("#revision-form-area").slideUp(300, function () {
                $(this).addClass("hidden");
                $("#revision-notes-textarea").val(""); // Clear content when hiding
            });
        }
    });

    // Handle the submission of the revision request
    $("#submit-revision-btn").click(function () {
        var commissionId = $(this).data("commission-id");
        var revisionNotes = $("#revision-notes-textarea").val().trim();
        if (revisionNotes === "") {
            Swal.fire({
                title: "Revision Notes Required",
                text: "Please provide revision notes before submitting.",
                icon: "error",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            return;
        }
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to request a revision. This action cannot be undone.",
            icon: "question",
            showCancelButton: true,
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
                confirmButton: "custom-swal-success-button",
                cancelButton: "custom-swal-cancel-button",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                submitReview(commissionId, revisionNotes, "revision");
            }
        });
    });

    $("#accept-work-btn").click(function () {
        if (!$("#revision-form-area").hasClass("hidden")) {
            $("#revision-form-area").slideUp(300, function () {
                $(this).addClass("hidden");
            });
        }

        var commissionId = $(this).data("commission-id");

        Swal.fire({
            title: "Are you sure?",
            text: "You are about to agree to the current work. This action cannot be undone.",
            icon: "question",
            showCancelButton: true,
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
                confirmButton: "custom-swal-success-button",
                cancelButton: "custom-swal-cancel-button",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                submitReview(commissionId, "", "accept");
            }
        });
    });
});
