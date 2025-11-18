function setCommissionStatus(commissionId, status) {
    $.ajax({
        url: `/artist/commissions/status/${commissionId}`,
        type: "POST",
        data: {
            status: status,
            // No need to manually include _token anymore
            // The global $.ajaxSetup in app.js handles X-CSRF-TOKEN header automatically
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Success!",
                text:
                    "Updated Commission Status to '" +
                    getProgressStatusText(status) +
                    "'. Reloading...",
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
                icon: "error",
                title: "Error!",
                text: "An error occurred while updating the commission status.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            console.error("Status update error:", xhr.responseJSON || error);
        },
    });
}

function getProgressStatusText(status) {
    const statusTexts = {
        pending: "Pending",
        accepted: "Accepted",
        declined: "Declined",
        in_progress_sketch: "Sketching",
        in_progress_coloring: "Coloring",
        review: "In Review",
        revision: "Revision",
        completed: "Completed",
        cancelled: "Cancelled",
    };
    return statusTexts[status] || "Unknown";
}

function getPaymentStatusText(status) {
    const paymentTexts = {
        unpaid: "Unpaid",
        dp: "DP",
        paid: "Paid",
        refunded: "Refunded",
    };
    return paymentTexts[status] || "Unknown";
}

$(document).ready(function () {
    const $refImageModal = $("#ref-image-modal");
    const $modalContent = $refImageModal.find(".modal-content");
    const animationSpeed = 150;

    $modalContent.hide();
    $refImageModal.hide();

    // --- Open Modal Logic ---
    $("#view_ref_image").click(function () {
        $refImageModal.fadeIn(animationSpeed, function () {
            $modalContent.slideDown(animationSpeed);
        });
    });

    // --- Close Modal Logic (using SlideUp) ---
    $("#close-ref-image-modal").click(function () {
        $modalContent.slideUp(animationSpeed, function () {
            $refImageModal.fadeOut(animationSpeed);
        });
    });

    // Optional: Close modal when clicking outside of the content (using FadeOut)
    $refImageModal.click(function (event) {
        if (event.target.id === "ref-image-modal") {
            $modalContent.slideUp(animationSpeed, function () {
                $refImageModal.fadeOut(animationSpeed);
            });
        }
    });

    $("#accept-commission-btn").click(function () {
        const commissionId = $(this).data("commission-id");

        Swal.fire({
            title: "Accept Commission?",
            text: "Are you sure you want to accept this request?",
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
            // If the user clicked "Yes"
            if (result.isConfirmed) {
                setCommissionStatus(commissionId, "accepted");
            }
        });
    });

    $("#decline-commission-btn").click(function () {
        const commissionId = $(this).data("commission-id");

        Swal.fire({
            title: "Decline Commission?",
            text: "Are you sure you want to decline this request? This action cannot be undone.",
            icon: "warning", // Use a warning icon for declining
            showCancelButton: true,
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
                confirmButton: "custom-swal-danger-button",
                cancelButton: "custom-swal-cancel-button",
            },
        }).then((result) => {
            // If the user clicked "Yes"
            if (result.isConfirmed) {
                setCommissionStatus(commissionId, "declined");
            }
        });
    });

    $("#update-progress-btn").click(function () {
        const status = $("#update-progress-select").val();
        const commissionId = $(this).data("commission-id");
        setCommissionStatus(commissionId, status);
    });

    // Handle payment status update
    $("#update-payment-btn").click(function () {
        const paymentStatus = $("#update-payment-select").val();
        const commissionId = $(this).data("commission-id");

        // add a confirmation swal
        Swal.fire({
            title: "Are you sure?",
            text:
                "You are about to update the payment status to '" +
                getPaymentStatusText(paymentStatus) +
                "'.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, update it!",
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
                confirmButton: "custom-swal-success-button",
                cancelButton: "custom-swal-cancel-button",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with AJAX update

                // Disable button during submission
                $(this)
                    .prop("disabled", true)
                    .html(
                        '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...</div>'
                    );

                $.ajax({
                    url: `/artist/commissions/payment/${commissionId}`,
                    type: "POST",
                    data: {
                        payment_status: paymentStatus,
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text:
                                "Updated Payment Status to '" +
                                getPaymentStatusText(paymentStatus) +
                                "'. Reloading...",
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
                            icon: "error",
                            title: "Error!",
                            text: "An error occurred while updating the payment status.",
                            customClass: {
                                popup: "custom-swal-popup",
                                title: "custom-swal-title",
                                htmlContainer: "custom-swal-text",
                            },
                        });
                        console.error(
                            "Payment status update error:",
                            xhr.responseJSON || error
                        );
                        $("#update-payment-btn")
                            .prop("disabled", false)
                            .html(
                                '<div class="flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Save</div>'
                            );
                    },
                });
            }
        });
    });

    // Toggle price edit mode
    $("#edit-price-btn").click(function () {
        $("#price-display-mode").hide();
        $("#price-edit-mode").removeClass("hidden").hide().slideDown(200);
        $("#commission-price-input").focus();
    });

    // Cancel price edit
    $("#cancel-price-edit-btn").click(function () {
        const originalValue = $("#commission-price-input").data("raw-value");
        $("#commission-price-input").val(formatRupiah(originalValue));

        $("#price-edit-mode").slideUp(200, function () {
            $(this).addClass("hidden");
            $("#price-display-mode").fadeIn(200);
        });
    });

    // Format price input as Rupiah
    $("#commission-price-input").on("input", function () {
        let value = $(this).val().replace(/\./g, ""); // Remove existing dots
        value = value.replace(/\D/g, ""); // Remove non-digits

        if (value) {
            $(this).val(formatRupiah(value));
            $(this).data("raw-value", value);
        } else {
            $(this).val("");
            $(this).data("raw-value", "0");
        }
    });

    // Handle price update
    $("#update-price-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        const newPrice = parseRupiah($("#commission-price-input").val());

        if (!newPrice || newPrice <= 0) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Price",
                text: "Please enter a valid price.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            $("#commission-price-input").focus();
            return;
        }

        // Disable button during submission
        $(this)
            .prop("disabled", true)
            .html(
                '<svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>'
            );

        $.ajax({
            url: `/artist/commissions/price/${commissionId}`,
            type: "POST",
            data: {
                price: newPrice,
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text:
                        "Price updated to Rp " +
                        formatRupiah(newPrice) +
                        ". Reloading...",
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
                    icon: "error",
                    title: "Update Failed",
                    text: "An error occurred while updating the price.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                console.error("Price update error:", xhr.responseJSON || error);
                $("#update-price-btn")
                    .prop("disabled", false)
                    .html(
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
                    );
            },
        });
    });

    // Toggle deadline edit mode
    $("#edit-deadline-btn").click(function () {
        $("#deadline-display-mode").hide();
        $("#deadline-edit-mode").removeClass("hidden").hide().slideDown(200);
        $("#commission-deadline-input").focus();
    });

    // Cancel deadline edit
    $("#cancel-deadline-edit-btn").click(function () {
        const originalValue = $("#commission-deadline-input").data("raw-value");
        $("#commission-deadline-input").val(originalValue);

        $("#deadline-edit-mode").slideUp(200, function () {
            $(this).addClass("hidden");
            $("#deadline-display-mode").fadeIn(200);
        });
    });

    // Handle deadline update
    $("#update-deadline-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        const newDeadline = $("#commission-deadline-input").val();

        if (!newDeadline || newDeadline.trim() === "") {
            Swal.fire({
                icon: "warning",
                title: "Invalid Deadline",
                text: "Please enter a valid deadline.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            $("#commission-deadline-input").focus();
            return;
        }

        // Disable button during submission
        $(this)
            .prop("disabled", true)
            .html(
                '<svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>'
            );

        $.ajax({
            url: `/artist/commissions/deadline/${commissionId}`,
            type: "POST",
            data: {
                deadline: newDeadline,
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Deadline updated. Reloading...",
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
                    icon: "error",
                    title: "Update Failed",
                    text: "An error occurred while updating the deadline.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                console.error(
                    "Deadline update error:",
                    xhr.responseJSON || error
                );
                $("#update-deadline-btn")
                    .prop("disabled", false)
                    .html(
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
                    );
            },
        });
    });

    // handle file input change for progress upload
    $("#progress-file-input").change(function () {
        const fileName = $(this).val().split("\\").pop();
        const fileNameDiv = $("#file-name");

        if (fileName) {
            fileNameDiv
                .text(fileName)
                .removeClass("hidden")
                .hide()
                .slideDown(200);
        } else {
            fileNameDiv.slideUp(200, function () {
                $(this).addClass("hidden");
            });
        }
    });

    $("#progress-upload-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        const fileInput = $("#progress-file-input")[0];

        if (fileInput.files.length === 0) {
            Swal.fire({
                icon: "error",
                title: "No File Selected",
                text: "Please select a file to upload.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            return;
        }

        const formData = new FormData();
        formData.append("image", fileInput.files[0]);
        // Let backend determine stage automatically

        // Disable button during submission
        $(this)
            .prop("disabled", true)
            .html(
                '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Uploading...</div>'
            );

        $.ajax({
            url: `/artist/commissions/upload/${commissionId}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Progress image uploaded successfully. Reloading...",
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
                    icon: "error",
                    title: "Upload Failed",
                    text:
                        xhr.responseJSON?.message ||
                        "An error occurred while uploading the progress image.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                console.error(
                    "Progress upload error:",
                    xhr.responseJSON || error
                );
                $("#progress-upload-btn")
                    .prop("disabled", false)
                    .html(
                        '<div class="flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Upload</div>'
                    );
            },
        });
    });

    // handle file input change for revision upload
    $("#revision-file-input").change(function () {
        const fileName = $(this).val().split("\\").pop();
        const fileNameDiv = $("#revision-file-name");

        if (fileName) {
            fileNameDiv
                .text(fileName)
                .removeClass("hidden")
                .hide()
                .slideDown(200);
        } else {
            fileNameDiv.slideUp(200, function () {
                $(this).addClass("hidden");
            });
        }
    });

    $("#revision-upload-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        const fileInput = $("#revision-file-input")[0];

        if (fileInput.files.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No File Selected",
                text: "Please select a file to upload.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            return;
        }

        const formData = new FormData();
        formData.append("image", fileInput.files[0]);
        formData.append("stage", "sketch_revision"); // Explicitly mark as revision

        // Disable button during submission
        $(this)
            .prop("disabled", true)
            .html(
                '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Uploading...</div>'
            );

        $.ajax({
            url: `/artist/commissions/upload/${commissionId}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Revision image uploaded successfully. Reloading...",
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
                    icon: "error",
                    title: "Upload Failed",
                    text:
                        xhr.responseJSON?.message ||
                        "An error occurred while uploading the revision image.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                console.error(
                    "Revision upload error:",
                    xhr.responseJSON || error
                );
                $("#revision-upload-btn")
                    .prop("disabled", false)
                    .html(
                        '<div class="flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Upload</div>'
                    );
            },
        });
    });

    // Handle cancel commission button
    $("#cancel-commission-btn").click(function () {
        const section = $("#cancellation-reason-section");
        section.toggleClass("hidden");

        // Add smooth slide animation
        if (!section.hasClass("hidden")) {
            section.hide().removeClass("hidden").slideDown(300);
            $("#cancellation-reason-textarea").focus();
        }
    });

    // Handle cancel button in the cancellation section
    $("#cancel-cancellation-btn").click(function () {
        $("#cancellation-reason-section").slideUp(300, function () {
            $(this).addClass("hidden");
            $("#cancellation-reason-textarea").val("");
        });
    });

    // Handle submit cancellation
    $("#submit-cancellation-btn").click(function () {
        // add confirmation
        Swal.fire({
            title: "Cancel Commission?",
            text: "Are you sure you want to cancel this commission? This action cannot be undone.",
            icon: "question",
            showCancelButton: true,
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
                confirmButton: "custom-swal-danger-button",
                cancelButton: "custom-swal-cancel-button",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const commissionId = $("#cancel-commission-btn").data(
                    "commission-id"
                );
                const reason = $("#cancellation-reason-textarea").val().trim();

                if (!reason || reason.length === 0 || reason === "") {
                    Swal.fire({
                        icon: "warning",
                        title: "Cancellation Reason Required",
                        text: "Please provide a cancellation reason.",
                        customClass: {
                            popup: "custom-swal-popup",
                            title: "custom-swal-title",
                            htmlContainer: "custom-swal-text",
                        },
                    });
                    $("#cancellation-reason-textarea").focus();
                    return;
                }

                // Disable button during submission
                $(this)
                    .prop("disabled", true)
                    .html(
                        '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...</div>'
                    );

                $.ajax({
                    url: `/artist/commissions/cancel/${commissionId}`,
                    type: "POST",
                    data: {
                        cancellation_reason: reason,
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Commission cancelled successfully. Reloading...",
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
                            icon: "error",
                            title: "Cancellation Failed",
                            text: "An error occurred while cancelling the commission.",
                            customClass: {
                                popup: "custom-swal-popup",
                                title: "custom-swal-title",
                                htmlContainer: "custom-swal-text",
                            },
                        });
                        console.error(
                            "Cancellation error:",
                            xhr.responseJSON || error
                        );
                        $("#submit-cancellation-btn")
                            .prop("disabled", false)
                            .html(
                                '<div class="flex items-center justify-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Confirm Cancellation</div>'
                            );
                    },
                });
            }
        });
    });
});
