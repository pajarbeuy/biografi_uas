<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Tokoh - BIOTOMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('layouts.navbar')
    
    <div class="container mx-auto px-4 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2 text-center">Profil Tokoh Matematikawan</h1>
        <p class="text-base md:text-lg text-gray-600 mb-8 text-center">Kumpulan biografi matematikawan terkenal di dunia</p>
        
        @if($biografis->count() > 0)
            <!-- Search & Filter Section -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-8">
                <div class="">
                    <!-- Search Input -->
                    <div class="relative">
                        <label for="search" class="block text-lg font-semibold text-gray-700 mb-2">Cari Tokoh</label>
                        <div class="relative">
                            <input type="text" 
                                   id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari berdasarkan nama tokoh..." 
                                   class="w-full px-4 py-3 pl-11 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="text-center">
                        <label class="block text-sm font-semibold text-gray-700 mb-3 mt-5">Filter Kategori</label>
                        <div class="flex flex-wrap gap-2 mb-2" id="category-pills">
                            <button type="button" 
                                    data-category-id="" 
                                    class="category-pill {{ !request('category') ? 'active border-blue-500 bg-blue-500 text-white' : 'border-gray-200 bg-gray-50 text-gray-600' }} px-12 py-2 rounded-full text-sm font-medium transition-all border-2 shadow-sm hover:shadow-md">
                                Semua
                            </button>
                            @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                                <button type="button" 
                                        data-category-id="{{ $category->id }}" 
                                        class="category-pill {{ request('category') == $category->id ? 'active border-blue-500 bg-blue-500 text-white' : 'border-gray-200 bg-gray-50 text-gray-600' }} px-8 py-2 rounded-full text-sm font-medium transition-all border-2 shadow-sm hover:shadow-md">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Results Count -->
                <div class="mt-4 text-sm text-gray-600" id="result-count-container">
                    Menampilkan <span id="result-count" class="font-semibold text-gray-800">{{ $biografis->count() }}</span> biografi
                </div>
            </div>
        
        @endif
        
        @if($biografis->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="biografi-grid">
                @foreach($biografis as $biografi)
                    <div class="biografi-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300" 
                         data-name="{{ strtolower($biografi->name) }}"
                         data-category="{{ $biografi->category_id ?? '' }}">
                        <!-- Foto Tokoh -->
                        <div class="aspect-square bg-gray-200 flex items-center justify-center overflow-hidden relative group">
                            <a href="{{ route('profile-tokoh.show', $biografi->slug) }}" class="block w-full h-full relative">
                                @if($biografi->image_path)
                                    <img src="{{ asset('storage/' . $biografi->image_path) }}" 
                                         alt="{{ $biografi->name }}"
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <svg class="w-16 md:w-24 h-16 md:h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                                <!-- Overlay hint -->
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black bg-opacity-30">
                                    <span class="bg-white text-black px-4 py-2 rounded-full text-sm font-bold shadow-lg">Lihat Detail</span>
                                </div>
                            </a>
                        </div>
                        
                        <!-- Info Tokoh -->
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $biografi->name }}</h3>
                            
                            @if($biografi->category)
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="font-semibold">{{ $biografi->category->name }}</span>
                                </div>
                            @endif
                            
                            @if($biografi->birth_place || $biografi->birth_date)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>
                                        @if($biografi->birth_place && $biografi->birth_date)
                                            {{ $biografi->birth_place }}, {{ $biografi->birth_date->format('Y') }}
                                        @elseif($biografi->birth_place)
                                            {{ $biografi->birth_place }}
                                        @else
                                            {{ $biografi->birth_date->format('d M Y') }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Biografi</h3>
                <p class="text-gray-500">Saat ini belum ada biografi matematikawan yang dipublikasikan.</p>
            </div>
        @endif
        
        {{-- Pagination --}}
        @if($biografis->hasPages())
            <div class="mt-12">
                <div class="flex justify-center">
                    <nav class="inline-flex rounded-lg shadow-sm" role="navigation" aria-label="Pagination">
                        {{-- Previous Button --}}
                        @if ($biografis->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-not-allowed rounded-l-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1">Previous</span>
                            </span>
                        @else
                            <a href="{{ $biografis->previousPageUrl() }}" 
                               class="pagination-link relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1">Previous</span>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        <div class="hidden sm:flex">
                            @foreach ($biografis->getUrlRange(1, $biografis->lastPage()) as $page => $url)
                                @if ($page == $biografis->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 border border-blue-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="pagination-link relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Current Page (Mobile) --}}
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 sm:hidden">
                            Page {{ $biografis->currentPage() }} of {{ $biografis->lastPage() }}
                        </span>

                        {{-- Next Button --}}
                        @if ($biografis->hasMorePages())
                            <a href="{{ $biografis->nextPageUrl() }}" 
                               class="pagination-link relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                <span class="mr-1">Next</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-not-allowed rounded-r-lg">
                                <span class="mr-1">Next</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        @endif
                    </nav>
                </div>
                
                {{-- Page Info --}}
                <div class="text-center mt-4 text-sm text-gray-600">
                    Showing {{ $biografis->firstItem() ?? 0 }} to {{ $biografis->lastItem() ?? 0 }} of {{ $biografis->total() }} biographies
                </div>
            </div>
        @endif
    </div>



    @include('layouts.footer')
    
    <script>
        // Server-side Filtering Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const biografiGrid = document.getElementById('biografi-grid');
            const resultCount = document.getElementById('result-count');
            let searchTimeout;

            function updateResults() {
                const searchTerm = searchInput ? searchInput.value : '';
                const activePill = document.querySelector('.category-pill.active');
                const selectedCategory = activePill ? activePill.dataset.categoryId : '';
                
                // Build URL with parameters
                const url = new URL(window.location.origin + window.location.pathname);
                if (searchTerm) url.searchParams.set('search', searchTerm);
                if (selectedCategory) url.searchParams.set('category', selectedCategory);
                
                fetchPage(url.toString());
            }

            function fetchPage(url) {
                // Scroll to top smoothly
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Update grid
                    const newGrid = doc.getElementById('biografi-grid');
                    if (newGrid && biografiGrid) {
                        biografiGrid.innerHTML = newGrid.innerHTML;
                        
                        // Remove any existing empty messages
                        const existingEmptyMessages = biografiGrid.parentNode.querySelectorAll('.bg-white.rounded-lg.shadow-md.p-12.text-center');
                        existingEmptyMessages.forEach(msg => {
                            if (msg !== biografiGrid) {
                                msg.remove();
                            }
                        });
                    } else if (biografiGrid) {
                        // Handle empty case from response
                        const emptyContent = doc.querySelector('.bg-white.rounded-lg.shadow-md.p-12.text-center');
                        if (emptyContent) {
                            biografiGrid.innerHTML = '';
                            
                            // Remove any existing empty messages before inserting new one
                            const existingEmptyMessages = biografiGrid.parentNode.querySelectorAll('.bg-white.rounded-lg.shadow-md.p-12.text-center');
                            existingEmptyMessages.forEach(msg => msg.remove());
                            
                            biografiGrid.parentNode.insertBefore(emptyContent, biografiGrid.nextSibling);
                            
                            // Hide result count when empty
                            const resultCountContainer = document.getElementById('result-count-container');
                            if (resultCountContainer) {
                                resultCountContainer.style.display = 'none';
                            }
                        }
                    }
                    
                    // Update pagination
                    const currentPagination = document.querySelector('.mt-12');
                    const newPagination = doc.querySelector('.mt-12');
                    if (newPagination) {
                        if (currentPagination) {
                            currentPagination.outerHTML = newPagination.outerHTML;
                        } else {
                            // If it didn't exist before, append it after the grid
                            biografiGrid.parentNode.insertBefore(newPagination, biografiGrid.nextSibling);
                        }
                    } else if (currentPagination) {
                        currentPagination.remove();
                    }
                    
                    // Update result count
                    const newResultCount = doc.getElementById('result-count');
                    const resultCountContainer = document.getElementById('result-count-container');
                    if (resultCount && newResultCount) {
                        resultCount.textContent = newResultCount.textContent;
                        // Show result count container when there are results
                        if (resultCountContainer) {
                            resultCountContainer.style.display = '';
                        }
                    }
                    
                    // Re-setup links and update state
                    setupPaginationLinks();
                    window.history.pushState({}, '', url);
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                    window.location.href = url;
                });
            }

            function setupPaginationLinks() {
                document.querySelectorAll('.pagination-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        fetchPage(this.getAttribute('href'));
                    });
                });
            }

            // Category Pill Clicks
            document.querySelectorAll('.category-pill').forEach(pill => {
                pill.addEventListener('click', function() {
                    document.querySelectorAll('.category-pill').forEach(p => {
                        p.classList.remove('active', 'border-blue-500', 'bg-blue-500', 'text-white');
                        p.classList.add('border-gray-200', 'bg-gray-50', 'text-gray-600');
                    });
                    
                    this.classList.add('active', 'border-blue-500', 'bg-blue-500', 'text-white');
                    this.classList.remove('border-gray-200', 'bg-gray-50', 'text-gray-600');
                    
                    updateResults();
                });
            });

            // Search Input with Debounce
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(updateResults, 500);
                });
            }

            // Initial setup
            setupPaginationLinks();
            window.addEventListener('popstate', () => location.reload());
        });
    </script>
</body>
</html>