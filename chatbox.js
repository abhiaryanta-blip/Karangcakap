// ============================================
// CHATBOX PAGE - JavaScript
// ============================================

let conversationHistory = [];

document.addEventListener('DOMContentLoaded', function() {
    initChatbox();
});

// Initialize Chatbox
function initChatbox() {
    console.log('💬 Chatbox initialized');
    
    // Auto-scroll to bottom on load
    scrollToBottom();
    
    // Load conversation history from localStorage
    loadConversationHistory();
}

// Send Message
function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Add user message to chat
    addMessage(message, 'user');
    
    // Clear input
    input.value = '';
    input.style.height = 'auto';
    
    // Hide suggested questions if visible
    const suggestions = document.querySelector('.suggested-questions');
    if (suggestions) {
        suggestions.style.display = 'none';
    }
    
    // Show typing indicator
    showTypingIndicator();
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    
    // Send message to backend API
    fetch('/api/chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            message: message
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        hideTypingIndicator();
        
        if (data.success) {
            const response = data.response;
            addMessage(response, 'ai');
            
            // Save to history
            conversationHistory.push({
                user: message,
                ai: response,
                timestamp: new Date().toISOString()
            });
            saveConversationHistory();
        } else {
            addMessage(data.error || 'Terjadi kesalahan saat memproses pertanyaan.', 'ai');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        hideTypingIndicator();
        addMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi. Error: ' + error.message, 'ai');
    });
}

// Add Message to Chat
function addMessage(text, sender) {
    const messagesContainer = document.getElementById('chatMessages');
    const messageGroup = document.createElement('div');
    messageGroup.className = `message-group ${sender}`;
    
    const avatar = document.createElement('div');
    avatar.className = 'message-avatar';
    avatar.innerHTML = sender === 'user' 
        ? '<i class="fas fa-user"></i>' 
        : '<i class="fas fa-robot"></i>';
    
    const content = document.createElement('div');
    content.className = 'message-content';
    
    const bubble = document.createElement('div');
    bubble.className = 'message-bubble';
    
    // Parse message for formatting
    bubble.innerHTML = parseMessage(text);
    
    const time = document.createElement('span');
    time.className = 'message-time';
    time.textContent = getCurrentTime();
    
    content.appendChild(bubble);
    content.appendChild(time);
    
    messageGroup.appendChild(avatar);
    messageGroup.appendChild(content);
    
    // Add with animation
    messageGroup.style.opacity = '0';
    messageGroup.style.transform = 'translateY(20px)';
    messagesContainer.appendChild(messageGroup);
    
    setTimeout(() => {
        messageGroup.style.transition = 'all 0.3s ease';
        messageGroup.style.opacity = '1';
        messageGroup.style.transform = 'translateY(0)';
    }, 10);
    
    scrollToBottom();
}

// Parse Message for Formatting
function parseMessage(text) {
    // Convert markdown-like syntax to HTML
    text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');
    text = text.replace(/\n/g, '<br>');
    
    // Convert bullet points
    if (text.includes('- ')) {
        const lines = text.split('<br>');
        let inList = false;
        let result = '';
        
        lines.forEach(line => {
            if (line.trim().startsWith('- ')) {
                if (!inList) {
                    result += '<ul>';
                    inList = true;
                }
                result += '<li>' + line.trim().substring(2) + '</li>';
            } else {
                if (inList) {
                    result += '</ul>';
                    inList = false;
                }
                result += line + '<br>';
            }
        });
        
        if (inList) result += '</ul>';
        text = result;
    }
    
    return text;
}

