# 🌊 KARANG CAKAP - Portal Berita Biota Laut

Website frontend modern dengan tema biota laut yang menyediakan berita terkini tentang kehidupan laut, terumbu karang, dan fitur chatbot AI untuk menjawab pertanyaan seputar ekosistem laut.

## ✨ Fitur Utama

### 🔐 Halaman Login
- Desain modern dan menarik dengan tema ocean
- Animasi interaktif biota laut
- Opsi login dengan Google dan Facebook
- Form validasi
- Animasi sukses saat login berhasil
- Responsive design

### 🏠 Halaman Beranda
- Hero section yang eye-catching dengan background ocean
- Section fitur unggulan
- Preview berita terbaru
- Statistik dengan counter animation
- Design modern dan professional

### 📰 Halaman Berita
- Filter berita berdasarkan kategori:
  - Terumbu Karang
  - Ikan & Biota
  - Konservasi
  - Penelitian
  - Iklim
- Pencarian berita real-time
- Sorting (Terbaru, Terpopuler, Terlama)
- Sidebar dengan berita populer
- Newsletter subscription
- Pagination
- Card berita yang informatif dengan metadata lengkap

### 💬 Chatbox AI
- AI Assistant untuk menjawab pertanyaan tentang:
  - Terumbu karang
  - Berbagai spesies biota laut
  - Konservasi laut
  - Dampak perubahan iklim
  - Dan topik lainnya seputar laut
- Riwayat chat
- Pertanyaan yang disarankan (suggested questions)
- Typing indicator
- UI modern seperti aplikasi chat professional
- Auto-scroll dan time stamps
- Parsing markdown untuk format pesan

## 🎨 Design Features

- **Color Scheme**: Ocean-inspired blues, teals, dan coral accents
- **Modern UI**: Card-based design dengan shadows dan hover effects
- **Smooth Animations**: Fade-in, slide-in, dan interactive animations
- **Responsive**: Mobile-first design yang sempurna di semua devices
- **Icons**: Font Awesome 6 untuk icons yang comprehensive
- **Typography**: Segoe UI untuk readability yang optimal
- **Gradients**: Ocean gradients untuk aesthetic yang menarik

## 🚀 Cara Menggunakan

### 1. Setup Sederhana
Tidak perlu instalasi dependencies! Hanya perlu web browser.

```bash
# Clone atau download project
# Buka login.html di browser
```

### 2. Struktur File
```
chatbox/
├── index.html          # Halaman beranda
├── login.html          # Halaman login
├── news.html           # Halaman berita
├── chatbox.html        # Halaman chatbox AI
├── styles.css          # Main stylesheet
├── script.js           # Main JavaScript
├── news.js             # News page JavaScript
├── chatbox.js          # Chatbox functionality
└── README.md           # Documentation
```

### 3. Navigasi Website

1. **Login**: Buka `login.html`
   - Masukkan email dan password (untuk demo, gunakan email dan password apa saja)
   - Klik "Masuk" atau gunakan opsi sosial media

2. **Beranda**: Setelah login, Anda akan diarahkan ke `index.html`
   - Jelajahi fitur-fitur
   - Lihat preview berita
   - Navigasi ke halaman lain

3. **Berita**: Klik menu "Berita"
   - Filter berdasarkan kategori
   - Cari berita dengan search bar
   - Urutkan berita
   - Subscribe newsletter

4. **AI Chat**: Klik menu "AI Chat"
   - Ketik pertanyaan tentang biota laut
   - Gunakan suggested questions
   - AI akan merespons dengan informasi yang relevan

## 🎯 Fitur Teknis

### Authentication
- LocalStorage untuk menyimpan status login
- Auto-redirect jika belum login
- Logout functionality

### Data Persistence
- Riwayat chat disimpan di localStorage
- Newsletter subscriptions tracking
- User preferences

### Interactive Features
- Real-time search filtering
- Category filtering dengan smooth animations
- Smooth scroll behavior
- Lazy loading untuk performance
- Intersection Observer untuk scroll animations

### Responsive Breakpoints
- Desktop: 1200px+
- Tablet: 768px - 1024px
- Mobile: < 768px

## 🛠️ Customization

### Mengubah Warna Theme
Edit CSS variables di `styles.css`:

```css
:root {
    --primary-color: #0077be;      /* Warna utama */
    --secondary-color: #00b4d8;    /* Warna sekunder */
    --accent-color: #48cae4;       /* Warna aksen */
    --coral-color: #ff6b9d;        /* Warna coral */
}
```

### Menambah Berita
Edit `news.html`, tambahkan artikel baru:

```html
<article class="news-item" data-category="coral">
    <div class="news-item-image" style="background-image: url('URL_GAMBAR');"></div>
    <div class="news-item-content">
        <!-- Content here -->
    </div>
</article>
```

### Menambah AI Responses
Edit `chatbox.js`, tambahkan di function `generateAIResponse()`:

```javascript
if (lowerMessage.includes('keyword')) {
    return `Response text here`;
}
```

## 🌟 Best Practices

1. **Performance**
   - Images di-lazy load
   - Minimal external dependencies
   - Efficient CSS animations

2. **Accessibility**
   - Semantic HTML
   - ARIA labels (dapat ditambahkan)
   - Keyboard navigation support

3. **UX**
   - Smooth transitions
   - Loading states
   - Success/error notifications
   - Intuitive navigation

## 📱 Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Opera

## 🔄 Future Enhancements

Fitur yang dapat ditambahkan:
- [ ] Backend API integration
- [ ] Real AI/ML model integration
- [ ] User registration dan profile
- [ ] Social sharing features
- [ ] Comments system
- [ ] Bookmark/favorite articles
- [ ] Dark mode toggle
- [ ] Multi-language support
- [ ] Push notifications
- [ ] Voice input untuk chatbox
- [ ] Image upload di chatbox
- [ ] Advanced search dengan filters

## 💡 Tips Penggunaan

1. **Untuk Development**:
   - Gunakan Live Server extension di VS Code
   - Buka DevTools untuk debugging
   - Test di berbagai screen sizes

2. **Untuk Production**:
   - Minify CSS dan JavaScript
   - Optimize images
   - Setup CDN untuk assets
   - Implement proper backend API
   - Add analytics tracking

## 📄 License

Project ini dibuat untuk keperluan demonstrasi dan pembelajaran.

## 👨‍💻 Developer Notes

- Pure HTML, CSS, JavaScript (No frameworks)
- Modern ES6+ JavaScript
- CSS Grid dan Flexbox untuk layouts
- Font Awesome untuk icons
- Unsplash untuk placeholder images
- LocalStorage untuk data persistence

## 🐛 Known Issues

- AI responses adalah simulated (tidak menggunakan real AI)
- Images menggunakan placeholder dari Unsplash
- Login adalah demo (tidak ada real authentication)

## 🎓 Learning Resources

Website ini menggunakan:
- CSS Grid & Flexbox
- JavaScript ES6+
- LocalStorage API
- Intersection Observer API
- CSS Animations & Transitions
- Responsive Design principles

---

**Dibuat dengan ❤️ untuk konservasi laut dan edukasi biota laut**

🌊 Jelajahi keajaiban dunia bawah laut! 🐠
