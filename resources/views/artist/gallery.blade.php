@extends('artist.artist_template')

@section('content')
{{-- Kontainer luar tetap sama persis seperti desain asli Anda --}}
<div class="flex justify-center items-center h-[89vh] overflow-hidden">
    {{-- Layout diubah menjadi vertikal di mobile, dan horizontal di desktop --}}
    <div class="flex flex-col md:flex-row w-[85vw] h-[85vh] bg-[#f0ebe3] outline-4 rounded-2xl overflow-hidden font-[HammersmithOne-Regular]">

        <!-- LEFT: Upload Form -->
        {{-- Kolom ini sekarang bisa di-scroll jika kontennya terlalu panjang --}}
        <div class="w-full md:w-[45%] bg-[#f0ebe3] p-6 flex flex-col justify-start items-start overflow-y-auto no-scrollbar">
            <p class="text-lg mb-2">Picture preview :</p>

            <!-- Upload & Preview (tetap seperti desain asli Anda) -->
            <div 
                id="previewBox" 
                class="border-2 border-dashed border-[#a6a6a6] bg-[#f7f7f7] text-gray-500 flex flex-col items-center justify-center w-60 h-60 mb-3 rounded-lg cursor-pointer relative overflow-hidden transition-all"
            >
                <div id="dropMessage" class="flex flex-col items-center justify-center gap-2 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#a6a6a6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m10 4v8m0 0l-4-4m4 4l4-4" />
                    </svg>
                    <p class="text-center text-sm font-medium">
                        {{-- Warna diubah jadi biru untuk feedback drag yang lebih baik --}}
                        <span class="font-semibold text-blue-500">Drag & drop</span> your image here<br>or click to upload
                    </p>
                    <p class="text-xs text-gray-400">(PNG, JPG, JPEG only)</p>
                </div>

                <input type="file" id="imageInput" accept="image/png, image/jpeg, image/jpg" class="hidden">
                <img id="previewImage" class="absolute inset-0 w-full h-full object-cover hidden rounded-lg" alt="Preview">
                <button id="removeImageBtn" class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded hidden hover:bg-black transition">
                    ✕
                </button>
            </div>

            <!-- Form Inputs -->
            <form id="artworkForm" class="flex flex-col w-full max-w-md" method="POST" action="{{ route('artist.gallery.store') }}" enctype="multipart/form-data">
                @csrf
                <label class="text-sm flex items-center gap-2 mb-3 select-none cursor-pointer">
                    Enable Purchase? 
                    <input id="purchaseCheckbox" type="checkbox" class="w-4 h-4 accent-[#f6a88a]">
                </label>

                {{-- KUNCI: Mengembalikan styling asli Anda ke setiap input --}}
                <div class="mb-3">
                    <input id="titleInput" name="title" type="text" placeholder="Insert Title..." class="border rounded-lg px-3 py-2 w-full sm:w-[80%] focus:ring-2 focus:ring-[#c9b8e3] outline-none">
                    <p class="error-message"></p>
                </div>

                <div class="mb-3">
                    <textarea id="descInput" name="description" placeholder="Description" class="border rounded-lg px-3 py-2 w-full sm:w-[80%] h-[80px] resize-none focus:ring-2 focus:ring-[#c9b8e3] outline-none"></textarea>
                    <p class="error-message"></p>
                </div>

                <div class="mb-4">
                     <select id="fileTypeInput" name="file_format" class="border rounded-lg px-3 py-2 w-full sm:w-[80%] focus:ring-2 focus:ring-[#c9b8e3] outline-none">
                        <option value="">-- Select File Type --</option>
                        <optgroup label="🎨 Digital Illustration">
                            <option value="psd">PSD (Photoshop)</option>
                            <option value="csp">CSP (Clip Studio Paint)</option>
                            <option value="sai">SAI (Paint Tool SAI)</option>
                            <option value="png">PNG</option>
                            <option value="jpg">JPG</option>
                            <option value="jpeg">JPEG</option>
                            <option value="pdf">PDF (Artbook)</option>
                        </optgroup>
                    </select>
                    <p class="error-message"></p>
                </div>

                {{-- Kontainer Harga (Awalnya tersembunyi) --}}
                <div id="priceContainer" class="mb-4 hidden transition-all duration-500">
                    <input id="priceInput" name="price" type="number" placeholder="Price" class="border rounded-lg px-3 py-2 w-full sm:w-[80%] focus:ring-2 focus:ring-[#c9b8e3] outline-none" value="{{ old('price', $item['price'] ?? '') }}"
                    >
                    <p class="error-message"></p>
                </div>
            
                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button type="submit" id="submitBtn" class="bg-[#f6a88a] rounded-lg px-5 py-2 w-[100px] hover:bg-[#f58b6e] transition">
                        Add
                    </button>
                    <button type="button" id="deleteBtn" class="bg-red-400 rounded-lg px-5 py-2 w-[100px] hover:bg-red-500 transition hidden">
                        Delete
                    </button>
                    <button type="button" id="clearBtn" class="bg-gray-300 rounded-lg px-5 py-2 w-[100px] hover:bg-gray-400 transition">
                        Clear
                    </button>
                </div>
            </form>
        </div>

        <!-- RIGHT: Gallery -->
        <div class="w-full md:w-[55%] bg-[#c9b8e3] rounded-tr-2xl p-6 overflow-y-auto no-scrollbar">
            {{-- Grid galeri dibuat responsif --}}
            <div id="galleryGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($galleryData as $index => $item)
                    <div 
                        class="design-item cursor-pointer aspect-square bg-gradient-to-b from-yellow-100 to-orange-200 rounded-md shadow-[0.4vh_0.4vh_0_black] hover:shadow-[0.6vh_0.6vh_0_black] hover:-translate-y-[0.3vh] transition-all duration-200"
                        data-id="{{ $item['gallery_id'] }}"
                        data-image="{{ asset(ltrim($item['image_url'], '/'))  }}"
                        data-title="{{ $item['title'] ?? '' }}"
                        data-desc="{{ $item['description'] ?? '' }}"
                        data-price="{{ $item['price'] !== null ? $item['price'] : '' }}"
                        data-purchase="{{ $item['status'] === 'available' ? 'true' : 'false' }}"
                        data-file="{{ $item['file_format'] ?? '' }}"
                    >
                        <img src="{{  asset($item['image_url']) }}" alt="Image" class="rounded-md object-cover w-full h-full border-2 border-black ">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Style ini hanya untuk pesan error. Styling input sudah dikembalikan ke HTML --}}
