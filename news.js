// ============================================
// NEWS PAGE - JavaScript
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    initNewsFilters();
    initSearch();
    initPagination();
});

// Initialize News Filters
function initNewsFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const newsItems = document.querySelectorAll('.news-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get category
            const category = this.getAttribute('data-category');
            
            // Filter news items
            filterNews(category, newsItems);
        });
    });
}

// Filter News Items
function filterNews(category, items) {
    items.forEach(item => {
        const itemCategory = item.getAttribute('data-category');
        
        if (category === 'all' || itemCategory === category) {
            item.style.display = 'grid';
            // Animate in
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 10);
        } else {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            setTimeout(() => {
                item.style.display = 'none';
            }, 300);
        }
    });
    
    // Show no results message if needed
    checkNoResults(category, items);
}

// Check if no results found
function checkNoResults(category, items) {
    const visibleItems = Array.from(items).filter(item => {
        return item.style.display !== 'none';
    });
    
    const newsList = document.querySelector('.news-list');
    let noResultsMsg = document.querySelector('.no-results');
    
    if (visibleItems.length === 0) {
        if (!noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.className = 'no-results';
            noResultsMsg.innerHTML = `
                <div style="text-align: center; padding: 60px 20px; color: #666;">
                    <i class="fas fa-search" style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;"></i>
                    <h3 style="font-size: 1.5rem; margin-bottom: 10px;">Tidak Ada Berita</h3>
                    <p>Tidak ada berita dalam kategori ini saat ini.</p>
                </div>
            `;
            newsList.appendChild(noResultsMsg);
        }
    } else {
        if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }
}

// Initialize Search
function initSearch() {
    const searchInput = document.getElementById('searchNews');
    const newsItems = document.querySelectorAll('.news-item');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            newsItems.forEach(item => {
                const title = item.querySelector('h2').textContent.toLowerCase();
                const content = item.querySelector('p').textContent.toLowerCase();
                const category = item.querySelector('.news-category').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || content.includes(searchTerm) || category.includes(searchTerm)) {
                    item.style.display = 'grid';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
            
            // Show no results if needed
            setTimeout(() => {
                checkNoResults('search', newsItems);
            }, 350);
        });
    }
}

// Initialize Pagination
function initPagination() {
    const pageButtons = document.querySelectorAll('.page-btn');
    
    pageButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (!this.disabled && !this.classList.contains('active')) {
                // Remove active class from all
                pageButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active to current (if it's a number)
                if (!isNaN(this.textContent)) {
                    this.classList.add('active');
                }
                
                // Scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                
                // In a real app, load new page content here
                loadPage(this.textContent);
            }
        });
    });
}

// Load Page (Simulated)
function loadPage(page) {
    console.log('Loading page:', page);
    
    // Show loading state
    const newsList = document.querySelector('.news-list');
    newsList.style.opacity = '0.5';
    
    // Simulate API call
    setTimeout(() => {
        newsList.style.opacity = '1';
        showNotification('Halaman ' + page + ' dimuat', 'success');
    }, 500);
}

// Sort Functionality
const sortSelect = document.querySelector('.sort-select');
if (sortSelect) {
    sortSelect.addEventListener('change', function() {
        const sortType = this.value;
        sortNews(sortType);
    });
}

function sortNews(type) {
    const newsList = document.querySelector('.news-list');
    const newsItems = Array.from(document.querySelectorAll('.news-item'));
    
    newsItems.sort((a, b) => {
        if (type === 'latest') {
            // Sort by date (assuming data-date attribute exists)
            const dateA = new Date(a.querySelector('.news-date').textContent);
            const dateB = new Date(b.querySelector('.news-date').textContent);
            return dateB - dateA;
        } else if (type === 'popular') {
            // Sort by views
            const viewsA = parseInt(a.querySelector('.news-stats span').textContent.replace('K', '000'));
            const viewsB = parseInt(b.querySelector('.news-stats span').textContent.replace('K', '000'));
            return viewsB - viewsA;
        } else if (type === 'oldest') {
            // Sort by date ascending
            const dateA = new Date(a.querySelector('.news-date').textContent);
            const dateB = new Date(b.querySelector('.news-date').textContent);
            return dateA - dateB;
        }
    });
    
    // Clear and re-append sorted items
    newsList.innerHTML = '';
    newsItems.forEach(item => newsList.appendChild(item));
    
    showNotification('Berita diurutkan berdasarkan ' + type, 'success');
}

// Popular News Click Tracking
document.querySelectorAll('.popular-item').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        const title = this.querySelector('h4').textContent;
        console.log('Popular news clicked:', title);
        // In real app, navigate to article or track analytics
    });
});

// Read More Click Tracking
document.querySelectorAll('.read-more').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const article = this.closest('.news-item, .news-card');
        const title = article.querySelector('h2, h3').textContent;
        console.log('Read more clicked:', title);
        
        // Show loading
        const hideLoading = showLoading(this);
        
        // Simulate loading article
        setTimeout(() => {
            hideLoading();
            showNotification('Membuka artikel...', 'info');
        }, 1000);
    });
});

// Like/Favorite functionality
document.querySelectorAll('.news-item, .news-card').forEach(item => {
    const heartIcon = item.querySelector('.fa-heart');
    if (heartIcon) {
        heartIcon.style.cursor = 'pointer';
        heartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            this.classList.toggle('fas');
            this.classList.toggle('far');
            
            if (this.classList.contains('fas')) {
                this.style.color = '#ff6b9d';
                showNotification('Ditambahkan ke favorit', 'success');
            } else {
                this.style.color = '';
                showNotification('Dihapus dari favorit', 'info');
            }
        });
    }
});

// History Item Click
document.querySelectorAll('.history-item').forEach(item => {
    item.addEventListener('click', function() {
        // Remove active from all
        document.querySelectorAll('.history-item').forEach(i => i.classList.remove('active'));
        
        // Add active to clicked
        this.classList.add('active');
        
        const title = this.querySelector('h4').textContent;
        console.log('History item clicked:', title);
    });
});

// Smooth scroll animations for news items
const newsObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }, index * 100);
            newsObserver.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.1
});

document.querySelectorAll('.news-item').forEach(item => {
    item.style.opacity = '0';
    item.style.transform = 'translateY(30px)';
    item.style.transition = 'all 0.6s ease';
    newsObserver.observe(item);
});

console.log('📰 News page initialized');


