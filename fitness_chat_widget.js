// Create and inject the chat widget HTML
function injectChatWidget() {
    const widgetHTML = `
        <div class="chat-widget-button" id="chat-widget-button">
            <i class="fas fa-comments"></i>
        </div>
        <div class="chat-container" id="chat-container">
            <div class="chat-header">
                <h1>Fitness AI Guru</h1>
                <p>Ask me anything about fitness, workouts, nutrition, and health!</p>
            </div>
            <div class="chat-messages" id="chat-messages">
                <div class="message bot">
                    <div class="message-content">
                        Hello! I'm your fitness assistant. I can help you with workout plans, nutrition advice, and general fitness questions. What would you like to know?
                    </div>
                </div>
            </div>
            <div class="chat-input-container">
                <textarea id="user-input" placeholder="Type your fitness question." rows="2"></textarea>
                <button id="send-button">Send</button>
            </div>
        </div>
    `;

    // Create container for the widget
    const widgetContainer = document.createElement('div');
    widgetContainer.id = 'fitness-chat-widget';
    widgetContainer.innerHTML = widgetHTML;
    document.body.appendChild(widgetContainer);

    // Load required resources
    loadResource('chatting.min.js', 'js');
    loadResource('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', 'css');
    loadResource('fitness_chat.css', 'css');
    loadResource('fitness_chat.js', 'js');
}

// Helper function to load external resources
function loadResource(url, type) {
    if (type === 'js') {
        const script = document.createElement('script');
        script.src = url;
        script.async = true;
        document.head.appendChild(script);
    } else if (type === 'css') {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = url;
        document.head.appendChild(link);
    }
}

// Initialize the widget when the page loads
document.addEventListener('DOMContentLoaded', () => {
    injectChatWidget();
    
    // Add click handler for the chat button after a short delay to ensure other scripts are loaded
    setTimeout(() => {
        const chatButton = document.getElementById('chat-widget-button');
        const chatContainer = document.getElementById('chat-container');
        
        chatButton.addEventListener('click', () => {
            chatContainer.classList.toggle('active');
        });
    }, 1000);
}); 