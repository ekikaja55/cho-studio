$(document).ready(function(){let r=1,n={search:"",order_status:"",payment_status:"",per_page:10,sort_by:"created_at",sort_order:"desc"};s();let i;$("#search-input").on("input",function(){clearTimeout(i),i=setTimeout(function(){n.search=$("#search-input").val(),r=1,s()},500)}),$("#status-filter, #payment-filter").on("change",function(){n.order_status=$("#status-filter").val(),n.payment_status=$("#payment-filter").val(),r=1,s()}),$("#per-page").on("change",function(){n.per_page=$(this).val(),r=1,s()}),$("#sort-order").on("change",function(){n.sort_order=$(this).val(),r=1,s()}),$("#clear-filters").on("click",function(){$("#search-input").val(""),$("#status-filter").val(""),$("#payment-filter").val(""),$("#per-page").val("10"),$("#sort-order").val("desc"),n={search:"",order_status:"",payment_status:"",per_page:10,sort_by:"created_at",sort_order:"desc"},r=1,s()}),$(document).on("click","#pagerPrev",function(){r>1&&(r--,s())}),$(document).on("click","#pagerNext",function(){const t=parseInt($("#pagerNext").data("last-page"));r<t&&(r++,s())}),$(document).on("click",".page-number",function(){r=parseInt($(this).data("page")),s()});function s(){const t={page:r,...n};$.ajax({url:"/artist/getAdoptions",type:"GET",data:t,dataType:"json",beforeSend:function(){$("#adoptions-tbody").html(`
                    <tr>
                        <td colspan="6" class="p-0 border-none align-top">
                            <div class="min-h-[48vh] flex items-center justify-center bg-[var(--color-background)]">
                                <div class="text-lg max-md:p-1 text-stone-700">
                                    Loading adoptions...
                                </div>
                            </div>
                        </td>
                    </tr>
                `)},success:function(e){e.success&&(g(e.data),x(e.pagination),b(e.status_counts))},error:function(e){console.error("Error loading adoptions:",e),$("#adoptions-tbody").html(`
                    <tr>
                        <td colspan="6" class="p-0 border-none align-top">
                            <div class="min-h-[48vh] flex items-center justify-center bg-[var(--color-background)]">
                                <div class="text-lg max-md:p-1 text-red-600">
                                    Error loading adoptions. Please try again.
                                </div>
                            </div>
                        </td>
                    </tr>
                `)}})}function g(t){const e=$("#adoptions-tbody");if(e.empty(),t.length===0){e.html(`
                <tr>
                    <td colspan="6" class="p-0 border-none align-top">
                        <div class="min-h-[48vh] flex items-center justify-center bg-[var(--color-background)]">
                            <div class="text-lg max-md:p-1 text-stone-700">
                                No adoption orders to display
                            </div>
                        </div>
                    </td>
                </tr>
            `);return}t.forEach(function(a){var u,m;const d=f(a.order_status),l=v(a.order_status),o=y(a.payment_status),p=h(a.payment_status),c=`
                <tr class="bg-[var(--color-background)]">
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                        <div class="font-semibold">${a.email||"N/A"}</div>
                    </td>
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                        ${((u=a.gallery)==null?void 0:u.title)||"N/A"}
                    </td>
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                        ${P((m=a.gallery)==null?void 0:m.description,50)||"N/A"}
                    </td>
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                        ${_(a.created_at)}
                    </td>
                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border align-top">
                        <div class="flex flex-col text-lg max-lg:text-base max-sm:text-sm max-md:text-sm md:text-base sm:flex-row gap-2 items-center justify-center">
                            <button disabled class="px-3 py-1 rounded-full text-white ${d}">
                                ${l}
                            </button>
                            <button disabled class="px-3 py-1 rounded-full text-white ${o}">
                                ${p}
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
            `;e.append(c)})}function x(t){$("#pagerRange").text(`${t.from||0}-${t.to||0}`),$("#pagerTotal").text(t.total||0),$("#pagerPrev").prop("disabled",t.current_page<=1),$("#pagerNext").prop("disabled",t.current_page>=t.last_page).data("last-page",t.last_page);const e=$("#pagerNumbers");e.empty();const a=5;let d=Math.max(1,t.current_page-Math.floor(a/2)),l=Math.min(t.last_page,d+a-1);l-d<a-1&&(d=Math.max(1,l-a+1));for(let o=d;o<=l;o++){const c=`
                <button class="page-number px-3 py-1 rounded border-2 border-stone-900 text-sm ${o===t.current_page?"bg-stone-900 text-white":"bg-white"}" 
                    data-page="${o}">
                    ${o}
                </button>
            `;e.append(c)}}function b(t){$("#status-placed").text(`${t.placed||0} Placed`),$("#status-delivered").text(`${t.delivered||0} Delivered`)}function f(t){return{placed:"bg-amber-500",processing:"bg-blue-500",delivered:"bg-purple-400",completed:"bg-green-600",cancelled:"bg-gray-500"}[t]||"bg-gray-500"}function v(t){return{placed:"Placed",processing:"Processing",delivered:"Delivered",completed:"Completed",cancelled:"Cancelled"}[t]||"Unknown"}function y(t){return{pending:"bg-red-600",paid:"bg-green-600",refunded:"bg-blue-600",invalid:"bg-gray-600"}[t]||"bg-gray-400"}function h(t){return{pending:"Pending",paid:"Paid",refunded:"Refunded",invalid:"Invalid"}[t]||"Unknown"}function _(t){if(!t)return"N/A";const e=new Date(t);return isNaN(e)?"N/A":e.toLocaleDateString("id-ID",{year:"numeric",month:"long",day:"numeric"})}function P(t,e=50){return t?t.length<=e?t:t.substring(0,e).trim()+"...":""}});
