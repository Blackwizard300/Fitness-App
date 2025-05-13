// Simple state management
let chatState = {
    isInitialized: false,
    isVisible: false,
    isProcessing: false
};

// API key - Replace with your actual API key
const API_KEY = 'AIzaSyCKyaFCKqRoqLCqSs7V817U1uDTYAJzCh0';

// Initialize chat interface
function initializeChat() {
    const chatButton = document.getElementById('chat-widget-button');
    const chatContainer = document.getElementById('chat-container');
    const closeButton = document.getElementById('close-chat');
    const chatMessages = document.getElementById('chat-messages');
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-button');

    // Check if all elements exist
    if (!chatButton || !chatContainer || !closeButton || !chatMessages || !userInput || !sendButton) {
        console.error('Missing chat elements');
        return;
    }

    // Set initial state
    chatContainer.style.display = 'none';
    chatState.isInitialized = true;

    // Toggle chat visibility
    function toggleChat() {
        chatState.isVisible = !chatState.isVisible;
        chatContainer.style.display = chatState.isVisible ? 'flex' : 'none';
        if (chatState.isVisible) {
            userInput.focus();
        }
    }

    // Add message to chat
    function addMessage(text, isUser) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
        
        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        messageContent.textContent = text;
        
        messageDiv.appendChild(messageContent);
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Process user message
    async function processMessage(userMessage) {
        if (chatState.isProcessing) return;
        
        try {
            chatState.isProcessing = true;
            sendButton.disabled = true;
            sendButton.textContent = 'Sending...';

            const requestBody = {
                contents: [{
                    role: "user",
                    parts: [{
                        text: `You are a fitness assistant focused exclusively on fitness, workouts, nutrition, and health topics. 

Important Instructions:
1. ONLY answer questions related to fitness, workouts, nutrition, exercise, health, and wellness.
2. If the user asks about ANY other topic (like politics, entertainment, technology, etc.), respond with:
"I am a fitness-focused assistant. I can only help you with questions about fitness, workouts, nutrition, and health. Please ask me something related to these topics instead!"
3. For fitness-related questions, provide helpful, accurate, and encouraging responses.

User message: ${userMessage}`
                    }]
                }],
                generationConfig: {
                    temperature: 0.7,
                    topK: 40,
                    topP: 0.95,
                    maxOutputTokens: 1024,
                }
            };

            console.log('Sending request:', requestBody);

            const response = await fetch('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyCKyaFCKqRoqLCqSs7V817U1uDTYAJzCh0', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestBody)
            });

            console.log('Response status:', response.status);
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('API Error:', errorText);
                throw new Error(`API request failed with status ${response.status}`);
            }

            const data = await response.json();
            console.log('API Response:', data);

            if (data.candidates && data.candidates.length > 0) {
                const botResponse = data.candidates[0].content.parts[0].text;
                addMessage(botResponse, false);
            } else {
                console.error('Invalid response format:', data);
                throw new Error('Invalid response format from API');
            }

        } catch (error) {
            console.error('Error details:', error);
            addMessage("I'm sorry, I'm having trouble connecting right now. Please try again in a few moments.", false);
        } finally {
            chatState.isProcessing = false;
            sendButton.disabled = false;
            sendButton.textContent = 'Send';
        }
    }

    // Handle user input
    function handleUserInput(event) {
        event.preventDefault();
        const message = userInput.value.trim();
        
        if (!message || chatState.isProcessing) return;
        
        addMessage(message, true);
        userInput.value = '';
        userInput.style.height = 'auto';
        
        processMessage(message);
    }

    // Event Listeners
    chatButton.addEventListener('click', toggleChat);
    closeButton.addEventListener('click', toggleChat);
    
    sendButton.addEventListener('click', handleUserInput);
    
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            handleUserInput(e);
        }
    });

    userInput.addEventListener('input', () => {
        userInput.style.height = 'auto';
        userInput.style.height = Math.min(userInput.scrollHeight, 150) + 'px';
    });

    // Add initial message
    addMessage("Hello! I'm your fitness assistant. How can I help you today?", false);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initializeChat);
