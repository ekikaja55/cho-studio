$(document).ready(function(){let a=1,r={search:"",status:"",payment_status:"",category:"",sort:"",per_page:10};n();let c;$("#search-input").on("input",function(){clearTimeout(c),c=setTimeout(function(){r.search=$("#search-input").val(),a=1,n()},500)}),$("#status-filter, #payment-filter, #category-filter, #sort-filter").on("change",function(){r.status=$("#status-filter").val(),r.payment_status=$("#payment-filter").val(),r.category=$("#category-filter").val(),r.sort=$("#sort-filter").val(),a=1,n()}),$("#per-page").on("change",function(){r.per_page=$(this).val(),a=1,n()}),$("#clear-filters").on("click",function(){$("#search-input").val(""),$("#status-filter").val(""),$("#payment-filter").val(""),$("#category-filter").val(""),$("#sort-filter").val(""),$("#per-page").val("10"),r={search:"",status:"",payment_status:"",category:"",sort:"",per_page:10},a=1,n()}),$(document).on("click","#pagerPrev",function(){a>1&&(a--,n())}),$(document).on("click","#pagerNext",function(){const t=parseInt($("#pagerNext").data("last-page"));a<t&&(a++,n())}),$(document).on("click",".page-number",function(){a=parseInt($(this).data("page")),n()});function n(){const t={page:a,...r};$.ajax({url:"/artist/getCommissions",type:"GET",data:t,dataType:"json",beforeSend:function(){$("#commissions-tbody").html(`
                            <tr>
                                <td colspan="8" class="p-0 border-none align-top">
                                    <div class="min-h-[60vh] flex items-center justify-center bg-(--color-background)">
                                        <div class="text-lg max-md:p-1 text-stone-700">
                                            <i class="fas fa-spinner fa-spin mr-2"></i>Loading commissions...
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `)},success:function(e){e.success&&(x(e.data),b(e.pagination),f(e.status_counts))},error:function(e){console.error("Error loading commissions:",e),$("#commissions-tbody").html(`
                            <tr>
                                <td colspan="8" class="p-0 border-none align-top">
                                    <div class="min-h-[60vh] flex items-center justify-center bg-(--color-background)">
                                        <div class="text-lg max-md:p-1 text-red-600">
                                            <i class="fas fa-exclamation-circle mr-2"></i>Error loading commissions. Please try again.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `)}})}function x(t){const e=$("#commissions-tbody");if(e.empty(),t.length===0){e.html(`
                        <tr>
                            <td colspan="8" class="p-0 border-none align-top">
                                <div class="min-h-[48vh] flex items-center justify-center bg-(--color-background)">
                                    <div class="text-lg max-md:p-1 text-stone-700">No commissions found</div>
                                </div>
                            </td>
                        </tr>
                    `);return}t.forEach(function(s){var p,u;const i=v(s.progress_status),l=y(s.progress_status),o=h(s.payment_status),g=_(s.payment_status),d=`
                        <tr class="bg-(--color-background)">
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                <div class="font-semibold">${((p=s.member)==null?void 0:p.username)||"N/A"}</div>
                                <div class="text-sm text-gray-600">${((u=s.member)==null?void 0:u.email)||"N/A"}</div>
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                ${s.category||"N/A"}
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                                ${w(s.description,50)||"N/A"}
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden md:table-cell align-top">
                                Rp. ${Number(s.price||0).toLocaleString("id-ID")}
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden lg:table-cell align-top">
                                ${m(s.created_at)}
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                                ${m(s.deadline)}
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                <div class="flex flex-col text-lg max-lg:text-base max-sm:text-sm max-md:text-sm md:text-base sm:flex-row gap-2 items-center justify-center">
                                    <button disabled class="px-3 py-1 rounded-full text-white font-medium ${i}">
                                        ${l}
                                    </button>
                                    <button disabled class="px-3 py-1 rounded-full text-white font-medium ${o}">
                                        ${g}
                                    </button>
                                </div>
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:text-sm border border-stone-900 align-top">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    <a href="/artist/commission_detail/${s.commission_id}"
                                        class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-green-600 text-green-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-green-600 transition-all duration-200"
                                        style="background-color: var(--status-success);">View</a>
                                </div>
                            </td>
                        </tr>
                    `;e.append(d)})}function b(t){$("#pagerRange").text(`${t.from||0}-${t.to||0}`),$("#pagerTotal").text(t.total||0),$("#pagerPrev").prop("disabled",t.current_page<=1),$("#pagerNext").prop("disabled",t.current_page>=t.last_page).data("last-page",t.last_page);const e=$("#pagerNumbers");e.empty();const s=5;let i=Math.max(1,t.current_page-Math.floor(s/2)),l=Math.min(t.last_page,i+s-1);l-i<s-1&&(i=Math.max(1,l-s+1));for(let o=i;o<=l;o++){const d=`
                        <button class="page-number px-3 py-1 rounded border-2 border-stone-900 text-sm ${o===t.current_page?"bg-stone-900 text-white":"bg-white"}" 
                            data-page="${o}">
                            ${o}
                        </button>
                    `;e.append(d)}}function f(t){$("#status-pending").text(`${t.pending} Pending`),$("#status-accepted").text(`${t.accepted} Accepted`),$("#status-in-progress").text(`${t.in_progress} In Progress`),$("#status-revision").text(`${t.revision} Revision`)}function v(t){return{pending:"bg-yellow-500",accepted:"bg-blue-500",declined:"bg-red-600",in_progress_sketch:"bg-purple-500",in_progress_coloring:"bg-pink-500",review:"bg-cyan-500",revision:"bg-orange-500",completed:"bg-green-500",cancelled:"bg-gray-500"}[t]||"bg-gray-500"}function y(t){return{pending:"Pending",accepted:"Accepted",declined:"Declined",in_progress_sketch:"Sketching",in_progress_coloring:"Coloring",review:"In Review",revision:"Revision",completed:"Completed",cancelled:"Cancelled"}[t]||"Unknown"}function h(t){return{pending:"bg-red-500",dp:"bg-amber-500",paid:"bg-green-500",refunded:"bg-gray-500"}[t]||"bg-gray-500"}function _(t){return{pending:"Unpaid",dp:"DP",paid:"Paid",refunded:"Refunded"}[t]||"Unknown"}function m(t){return t?new Date(t).toLocaleDateString("en-US",{year:"numeric",month:"short",day:"numeric"}):"N/A"}function w(t,e=50){return t?t.length<=e?t:t.substring(0,e).trim()+"...":""}});
