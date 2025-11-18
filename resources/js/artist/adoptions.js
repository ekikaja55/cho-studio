$(document).ready(function () {
    let currentPage = 1;
    let currentFilters = {
        search: "",
        order_status: "",
        payment_status: "",
        per_page: 10,
        sort_by: "created_at",
        sort_order: "desc",
    };

    // Load adoptions on page load
    loadAdoptions();

    // Search input with debounce
    let searchTimeout;
    $("#search-input").on("input", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            currentFilters.search = $("#search-input").val();
            currentPage = 1;
            loadAdoptions();
        }, 500);
    });

    // Filter changes
    $("#status-filter, #payment-filter").on("change", function () {
        currentFilters.order_status = $("#status-filter").val();
        currentFilters.payment_status = $("#payment-filter").val();
        currentPage = 1;
        loadAdoptions();
    });

    // Per page change
    $("#per-page").on("change", function () {
        currentFilters.per_page = $(this).val();
        currentPage = 1;
        loadAdoptions();
    });

    // Sort order change
    $("#sort-order").on("change", function () {
        currentFilters.sort_order = $(this).val();
        currentPage = 1;
        loadAdoptions();
    });

    // Clear filters
    $("#clear-filters").on("click", function () {
        $("#search-input").val("");
        $("#status-filter").val("");
        $("#payment-filter").val("");
        $("#per-page").val("10");
        $("#sort-order").val("desc");
        currentFilters = {
            search: "",
            order_status: "",
            payment_status: "",
            per_page: 10,
            sort_by: "created_at",
            sort_order: "desc",
        };
        currentPage = 1;
        loadAdoptions();
    });

    // Pagination buttons
    $(document).on("click", "#pagerPrev", function () {
        if (currentPage > 1) {
            currentPage--;
            loadAdoptions();
        }
    });

    $(document).on("click", "#pagerNext", function () {
        const lastPage = parseInt($("#pagerNext").data("last-page"));
        if (currentPage < lastPage) {
            currentPage++;
            loadAdoptions();
        }
    });

    $(document).on("click", ".page-number", function () {
        currentPage = parseInt($(this).data("page"));
        loadAdoptions();
    });

    function loadAdoptions() {
        const params = {
            page: currentPage,
            ...currentFilters,
        };

        $.ajax({
            url: "/artist/getAdoptions",
            type: "GET",
            data: params,
            dataType: "json",
            beforeSend: function () {
                $("#adoptions-tbody").html(`
                    <tr>
                        <td colspan="6" class="p-0 border-none align-top">
                            <div class="min-h-[48vh] flex items-center justify-center bg-[var(--color-background)]">
                                <div class="text-lg max-md:p-1 text-stone-700">
                                    Loading adoptions...
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
            },
            success: function (response) {
                if (response.success) {
                    renderAdoptions(response.data);
                    renderPagination(response.pagination);
                    updateStatusCounts(response.status_counts);
                }
            },
            error: function (xhr) {
                console.error("Error loading adoptions:", xhr);
                $("#adoptions-tbody").html(`
                    <tr>
                        <td colspan="6" class="p-0 border-none align-top">
                            <div class="min-h-[48vh] flex items-center justify-center bg-[var(--color-background)]">
                                <div class="text-lg max-md:p-1 text-red-600">
                                    Error loading adoptions. Please try again.
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
            },
        });
    }

    function renderAdoptions(adoptions) {
        const tbody = $("#adoptions-tbody");
        tbody.empty();

        if (adoptions.length === 0) {
            tbody.html(`
                <tr>
                    <td colspan="6" class="p-0 border-none align-top">
                        <div class="min-h-[48vh] flex items-center justify-center bg-[var(--color-background)]">
                            <div class="text-lg max-md:p-1 text-stone-700">
                                No adoption orders to display
                            </div>
                        </div>
                    </td>
                </tr>
            `);
            return;
        }

        adoptions.forEach(function (a) {
            const orderStatusColor = getOrderStatusColor(a.order_status);
            const orderStatusText = getOrderStatusText(a.order_status);
            const paymentStatusColor = getPaymentStatusColor(a.payment_status);
            const paymentStatusText = getPaymentStatusText(a.payment_status);

            const row = `
                <tr class="bg-[var(--color-background)]">
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                        <div class="font-semibold">${
                            a.buyer_name || "N/A"
                        }</div>
                        <div class="text-sm text-gray-600">${
                            a.buyer_email || "N/A"
                        }</div>
                    </td>
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                        ${a.gallery?.title || "N/A"}
                    </td>
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                        ${truncateText(a.gallery?.description, 50) || "N/A"}
                    </td>
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                        ${formatDate(a.created_at)}
                    </td>
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border align-top">
                        <div class="flex flex-col text-lg max-lg:text-base max-sm:text-sm max-md:text-sm md:text-base sm:flex-row gap-2 items-center justify-center">
                            <button disabled class="px-3 py-1 rounded-full text-white ${orderStatusColor}">
                                ${orderStatusText}
                            </button>
                            <button disabled class="px-3 py-1 rounded-full text-white ${paymentStatusColor}">
                                ${paymentStatusText}
                            </button>
                        </div>
                    </td>
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                            <a href="/artist/adoption_detail/${a.adoption_id}"
                                class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-green-600 text-green-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200"
                                style="background-color: var(--status-success);">View</a>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    function renderPagination(pagination) {
        $("#pagerRange").text(`${pagination.from || 0}-${pagination.to || 0}`);
        $("#pagerTotal").text(pagination.total || 0);

        // Update buttons
        $("#pagerPrev").prop("disabled", pagination.current_page <= 1);
        $("#pagerNext")
            .prop("disabled", pagination.current_page >= pagination.last_page)
            .data("last-page", pagination.last_page);

        // Render page numbers
        const pagerNumbers = $("#pagerNumbers");
        pagerNumbers.empty();

        const maxPages = 5;
        let startPage = Math.max(
            1,
            pagination.current_page - Math.floor(maxPages / 2)
        );
        let endPage = Math.min(pagination.last_page, startPage + maxPages - 1);

        if (endPage - startPage < maxPages - 1) {
            startPage = Math.max(1, endPage - maxPages + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            const isActive = i === pagination.current_page;
            const pageBtn = `
                <button class="page-number px-3 py-1 rounded border-2 border-stone-900 text-sm ${
                    isActive ? "bg-stone-900 text-white" : "bg-white"
                }" 
                    data-page="${i}">
                    ${i}
                </button>
            `;
            pagerNumbers.append(pageBtn);
        }
    }

    function updateStatusCounts(counts) {
        $("#status-pending").text(`${counts.pending || 0} Pending`);
        $("#status-confirmed").text(`${counts.confirmed || 0} confirmed`);
        $("#status-processing").text(`${counts.processing || 0} Processing`);
        $("#status-delivered").text(`${counts.delivered || 0} Delivered`);
    }

    function getOrderStatusColor(status) {
        const statusColors = {
            pending: "bg-red-600", // Red - waiting for artist confirmation
            confirmed: "bg-blue-500", // blue - confirmed by artist
            processing: "bg-amber-500", // Amber - preparing files
            delivered: "bg-purple-400", // Purple - files delivered
            completed: "bg-green-600", // Green - order completed
            cancelled: "bg-gray-500", // gray - cancelled
        };
        return statusColors[status] || "bg-gray-500";
    }

    function getOrderStatusText(status) {
        const statusTexts = {
            pending: "Pending",
            confirmed: "Confirmed",
            processing: "Processing",
            delivered: "Delivered",
            completed: "Completed",
            cancelled: "Cancelled",
        };
        return statusTexts[status] || "Unknown";
    }

    function getPaymentStatusColor(status) {
        const paymentColors = {
            unpaid: "bg-red-600", // Red - not paid
            paid: "bg-green-600", // Green - paid
            refunded: "bg-blue-600", // Cyan - refunded
            failed: "bg-gray-600", // gray - failed
        };
        return paymentColors[status] || "bg-gray-400";
    }

    function getPaymentStatusText(status) {
        const paymentTexts = {
            unpaid: "Unpaid",
            paid: "Paid",
            refunded: "Refunded",
            failed: "Failed",
        };
        return paymentTexts[status] || "Unknown";
    }

    // HATI-HATI INI
    function formatDate(dateString) {
        if (!dateString) return "N/A";
        const date = new Date(dateString);
        if (isNaN(date)) return "N/A";
        return date.toLocaleDateString("id-ID", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    }

    function truncateText(text, maxLength = 50) {
        if (!text) return "";
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength).trim() + "...";
    }
});