<style>
    .error-message {
        @apply text-red-500 text-xs mt-1 h-4;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // SEMUA JAVASCRIPT DI BAWAH INI SUDAH BENAR DAN TIDAK PERLU DIUBAH
    const artworkForm = document.getElementById('artworkForm');
    const previewBox = document.getElementById('previewBox');
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');
    const dropMessage = document.getElementById('dropMessage');
    const removeBtn = document.getElementById('removeImageBtn');
    const submitBtn = document.getElementById('submitBtn');
    const deleteBtn = document.getElementById('deleteBtn');
    const clearBtn = document.getElementById('clearBtn');
    const galleryGrid = document.getElementById('galleryGrid');

    const titleInput = document.getElementById('titleInput');
    const descInput = document.getElementById('descInput');
    const priceInput = document.getElementById('priceInput');
    const fileTypeInput = document.getElementById('fileTypeInput');
    const purchaseCheckbox = document.getElementById('purchaseCheckbox');
    const priceContainer = document.getElementById('priceContainer');

    let editMode = false;
    let currentId = null;
    let imageFile = null;

    // ========== 📂 Drag & Drop ========== //
    previewBox.addEventListener('click', () => imageInput.click());
    
    previewBox.addEventListener('dragover', (e) => {
        e.preventDefault();
        previewBox.classList.add('border-blue-500', 'bg-blue-50');
    });

    previewBox.addEventListener('dragleave', () => {
        previewBox.classList.remove('border-blue-500', 'bg-blue-50');
    });

    previewBox.addEventListener('drop', (e) => {
        e.preventDefault();
        previewBox.classList.remove('border-blue-500', 'bg-blue-50');
        const file = e.dataTransfer.files[0];
        handleFile(file);
    });

    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        handleFile(file);
    });

    function handleFile(file) {
        if (file && file.type.startsWith('image/')) {
            imageFile = file;
            loadPreview(file);
        } else {
            imageFile = null;
            previewBox.classList.add('border-red-500');
            setTimeout(() => previewBox.classList.remove('border-red-500'), 2000);
        }
    }

    function loadPreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewImage.classList.remove('hidden');
            dropMessage.classList.add('hidden');
            removeBtn.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    removeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        resetImagePreview();
    });

    function resetImagePreview() {
        previewImage.src = '';
        imageFile = null;
        previewImage.classList.add('hidden');
        dropMessage.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        imageInput.value = '';
    }

    // ========== 🧾 Klik gambar -> Edit Mode ========== //
    galleryGrid.addEventListener('click', (e) => {
        const card = e.target.closest('[data-id]');
        if (!card) return;

        resetForm();
        editMode = true;
        currentId = card.dataset.id;

        previewImage.src = card.dataset.image;
        previewImage.classList.remove('hidden');
        dropMessage.classList.add('hidden');
        removeBtn.classList.remove('hidden');

        titleInput.value = card.dataset.title;
        descInput.value = card.dataset.desc;
        fileTypeInput.value = card.dataset.file.toLowerCase();
        
        // Ambil data dari card
        const price = card.dataset.price;
        const isPurchasable = card.dataset.purchase === 'true';

        // Set checkbox dan input harga
        purchaseCheckbox.checked = isPurchasable;

        if (isPurchasable) {
            priceContainer.classList.remove('hidden');
            priceInput.value = price || '';
        } else {
            priceContainer.classList.add('hidden');
            priceInput.value = price || '';
        }


        submitBtn.textContent = 'Update';
        deleteBtn.classList.remove('hidden');
    });

    // ========== 💲 Kontrol Input Harga ========== //
    purchaseCheckbox.addEventListener('change', () => {
        if (purchaseCheckbox.checked) {
            priceContainer.classList.remove('hidden');
        } else {
            priceContainer.classList.add('hidden');
            priceInput.value = '';
            clearInputError(priceInput);
        }
    });

    // ========== ✨ Validasi & Aksi Form ========== //
    artworkForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        if (!validateForm()) return;

        const formData = new FormData(artworkForm);
        if (imageFile) formData.set("image", imageFile);
        if (!imageFile) formData.delete("image");
        
        // Add status based on checkbox
        if (purchaseCheckbox.checked) {
            formData.set("status", "available");
        } else {
            formData.set("status", "not_sold");
            formData.delete("price"); // Remove price if not purchasable
        }

        submitBtn.disabled = true;
        submitBtn.textContent = editMode ? "Updating..." : "Adding...";

        let url = "/artist/gallery/store";
        let method = "POST";

        if (editMode) {
            url = `/artist/gallery/${currentId}`;
            formData.append("_method", "PUT"); // Laravel override
        }
 
        try {
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: formData
            });

            const data = await res.json();

            if (!data.success) {
                alert("Failed to save data");
                submitBtn.disabled = false;
                return;
            }

            if (!editMode) {
                addCardToGrid(data.gallery);
            } else {
                updateCardInGrid(data.gallery);
            }

            resetForm();
        } catch (err) {
            console.error(err);
            alert("Unexpected error");
        }

        submitBtn.disabled = false;
        submitBtn.textContent = editMode ? "Update" : "Add";
    });



    deleteBtn.addEventListener("click", async () => {
        if (!editMode) return;
        if (!confirm("Delete this item?")) return;

        try {
            const res = await fetch(`/artist/gallery/${currentId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ _method: "DELETE" }),
            });

            const data = await res.json();
            if (data.success) {
                document.querySelector(`[data-id="{{ $item['gallery_id'] }}"]`).remove();
                resetForm();
            }
        } catch (err) {
            console.error(err);
        }
    });


    clearBtn.addEventListener('click', resetForm);

    function validateForm() {
        let isValid = true;
        document.querySelectorAll('.border.rounded-lg').forEach(clearInputError);

        if (!imageFile && !editMode) {
            isValid = false;
            previewBox.classList.add('border-red-500');
            setTimeout(() => previewBox.classList.remove('border-red-500'), 2000);
        }

        if (titleInput.value.trim() === '') {
            isValid = false;
            showInputError(titleInput, 'Title is required.');
        }

        if (fileTypeInput.value === '') {
            isValid = false;
            showInputError(fileTypeInput, 'Please select a file type.');
        }

        if (purchaseCheckbox.checked && priceInput.value.trim() === '') {
            isValid = false;
            showInputError(priceInput, 'Price is required when purchase is enabled.');
        }

        return isValid;
    }

    function showInputError(inputElement, message) {
        inputElement.classList.add('border-red-500');
        const errorElement = inputElement.parentElement.querySelector('.error-message');
        if (errorElement) {
            errorElement.textContent = message;
        }
    }

    function clearInputError(inputElement) {
        inputElement.classList.remove('border-red-500');
        const errorElement = inputElement.parentElement.querySelector('.error-message');
        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    function resetForm() {
        artworkForm.reset();
        editMode = false;
        currentId = null;
        
        resetImagePreview();
        priceContainer.classList.add('hidden');
        
        submitBtn.textContent = 'Add';
        deleteBtn.classList.add('hidden');
        document.querySelectorAll('.border.rounded-lg').forEach(clearInputError);
    }

    function addCardToGrid(g) {
        const card = document.createElement("div");
        card.className = "design-item cursor-pointer aspect-square bg-gradient-to-b from-yellow-100 to-orange-200 rounded-md shadow-[0.4vh_0.4vh_0_black] hover:shadow-[0.6vh_0.6vh_0_black] hover:-translate-y-[0.3vh] transition-all duration-200";
        card.dataset.id = g.gallery_id;
        card.dataset.image = g.image_url;
        card.dataset.title = g.title || "";
        card.dataset.desc = g.description || "";
        card.dataset.price = g.price || "";
        card.dataset.purchase = g.status === 'available' ? 'true' : 'false';
        card.dataset.file = g.file_format || "";

        const img = document.createElement("img");
        img.src = g.image_url;
        img.className = "rounded-md object-cover w-full h-full border-2 border-black";

        card.appendChild(img);
        galleryGrid.prepend(card);
    }

    function updateCardInGrid(g) {
        const card = document.querySelector(`[data-id="${g.gallery_id}"]`);
        if (!card) return;

        card.dataset.image = g.image_url;
        card.dataset.title = g.title;
        card.dataset.desc = g.description;
        card.dataset.price = g.price;
        card.dataset.purchase = g.status === 'available' ? 'true' : 'false';
        card.dataset.file = g.file_format;

        const img = card.querySelector("img");
        img.src = g.image_url;
    }


});
</script>
@endsection 