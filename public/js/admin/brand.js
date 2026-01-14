$(document).ready(function() {
    let debounceTimer;
    const container = $('#brands-list-container');

    function toggleLoader(show) {
        if (show) $('#global-loader').removeClass('hidden').addClass('flex');
        else $('#global-loader').addClass('hidden').removeClass('flex');
    }

    function fetchBrands() {
        const search = $('#brand-search').val();
        const status = $('#status-filter').val();
        
        $.ajax({
            url: window.BrandConfig.fetchUrl, // Global variable use kiya
            method: "GET",
            data: { search, status },
            success: function(res) {
                renderBrands(res.data);
            }
        });
    }
function renderBrands(brands) {
    container.empty();
    if (!brands || brands.length === 0) {
        container.append('<li class="px-6 py-12 text-center text-gray-500">No brands found.</li>');
        return;
    }

    brands.forEach(brand => {
        const logo = brand.logo 
            ? `<img src="${window.BrandConfig.storagePath}/${brand.logo}" class="h-full w-full object-contain p-1">`
            : `<span class="text-xs text-gray-400 font-bold uppercase">${brand.name.substring(0,2)}</span>`;

        // Toggle HTML Fix: w-10 aur h-5 track ke liye, translate-x-5 circle ke liye
        const toggleHtml = `
            <label class="inline-flex relative items-center cursor-pointer group">
                <input type="checkbox" class="sr-only peer status-toggle" data-id="${brand.id}" ${brand.is_active ? 'checked' : ''}>
                <div class="w-10 h-5 bg-gray-200 rounded-full 
                            peer-checked:bg-indigo-600 
                            peer-focus:ring-2 peer-focus:ring-indigo-100 
                            transition-all duration-300 relative">
                    <div class="absolute top-[2px] left-[2px] bg-white w-4 h-4 rounded-full 
                                shadow-sm transition-all duration-300 
                                peer-checked:translate-x-5"></div>
                </div>
            </label>
        `;

        container.append(`
            <li id="brand-row-${brand.id}" class="hover:bg-gray-50 transition border-b border-gray-100">
                <div class="px-4 py-4 sm:px-6 flex items-center justify-between">
                    <div class="flex items-center min-w-0 flex-1">
                        <div class="flex-shrink-0 h-14 w-14 border rounded-lg bg-gray-50 flex items-center justify-center overflow-hidden">
                            ${logo}
                        </div>
                        <div class="ml-4 min-w-0">
                            <div class="flex items-center">
                                <p class="text-sm font-bold text-blue-600 truncate">${brand.name}</p>
                                <span class="ml-2 px-2 py-0.5 text-[10px] font-bold uppercase rounded-full ${brand.is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                                    ${brand.is_active ? 'Online' : 'Offline'}
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Created: ${new Date(brand.created_at).toLocaleDateString()}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        ${toggleHtml}
                        <div class="flex items-center space-x-3">
                            <a href="/admin/brands/${brand.id}/edit" class="text-gray-400 hover:text-blue-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <button type="button" class="delete-brand-btn text-gray-400 hover:text-red-600" data-id="${brand.id}" data-name="${brand.name}">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </li>`);
    });
}

    // --- Events (Delegated for AJAX elements) ---
    $(document).on('change', '.status-toggle', function() {
        const checkbox = $(this);
        const isChecked = checkbox.is(':checked');
        
        Swal.fire({
            title: 'Change Status?',
            text: `Set brand to ${isChecked ? 'Online' : 'Offline'}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, update!',
            confirmButtonColor: '#4f46e5'
        }).then((result) => {
            if (result.isConfirmed) {
                toggleLoader(true);
                $.post(window.BrandConfig.toggleUrl, {
                    _token: window.BrandConfig.csrfToken,
                    brand_id: checkbox.data('id'),
                    status: isChecked ? 1 : 0
                }).done(function(res) {
                    toggleLoader(false);
                    Toast.fire({ icon: 'success', title: res.message });
                    fetchBrands();
                }).fail(function() {
                    toggleLoader(false);
                    checkbox.prop('checked', !isChecked);
                });
            } else {
                checkbox.prop('checked', !isChecked);
            }
        });
    });

    $(document).on('click', '.delete-brand-btn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        let url = window.BrandConfig.deleteUrl.replace(':id', id);

        Swal.fire({
            title: 'Delete?',
            text: `Delete "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444'
        }).then((result) => {
            if (result.isConfirmed) {
                toggleLoader(true);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: window.BrandConfig.csrfToken },
                    success: function(res) {
                        toggleLoader(false);
                        fetchBrands();
                        Toast.fire({ icon: 'success', title: res.message });
                    }
                });
            }
        });
    });

    $('#brand-search').on('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchBrands, 500);
    });

    $('#status-filter').on('change', fetchBrands);

    fetchBrands(); // Initial Load
    $('#reset-filter').on('click', function() {
    // 1. Inputs ko clear karein
    $('#brand-search').val('');
    $('#status-filter').val(''); // Agar default "All" hai toh use select karein

    // 2. Dubara fetch karein taaki puri list wapis aa jaye
    fetchBrands();
    
    // 3. (Optional) Success toast dikhayein
    Toast.fire({
        icon: 'info',
        title: 'Filters cleared'
    });
});
});
// Reset Button Logic