// Generate AI Response (Simulated)
function generateAIResponse(userMessage) {
    const lowerMessage = userMessage.toLowerCase();
    
    // Responses about coral reefs
    if (lowerMessage.includes('terumbu karang') || lowerMessage.includes('karang') || lowerMessage.includes('coral')) {
        return `🪸 **Tentang Terumbu Karang:**\n\n` +
               `Terumbu karang adalah struktur kompleks yang terbentuk dari koloni organisme laut yang disebut polip karang. Mereka adalah ekosistem laut yang sangat penting karena:\n\n` +
               `- Menjadi rumah bagi 25% spesies laut meskipun hanya mencakup 0.1% permukaan laut\n` +
               `- Melindungi garis pantai dari erosi dan badai\n` +
               `- Menyediakan sumber makanan dan mata pencaharian bagi jutaan orang\n` +
               `- Berpotensi sebagai sumber obat-obatan baru\n\n` +
               `Apakah ada aspek tertentu tentang terumbu karang yang ingin Anda ketahui lebih lanjut?`;
    }
    
    // Responses about clownfish
    if (lowerMessage.includes('clown') || lowerMessage.includes('badut') || lowerMessage.includes('nemo')) {
        return `🐠 **Ikan Badut (Clownfish):**\n\n` +
               `Ikan badut adalah salah satu ikan terumbu karang paling terkenal! Fakta menarik:\n\n` +
               `- Hidup bersimbiosis dengan anemon laut yang beracun\n` +
               `- Memiliki lendir khusus yang melindungi mereka dari sengatan anemon\n` +
               `- Semua ikan badut lahir sebagai jantan dan dapat berubah menjadi betina\n` +
               `- Betina adalah yang terbesar dalam kelompok\n` +
               `- Mereka sangat protektif terhadap telur-telur mereka\n\n` +
               `Ikan badut dapat ditemukan di perairan hangat Samudra Pasifik dan Hindia.`;
    }
    
    // Responses about conservation
    if (lowerMessage.includes('melindungi') || lowerMessage.includes('konservasi') || lowerMessage.includes('melestarikan')) {
        return `🛡️ **Konservasi Biota Laut:**\n\n` +
               `Melindungi ekosistem laut sangat penting! Berikut beberapa cara yang dapat dilakukan:\n\n` +
               `- Kurangi penggunaan plastik sekali pakai\n` +
               `- Dukung kawasan konservasi laut\n` +
               `- Pilih seafood yang berkelanjutan\n` +
               `- Jangan membuang sampah ke laut\n` +
               `- Gunakan sunscreen yang ramah terumbu karang\n` +
               `- Edukasi orang lain tentang pentingnya laut\n` +
               `- Dukung organisasi konservasi laut\n\n` +
               `Setiap tindakan kecil dapat membuat perbedaan besar untuk masa depan laut kita! 🌊`;
    }
    
    // Responses about climate change
    if (lowerMessage.includes('iklim') || lowerMessage.includes('pemanasan') || lowerMessage.includes('climate')) {
        return `🌡️ **Perubahan Iklim & Laut:**\n\n` +
               `Perubahan iklim memiliki dampak signifikan terhadap ekosistem laut:\n\n` +
               `- **Pemutihan Karang:** Suhu air yang meningkat menyebabkan karang mengeluarkan alga simbiotiknya\n` +
               `- **Pengasaman Laut:** CO2 yang diserap laut membuat air lebih asam, merusak kerangka karang\n` +
               `- **Perubahan Arus:** Mengubah pola distribusi nutrisi dan migrasi ikan\n` +
               `- **Naiknya Permukaan Laut:** Mengancam habitat pesisir\n\n` +
               `Namun, ada harapan! Penelitian menunjukkan beberapa spesies karang dapat beradaptasi dengan kondisi baru.`;
    }
    
    // Responses about fish types
    if (lowerMessage.includes('jenis ikan') || lowerMessage.includes('spesies') || lowerMessage.includes('macam ikan')) {
        return `🐟 **Keanekaragaman Ikan di Terumbu Karang:**\n\n` +
               `Terumbu karang adalah rumah bagi ribuan spesies ikan! Beberapa yang populer:\n\n` +
               `- **Ikan Badut:** Bersimbiosis dengan anemon\n` +
               `- **Ikan Parrot:** Memakan alga dari karang\n` +
               `- **Ikan Pari:** Hidup di dasar pasir dekat karang\n` +
               `- **Ikan Moorish Idol:** Dengan sirip punggung yang panjang\n` +
               `- **Ikan Butterfly:** Warna-warni dan berpasangan\n` +
               `- **Ikan Surgeon:** Memiliki duri tajam di ekor\n\n` +
               `Indonesia sendiri memiliki lebih dari 3,000 spesies ikan! Apakah ada spesies tertentu yang ingin Anda ketahui?`;
    }
    
    // Responses about Raja Ampat
    if (lowerMessage.includes('raja ampat') || lowerMessage.includes('papua')) {
        return `🏝️ **Raja Ampat - Surga Bawah Laut:**\n\n` +
               `Raja Ampat di Papua Barat adalah salah satu lokasi diving terbaik di dunia!\n\n` +
               `- Memiliki **75% spesies karang dunia**\n` +
               `- Lebih dari **1,500 spesies ikan**\n` +
               `- Bagian dari Coral Triangle, pusat keanekaragaman hayati laut\n` +
               `- Memiliki beberapa kawasan konservasi laut\n` +
               `- Air yang jernih dengan visibility hingga 30 meter\n\n` +
               `Program konservasi di Raja Ampat menunjukkan hasil yang sangat baik dalam pemulihan terumbu karang!`;
    }
    
    // Default response
    const defaultResponses = [
        `Terima kasih atas pertanyaannya! Saya adalah AI assistant yang dilatih untuk membantu Anda memahami dunia biota laut. Pertanyaan Anda sangat menarik! Bisakah Anda memberikan lebih banyak detail agar saya dapat memberikan informasi yang lebih spesifik?`,
        
        `Itu pertanyaan yang bagus tentang kehidupan laut! 🌊 Saya akan senang membantu. Untuk memberikan jawaban yang lebih akurat, bisakah Anda menjelaskan lebih lanjut aspek apa yang paling menarik bagi Anda?`,
        
        `Saya tertarik dengan pertanyaan Anda! Dunia bawah laut penuh dengan keajaiban. Apakah Anda ingin tahu lebih banyak tentang:\n- Terumbu karang dan ekosistemnya\n- Spesies ikan tertentu\n- Konservasi laut\n- Dampak perubahan iklim\n- Atau topik lain tentang biota laut?`
    ];
    
    return defaultResponses[Math.floor(Math.random() * defaultResponses.length)];
}

