$(function () {
    // Client-side cache for fetched item details
    var galleryItemCache = {};
    // currently selected item (full JSON from server)
    var currentSelectedId = "";
    var currentSelectedData = null;

    // global handler for broken images — keep layout and show a subtle overlay "Image broken"
    window.handleBrokenImage = function (img) {
        try {
            if (!img) return;
            // prevent repeated onerror firing
            img.onerror = null;

            const container = img.parentElement;
            if (container) {
                // ensure the container can host an absolute overlay
                if (getComputedStyle(container).position === "static") {
                    container.style.position = "relative";
                }

                // don't create duplicate overlays
                if (!container.querySelector(".broken-overlay")) {
                    const overlay = document.createElement("div");
                    overlay.className = "broken-overlay";
                    overlay.textContent = "Image broken";
                    container.appendChild(overlay);
                }

                // dim the broken image but keep its box (avoid changing DOM structure)
                img.style.opacity = "0.25";
                img.style.objectFit = "contain";
            }

            console.warn(
                "Broken image detected:",
                img.dataset?.originalSrc || img.src
            );
        } catch (e) {
            console.error("handleBrokenImage error", e);
        }
    };

    // --- Utility functions ---
    function updatePreview({
        id = "",
        title = "",
        price = "",
        image = "",
        format = "",
    } = {}) {
        if (title) $("#previewTitle").text(title);

        // price bisa berformat "Rp ..." atau angka
        if (price) {
            if (String(price).trim().startsWith("Rp")) {
                $("#previewPrice").text(price);
            } else if (!isNaN(Number(price))) {
                $("#previewPrice").text(
                    "Rp " + Number(price).toLocaleString("id-ID")
                );
            } else {
                $("#previewPrice").text(price);
            }
        }

        // format: ambil param format atau dataset format
        var $previewFormatEl = $("#previewFormat");
        if (format && format !== "") {
            $previewFormatEl.text(format);
        } else {
            $previewFormatEl.text("-");
        }

        var $previewImage = $("#previewImage");
        if (image) {
            $previewImage.attr("src", image).removeClass("hidden");
            $("#previewPlaceholder").addClass("hidden");
        }

        $("#buyButton").prop("disabled", false);
        if (id !== "") $("#gallery_id").val(id);
    }

    // preview modal controls
    $("#previewFullImageButton").on("click", function () {
        const previewImageSrc = $("#previewImage").attr("src");
        if (previewImageSrc && previewImageSrc !== "") {
            $("#preview-image-modal img").attr("src", previewImageSrc);
            $("#preview-image-modal").show();
        }
    });

    $("#close-preview-image-modal").on("click", function () {
        $("#preview-image-modal").hide();
    });

    // --- Main click handler for all items (delegated) ---
    $(document).on("click", ".showcase-item, .design-item", function (e) {
        var $wrapper = $(this);
        var id = $wrapper.attr("data-id") || "";
        if (!id) return;

        // If we already have data cached, use it
        if (galleryItemCache[id]) {
            var data = galleryItemCache[id];
            currentSelectedId = id;
            currentSelectedData = data;
            updatePreview({
                id: data.id,
                title: data.title,
                price: data.price,
                image: data.image_url,
                format: data.file_format,
            });

            // handle disabled state for reserved/sold
            if (
                $wrapper.hasClass("design-item") &&
                (data.status === "reserved" ||
                    data.status === "sold" ||
                    data.is_paid)
            ) {
                $("#buyButton")
                    .prop("disabled", true)
                    .removeClass("bg-[#4c9eff] hover:bg-[#73b7ff]")
                    .addClass("bg-gray-400 cursor-not-allowed");
            } else {
                $("#buyButton")
                    .prop("disabled", false)
                    .removeClass("bg-gray-400 cursor-not-allowed")
                    .addClass("bg-[#4c9eff]");
            }

            return;
        }

        // show quick feedback while loading
        $("#buyButton").prop("disabled", true);

        // Fetch item details from the server (safe, minimal JSON)
        $.getJSON("/gallery/json/" + encodeURIComponent(id))
            .done(function (data) {
                galleryItemCache[id] = data;
                currentSelectedId = id;
                currentSelectedData = data;
                updatePreview({
                    id: data.id,
                    title: data.title,
                    price: data.price,
                    image: data.image_url,
                    format: data.file_format,
                });

                if (
                    $wrapper.hasClass("design-item") &&
                    (data.status === "reserved" ||
                        data.status === "sold" ||
                        data.is_paid)
                ) {
                    $("#buyButton")
                        .prop("disabled", true)
                        .removeClass("bg-[#4c9eff] hover:bg-[#73b7ff]")
                        .addClass("bg-gray-400 cursor-not-allowed");
                } else {
                    $("#buyButton")
                        .prop("disabled", false)
                        .removeClass("bg-gray-400 cursor-not-allowed")
                        .addClass("bg-[#4c9eff]");
                }
            })
            .fail(function () {
                console.error(
                    "Failed to fetch gallery item details for id",
                    id
                );
                $("#buyButton").prop("disabled", true);
            });
    });

    // --- Buy modal handling ---
    $("#buyButton").on("click", function () {
        if ($(this).prop("disabled")) return;

        if (currentSelectedData) {
            $("#modalItemTitle").text(
                currentSelectedData.title || $("#previewTitle").text()
            );
            // ensure price is displayed consistently
            if (
                currentSelectedData.price &&
                String(currentSelectedData.price).trim().startsWith("Rp")
            ) {
                $("#modalItemPrice").text(currentSelectedData.price);
            } else if (
                currentSelectedData.price &&
                !isNaN(Number(currentSelectedData.price))
            ) {
                $("#modalItemPrice").text(
                    "Rp " +
                        Number(currentSelectedData.price).toLocaleString(
                            "id-ID"
                        )
                );
            } else {
                $("#modalItemPrice").text(
                    currentSelectedData.price || $("#previewPrice").text()
                );
            }
            if (currentSelectedData.id)
                $("#gallery_id").val(currentSelectedData.id);

            // populate modal image, format, and status
            if (currentSelectedData.image_url) {
                $("#modalItemImage")
                    .attr("src", currentSelectedData.image_url)
                    .attr(
                        "alt",
                        currentSelectedData.title || "Artwork preview"
                    );
            }
            $("#modalItemFormat").text(currentSelectedData.file_format || "-");
            // status badge styling
            (function setModalStatus(status) {
                var $el = $("#modalItemStatus");
                var s = status ? String(status).toLowerCase() : "unknown";
                $el.text(s.toUpperCase());
                $el.removeClass(
                    "bg-red-200 bg-yellow-200 bg-green-200 bg-gray-200 text-red-800 text-yellow-800 text-green-800 text-gray-800"
                );
                if (s === "sold") {
                    $el.addClass("bg-red-200 text-red-800");
                } else if (s === "reserved") {
                    $el.addClass("bg-yellow-200 text-yellow-800");
                } else if (s === "available" || s === "not_sold") {
                    $el.addClass("bg-green-200 text-green-800");
                } else {
                    $el.addClass("bg-gray-200 text-gray-800");
                }
            })(currentSelectedData.status);

            $("#purchaseModal").removeClass("hidden").show();
            $("#formView").removeClass("hidden");
            $("#thankYouView").addClass("hidden");
            $("#formErrors").html("");
            $("#submitButton").prop("disabled", false);
            return;
        }

        // fallback: try to fetch before opening
        var fallbackId = $("#gallery_id").val() || currentSelectedId;
        if (fallbackId) {
            $.getJSON("/gallery/json/" + encodeURIComponent(fallbackId))
                .done(function (data) {
                    galleryItemCache[fallbackId] = data;
                    currentSelectedData = data;
                    $("#modalItemTitle").text(
                        data.title || $("#previewTitle").text()
                    );
                    if (
                        data.price &&
                        String(data.price).trim().startsWith("Rp")
                    ) {
                        $("#modalItemPrice").text(data.price);
                    } else if (data.price && !isNaN(Number(data.price))) {
                        $("#modalItemPrice").text(
                            "Rp " + Number(data.price).toLocaleString("id-ID")
                        );
                    } else {
                        $("#modalItemPrice").text(
                            data.price || $("#previewPrice").text()
                        );
                    }
                    if (data.id) $("#gallery_id").val(data.id);
                    // populate image, format, status from fetched data as well
                    if (data.image_url) {
                        $("#modalItemImage")
                            .attr("src", data.image_url)
                            .attr("alt", data.title || "Artwork preview");
                    }
                    $("#modalItemFormat").text(data.file_format || "-");
                    (function setModalStatus(status) {
                        var $el = $("#modalItemStatus");
                        var s = status
                            ? String(status).toLowerCase()
                            : "unknown";
                        $el.text(s.toUpperCase());
                        $el.removeClass(
                            "bg-red-200 bg-yellow-200 bg-green-200 bg-gray-200 text-red-800 text-yellow-800 text-green-800 text-gray-800"
                        );
                        if (s === "sold") {
                            $el.addClass("bg-red-200 text-red-800");
                        } else if (s === "reserved") {
                            $el.addClass("bg-yellow-200 text-yellow-800");
                        } else if (s === "available" || s === "not_sold") {
                            $el.addClass("bg-green-200 text-green-800");
                        } else {
                            $el.addClass("bg-gray-200 text-gray-800");
                        }
                    })(data.status);

                    $("#purchaseModal").removeClass("hidden").show();
                })
                .fail(function () {
                    console.error("Failed to fetch item for purchase");
                });
        } else {
            console.warn("Buy clicked but no selected item data available");
        }
    });

    $("#closeModalButton, #finishButton").on("click", function () {
        $("#purchaseModal").hide();
    });

    $("#paymentProof").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        if (fileName) {
            $("#paymentProofName").text(fileName);
        } else {
            $("#paymentProofName").text("No file chosen");
        }
    });

    $("#purchaseForm").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#submitButton").prop("disabled", true);
        $("#formErrors").html("");
        $.ajax({
            url: "/gallery/adopt",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                Swal.fire({
                    title: "Sending...",
                    text: "Please wait while your request is being sent.",
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
                if (response.success) {
                    // sweet alert or simple message
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
                } else {
                    $("#formErrors").html(
                        '<p class="text-red-600">Submission failed. Please try again later.</p>'
                    );
                    $("#submitButton").prop("disabled", false);
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "An error occurred while marking the adoption as completed.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                console.error(
                    "Mark complete error:",
                    xhr.responseJSON || error
                );
            },
        });
    });

    // --- Gallery rotation ---
    var rotationTimer = null;

    function setupGalleryRotation() {
        var $container = $("#galleryShowcaseCustom");
        if ($container.length === 0) return;

        var $wrappers = $container.find(".showcase-item");
        if ($wrappers.length < 2) return;

        // Build rotation items array using data-id and current image src
        var items = $wrappers
            .map(function () {
                var $w = $(this);
                return {
                    id: $w.attr("data-id") || "",
                    src: $w.find("img").attr("src") || "",
                };
            })
            .get();

        function rotateItems() {
            items.unshift(items.pop());
            $wrappers.each(function (i) {
                var $w = $(this);
                var $img = $w.find("img");
                var item = items[i] || {};

                // Update wrapper id and image src (other details will be fetched when needed)
                $w.attr("data-id", item.id);
                $img.css("opacity", "0");
                setTimeout(function () {
                    $img.attr("src", item.src);
                    $img.css("opacity", "1");
                }, 300);
            });
        }

        // Clear existing and start new interval
        if (rotationTimer) clearInterval(rotationTimer);
        rotationTimer = setInterval(rotateItems, 5000);
    }

    // Start rotation
    setupGalleryRotation();
});
