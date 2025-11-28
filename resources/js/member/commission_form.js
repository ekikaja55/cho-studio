// Base prices by category (before any multipliers)
const basePrices = {
    headshot: 40000,
    bustup: 50000,
    halfbody: 65000,
    fullbody: 125000,
};

// Cartoon style prices
const cartoonPrices = {
    bustup: 25000,
    halfbody: 35000,
    fullbody: 50000,
};

const bgPrices = {
    none: 0,
    simple: 5000,
    detailed: 10000,
};

// Function to format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount);
}

// Function to calculate and update price
function updatePrice() {
    const category = $("#category-value").val();
    const style = $("input[name='style']:checked").val() || "normal";
    const background = $("input[name='background']:checked").val() || "none";
    const commercialUse = $("#commercialUse").is(":checked");
    const additionalChars = parseInt($("#additionalChars").val()) || 0;

    // Determine base price
    let basePrice = 0;

    if (category === "headshot") {
        // For headshot, always use the base price regardless of style
        basePrice = basePrices["headshot"];
    } else if (style === "cartoon" && cartoonPrices[category]) {
        // For other categories with cartoon style
        basePrice = cartoonPrices[category];
    } else if (style === "normal" && basePrices[category]) {
        // For other categories with normal style
        basePrice = basePrices[category];
    }

    // Calculate background price
    const bgPrice = bgPrices[background] || 0;

    // Calculate commercial use (150% of base price)
    const commercialPrice = commercialUse ? basePrice * 1.5 : 0;

    // Calculate additional characters (75% of base price each)
    const additionalCharsPrice = additionalChars * (basePrice * 0.75);

    // Calculate total
    const totalPrice =
        basePrice + bgPrice + commercialPrice + additionalCharsPrice;

    // Update UI
    $("#basePrice").text(formatCurrency(basePrice));
    $("#bgPrice").text(formatCurrency(bgPrice));
    $("#commercialPrice").text(formatCurrency(commercialPrice));
    $("#additionalCharsPrice").text(formatCurrency(additionalCharsPrice));
    $("#totalPrice").text(formatCurrency(totalPrice));
    $("#finalPrice").val(totalPrice);
}

$("#imageInput").on("change", function () {
    previewImage(this);
});

function previewImage(input) {
    const $preview = $("#imagePreview");
    const $img = $preview.find("img");

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $img.attr("src", e.target.result);
            $preview.removeClass("hidden");
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $preview.addClass("hidden");
    }
}

function determineCategory() {
    if ($("#category-value").val() == "headshot") {
        return "headshot";
    }
    const style = $("input[name='style']:checked").val();
    // const type = $("input[name='type']:checked").val();
    const categoryTemp = $("#category-temp").val();
    
    let category = "";

    if (style === "cartoon") {
        category = "cartoon_" + categoryTemp;
    } else {
        category = categoryTemp;
    }
    return category;
}

// Event listeners for price updates
$("input[name='style'], input[name='type']").on("change", updatePrice);
$("input[name='background']").on("change", updatePrice);
$("#commercialUse").on("change", updatePrice);
$("#additionalChars").on("input", updatePrice);

// Character counter for description textarea
$("#description").on("input", function () {
    const count = $(this).val().length;
    $("#charCount").text(count);

    // Change color based on character count
    const $charCountDisplay = $("#charCountDisplay");
    if (count > 900) {
        $charCountDisplay.addClass("text-red-600").removeClass("text-gray-700");
    } else if (count > 700) {
        $charCountDisplay
            .addClass("text-yellow-600")
            .removeClass("text-gray-700 text-red-600");
    } else {
        $charCountDisplay.removeClass("text-red-600 text-yellow-600");
    }
});

// Initialize price on page load
$(document).ready(function () {
    updatePrice();
});

function showAlert(message, type = "success") {
    Swal.fire({
        icon: type,
        title: message,
        customClass: {
            popup: "custom-swal-popup",
            title: "custom-swal-title",
            htmlContainer: "custom-swal-text",
        },
    });
}

$("#commissionForm").on("submit", function (e) {
    e.preventDefault();

    const finalPrice = parseInt($("#finalPrice").val()) || 0;
    const category = determineCategory();
    console.log(category);

    if ($("#deadline").val() == "") {
        showAlert("Please select a deadline for your commission.", "error");
        return;
    }

    // deadline must be an actual date
    if (isNaN(new Date($("#deadline").val()).getTime())) {
        showAlert("Please select a valid date for the deadline.", "error");
        return;
    }

    // deadline must be at least 2 weeks from now
    if ($("#deadline").val()) {
        const selectedDate = new Date($("#deadline").val());
        const currentDate = new Date();
        const minDate = new Date();
        minDate.setDate(currentDate.getDate() + 14); // 2 weeks from now
        if (selectedDate < minDate) {
            showAlert("Deadline must be at least 2 weeks from today.", "error");
            return;
        }
    }

    if ($("#description").val().trim() == "") {
        showAlert("Please provide a description for your commission.", "error");
        return;
    }

    const formData = new FormData(this);
    formData.append("category", category);
    formData.append(
        "background_type",
        $("input[name='background']:checked").val() || "none"
    );
    formData.append(
        "is_commercial_use",
        $("#commercialUse").is(":checked") ? 1 : 0
    );
    formData.append(
        "additional_characters",
        parseInt($("#additionalChars").val()) || 0
    );
    formData.append("description", $("#description").val().trim());
    formData.append("deadline", $("#deadline").val());
    formData.append("image", $("#imageInput")[0].files[0] || null);
    formData.append("price", finalPrice);

    $.ajax({
        url: "/member/commission_store",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            showAlert("Commission request submitted successfully!");
            // Optionally redirect to another page after success
            setTimeout(function () {
                window.location.href = "/member/history";
            }, 2000);
        },
        error: function (xhr, status, error) {
            showAlert(
                "An error occurred while submitting your request. Please try again.",
                "error"
            );
            console.error(
                "Commission Submission error:",
                xhr.responseJSON || error
            );
        },
    });
});