// Show Typing Indicator
function showTypingIndicator() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) {
        indicator.style.display = 'flex';
        scrollToBottom();
    }
}

// Hide Typing Indicator
function hideTypingIndicator() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) {
        indicator.style.display = 'none';
    }
}

// Scroll to Bottom
function scrollToBottom() {
    const messagesContainer = document.getElementById('chatMessages');
    setTimeout(() => {
        messagesContainer.scrollTo({
            top: messagesContainer.scrollHeight,
            behavior: 'smooth'
        });
    }, 100);
}

// Get Current Time
function getCurrentTime() {
    const now = new Date();
    return now.getHours().toString().padStart(2, '0') + ':' + 
           now.getMinutes().toString().padStart(2, '0');
}

// Ask Suggested Question
function askQuestion(question) {
    const input = document.getElementById('messageInput');
    input.value = question;
    input.focus();
    sendMessage();
}

// New Chat
function newChat() {
    if (confirm('Mulai percakapan baru? Riwayat chat saat ini akan disimpan.')) {
        // Save current conversation
        if (conversationHistory.length > 0) {
            saveConversationToHistory();
        }
        
        // Clear messages
        const messagesContainer = document.getElementById('chatMessages');
        const messages = messagesContainer.querySelectorAll('.message-group');
        messages.forEach(msg => msg.remove());
        
        // Reset conversation
        conversationHistory = [];
        
        // Show welcome message and suggestions again
        location.reload();
    }
}

// Save Conversation History
function saveConversationHistory() {
    localStorage.setItem('currentConversation', JSON.stringify(conversationHistory));
}

// Load Conversation History
function loadConversationHistory() {
    const saved = localStorage.getItem('currentConversation');
    if (saved) {
        conversationHistory = JSON.parse(saved);
    }
}

// Save to Chat History Sidebar
function saveConversationToHistory() {
    let chatHistory = JSON.parse(localStorage.getItem('chatHistory') || '[]');
    
    const firstMessage = conversationHistory[0];
    if (firstMessage) {
        chatHistory.unshift({
            title: firstMessage.user.substring(0, 50),
            preview: firstMessage.user,
            timestamp: new Date().toISOString(),
            messages: conversationHistory
        });
        
        // Keep only last 10 conversations
        chatHistory = chatHistory.slice(0, 10);
        localStorage.setItem('chatHistory', JSON.stringify(chatHistory));
    }
}

// Toggle Info Panel
function toggleInfo() {
    const infoPanel = document.getElementById('chatInfo');
    if (infoPanel) {
        infoPanel.classList.toggle('active');
    }
}

// Handle Emoji Button
document.querySelector('.btn-emoji')?.addEventListener('click', function() {
    showNotification('Emoji picker akan segera hadir! 😊', 'info');
});

// Handle Attach Button
document.querySelector('.btn-attach')?.addEventListener('click', function() {
    showNotification('Fitur lampiran akan segera hadir! 📎', 'info');
});

// History Item Click
document.querySelectorAll('.history-item').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.history-item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
        
        // In real app, load conversation from history
        showNotification('Memuat percakapan...', 'info');
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('messageInput')?.focus();
    }
    
    // Escape to clear input
    if (e.key === 'Escape') {
        const input = document.getElementById('messageInput');
        if (input) {
            input.value = '';
            input.blur();
        }
    }
});

// Voice input (placeholder)
function startVoiceInput() {
    showNotification('Fitur voice input akan segera hadir! 🎤', 'info');
}

console.log('💬 Chatbox ready! Type your questions about marine life.');


