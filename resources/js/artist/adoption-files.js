$(document).ready(function () {
    let selectedFiles = [];

    // Handle file selection
    $("#delivery-files-input").on("change", function (e) {
        selectedFiles = Array.from(e.target.files);
        displaySelectedFiles();
    });

    function displaySelectedFiles() {
        const listContainer = $("#selected-files-list");
        
        if (selectedFiles.length === 0) {
            listContainer.addClass("hidden");
            $("#upload-files-btn").addClass("hidden");
            return;
        }

        listContainer.removeClass("hidden");
        $("#upload-files-btn").removeClass("hidden");

        let html = "";
        selectedFiles.forEach((file, index) => {
            const sizeMB = (file.size / 1024 / 1024).toFixed(2);
            html += `
                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900">${file.name}</p>
                            <p class="text-xs text-gray-500">${sizeMB} MB</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile(${index})" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
        });

        listContainer.html(html);
    }

    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        displaySelectedFiles();
    };

    // Upload files
    $("#upload-files-btn").on("click", function () {
        const adoptionId = $(this).data("adoption-id");
        
        if (selectedFiles.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No Files Selected",
                text: "Please select files to upload.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            return;
        }

        const formData = new FormData();
        selectedFiles.forEach((file) => {
            formData.append("files[]", file);
        });

        $(this).prop("disabled", true).html(
            '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Uploading...</div>'
        );

        $.ajax({
            url: `/artist/adoptions/upload/${adoptionId}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: response.message,
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Upload Failed",
                    text: xhr.responseJSON?.message || "An error occurred while uploading files.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                $("#upload-files-btn").prop("disabled", false).html(
                    '<div class="flex items-center justify-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>Upload Files</div>'
                );
            },
        });
    });

    // Delete file
    window.deleteFile = function(filename) {
        const adoptionId = $("#upload-files-btn").data("adoption-id");
        
        Swal.fire({
            title: "Delete File?",
            text: "This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/artist/adoptions/files/${adoptionId}`,
                    type: "DELETE",
                    data: { filename: filename },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Deleted!",
                            text: response.message,
                            customClass: {
                                popup: "custom-swal-popup",
                                title: "custom-swal-title",
                                htmlContainer: "custom-swal-text",
                            },
                        });
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Delete Failed",
                            text: xhr.responseJSON?.message || "An error occurred.",
                            customClass: {
                                popup: "custom-swal-popup",
                                title: "custom-swal-title",
                                htmlContainer: "custom-swal-text",
                            },
                        });
                    },
                });
            }
        });
    };

    // Mark as delivered
    $("#mark-delivered-btn").on("click", function () {
        const adoptionId = $(this).data("adoption-id");
        const deliveryNotes = $("#delivery-notes-textarea").val();

        Swal.fire({
            title: "Mark as Delivered?",
            text: "This will send an email to the customer with download links.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#10b981",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Yes, send email!",
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).prop("disabled", true).html(
                    '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Sending...</div>'
                );

                $.ajax({
                    url: `/artist/adoptions/deliver/${adoptionId}`,
                    type: "POST",
                    data: { delivery_notes: deliveryNotes },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: response.message,
                            customClass: {
                                popup: "custom-swal-popup",
                                title: "custom-swal-title",
                                htmlContainer: "custom-swal-text",
                            },
                        });
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Failed",
                            text: xhr.responseJSON?.message || "An error occurred.",
                            customClass: {
                                popup: "custom-swal-popup",
                                title: "custom-swal-title",
                                htmlContainer: "custom-swal-text",
                            },
                        });
                        $("#mark-delivered-btn").prop("disabled", false).html(
                            '<div class="flex items-center justify-center gap-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Mark as Delivered & Send Email</div>'
                        );
                    },
                });
            }
        });
    });
});
